# NOTE: This sample depends upon the `rest-client` gem
#       The gem can be installed for free using the following ruby command:
#       > gem install rest-client
require 'rest-client'
require 'json'

apiKey = 'YOUR_API_KEY_HERE'
companyId = 'YOUR_COMPANY_ID_HERE'
baseUrl = 'https://secure.ontime360.com/sites/' + companyId + '/api/'
authHeader = {'Authorization', apiKey}

# get id of order with tracking number 4787
orderid = JSON.parse(RestClient.get(baseUrl + 'orders?trackingNumber=4787', authHeader))

if orderid.length == 0
	raise 'No order with specified tracking number found.'
end

# get order info from order with response id
order = JSON.parse(RestClient.get(baseUrl + 'orders/' + orderid[0], authHeader))

# update the order description
order['Description'] += ' Customer Reference# 614852'

# post the new order object to the api with newly specified headers
postHeader = {'content_type': 'json', 'accept': 'json'}
postHeader.merge(authHeader)
response = RestClient.post(baseUrl + 'order/post', JSON.generate(order), postHeader)

puts 'Order was successfully updated!'

