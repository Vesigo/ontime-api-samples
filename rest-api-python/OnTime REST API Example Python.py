# NOTE: This sample depends upon the `requests` Python library
#       The library can be installed for free at the following URL:
#       http://docs.python-requests.org/en/master/user/install/

import requests

apiKey = 'YOUR_API_KEY_HERE'
companyId = 'YOUR_COMPANY_ID_HERE'
baseUrl = 'https://secure.ontime360.com/sites/' + companyId + '/api/'
authHeader = {'Authorization': apiKey}

# get id of order with tracking number 4787
orderid = requests.get(url = baseUrl + "orders?trackingNumber=4787", headers=authHeader).json()

if len(orderid) == 0:
    raise Exception('No order with specified tracking number found.')

# get order info from order with response id
order = requests.get(url = baseUrl + "orders/" + orderid[0], headers=authHeader).json()

# update the order description
order['Description'] += ' Customer Reference# 614852'

# post the new order object to the api
response = requests.post(baseUrl + 'order/post', headers=authHeader, json=order)

print('Order was successfully updated!')
