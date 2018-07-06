using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace OnTime_REST_API_Example_ASP.NET
{
    public partial class Main : System.Web.UI.Page
    {
        private static string _apiKey = "YOUR_API_KEY_HERE";
        private static string _companyId = "YOUR_COMPANY_NAME_HERE";
        private static string _baseUrl = "https://secure.ontime360.com/sites/" + _companyId + "/api/";

        protected void Page_Load(object sender, EventArgs e)
        {
            this.LoadComplete += (s, eventArgs) =>
            {
                // Create a new instance of WebClient.
                WebClient client = new WebClient();

                // Add the API key to the Authorization header of the request if the account does not allow anonymous access.
                client.Headers.Add(HttpRequestHeader.Authorization, _apiKey);
                try
                {
                    // Query the API for the ID of an order with the tracking number 4787, and deserialize the JSON response.
                    var orders = JsonConvert.DeserializeObject<Guid[]>(client.DownloadString(_baseUrl + "orders?trackingNumber=4787"));
                    if (orders.Length > 0)
                    {
                        // Query the API for the order object, and deserialize the JSON response.
                        var order = JObject.Parse(client.DownloadString(_baseUrl + "orders/" + orders[0].ToString()));
                        if (order != null)
                        {
                            // Append a value to the order's description
                            order["Description"] += "Customer Reference# 614852";

                            // Set the ContentType header of the request to application/json
                            client.Headers.Add(HttpRequestHeader.ContentType, "application/json");

                            // Post the updated order as a JSON object.
                            client.UploadString(_baseUrl + "order/post", order.ToString());
                            lblStatus.Text = "Successfully updated the order!";
                        }
                        else
                        {
                            lblStatus.Text = "An error has occurred: No order with tracking number 4787.";
                        }
                    }
                    else
                    {
                        lblStatus.Text = "An error has occurred: No order with tracking number 4787.";
                    }
                }
                catch (WebException wex)
                {
                    lblStatus.Text = "A web exception has occurred: " + wex.Message;
                }
                catch (Exception ex)
                {
                    lblStatus.Text = "An exception has occurred: " + ex.Message;
                }
            };
        }
    }
}