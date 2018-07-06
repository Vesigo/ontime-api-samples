<?php
    echo '<h1>Tracking# 4787</h2><br /><div id="lblSuccess">Adding "Customer Reference# 614852" to the order description. Please wait.</div>';
	$apiKey = 'YOUR_API_KEY_HERE';
	$companyId = 'YOUR_COMPANY_ID_HERE';
    $baseUrl = 'https://secure.ontime360.com/sites/' . $companyId . '/api/';
    
    try {
        // Initialize cURL.
        $curl = curl_init();
        
		// Setup cURL for GET operations.
		$headers = [
			'Authorization: ' . $apiKey,
            'Content-Type: application/json'
        ];

        curl_setopt($curl, CURLOPT_URL, $baseUrl . 'orders?trackingNumber=4787');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        // Query the REST API for the ID of an order with the tracking number 4787.
        $orders = json_decode(curl_exec($curl));
        if (count($orders) > 0) {
            // Change cURL url to get full order object.
            curl_setopt($curl, CURLOPT_URL, $baseUrl . 'orders/' . $orders[0]);
            
            // Query the REST API for the order object.
            $order = json_decode(curl_exec($curl));
            if (!is_null($order)) {
                // Append a value to the order's description.
                $order->Description .= 'Customer Reference# 614852';
                
                // Setup cURL for post operations.
                curl_setopt($curl, CURLOPT_URL, $baseUrl . 'order/post');
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($order));

                // Update the order.
                $result = curl_exec($curl);
                curl_close($curl);
                ob_end_clean();
                if (!is_null($result)) {
                    echo '<h1>Tracking# 4787</h2><br /><div id="lblSuccess">Successfully updated the order!</div>';
                } else {
                    echo '<h1>Tracking# 4787</h2><br /><div id="lblSuccess">An error has occurred: No order with tracking number 4787.</div>';
                }
            } else {
                ob_end_clean();
                echo '<h1>Tracking# 4787</h2><br /><div id="lblSuccess">An error has occurred: No order with tracking number 4787.</div>';
            } 
        } else {ob_end_clean();
            
            echo '<h1>Tracking# 4787</h2><br /><div id="lblSuccess">An error has occurred: No order with tracking number 4787.</div>';
        }    
    } catch (Exception $ex) {
        ob_end_clean();
        echo 'A web exception has occurred: ' . $ex->getMessage();
    }