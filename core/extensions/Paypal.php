<?php

class Paypal extends CApplicationComponent
{
//     public $email;
    public $username;
    public $password;
    public $signature;
    public $environment;    
    
    public function __construct()
    {
    	$settings = Yii::app()->controller->settings;
    	
//     	$this->email		=	$settings['paypal_email'];
    	$this->username		=	$settings['paypal_username'];
    	$this->password		= 	$settings['paypal_password'];
    	$this->signature 	=	$settings['paypal_signature'];
    	$this->environment 	= 	$settings['paypal_sandbox_mode'] == 1 ? 'sandbox' : 'live';
    }
    
    /**
     * Send HTTP POST Request
     *
     * @param	string	The API method name
     * @param	string	The POST Message fields in &name=value pair format
     * @return	array	Parsed HTTP Response body
     */
    public function PPHttpPost($methodName_, $nvpStr_)
    {
    	// Set up your API credentials, PayPal end point, and API version.
    	$API_UserName = urlencode($this->username);
    	$API_Password = urlencode($this->password);
    	$API_Signature = urlencode($this->signature);
    	$API_Endpoint = "https://api-3t.paypal.com/nvp";
    	if("sandbox" === $this->environment || "beta-sandbox" === $this->environment) {
    		$API_Endpoint = "https://api-3t.".$this->environment.".paypal.com/nvp";
    	}
    	$version = urlencode('51.0');

    	// Set the curl parameters.
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
    	curl_setopt($ch, CURLOPT_VERBOSE, 1);
    
    	// Turn off the server and peer verification (TrustManager Concept).
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_POST, 1);
    
    	// Set the API operation, version, and API signature in the request.
    	$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
    
    	// Set the request as a POST FIELD for curl.
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
    
    	// Get response from the server.
    	$httpResponse = curl_exec($ch);
    
    	if(!$httpResponse) {
    		exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
    	}
    
    	// Extract the response details.
    	$httpResponseAr = explode("&", $httpResponse);
    
    	$httpParsedResponseAr = array();
    	foreach ($httpResponseAr as $i => $value) {
    		$tmpAr = explode("=", $value);
    		if(sizeof($tmpAr) > 1) {
    			$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
    		}
    	}
    
    	if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
    		exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
    	}
    
    	return $httpParsedResponseAr;
    }
    
    
    // get checkout link 
    public function checkout($array) {
	    // Set request-specific fields.
	    $paymentAmount = urlencode($array['amount']);
	    $currencyID = urlencode('USD');							// or other currency code ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
	    $paymentType = urlencode('Sale');				// or 'Sale' or 'Order' or 'Authorization'
	    
	    $returnURL = urlencode($array["returnurl"]);
	    $cancelURL = urlencode($array["cancelurl"]);
	    
	    // Add request-specific fields to the request string.
	    // "&PAYMENTACTION=".$paymentType.
	    $nvpStr = "";
	    $nvpStr .= "&Amt=".$paymentAmount;
	    $nvpStr .= "&ReturnUrl=".$returnURL;
	    $nvpStr .= "&CANCELURL=".$cancelURL;
	    $nvpStr .= "&CURRENCYCODE=".$currencyID;
	    $nvpStr .= "&PAYMENTACTION=".$paymentType;
	    
	    $nvpStr .= "&PAYMENTREQUEST_0_AMT=".$paymentAmount;
	    $nvpStr .= "&PAYMENTREQUEST_0_CURRENCYCODE".$currencyID;
	    $nvpStr .= "&PAYMENTREQUEST_0_PAYMENTACTION=".$paymentType;
	    
	    // Execute the API operation; see the PPHttpPost function above.
	    $httpParsedResponseAr = $this->PPHttpPost('SetExpressCheckout', $nvpStr);
	    
	    if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
	    	// Redirect to paypal.com.
	    	$token = urldecode($httpParsedResponseAr["TOKEN"]);
	    	$payPalURL = "https://www.paypal.com/webscr&cmd=_express-checkout&token=$token";
	    	if("sandbox" === $this->environment || "beta-sandbox" === $this->environment) {
	    		$payPalURL = "https://www.".$this->environment.".paypal.com/webscr&cmd=_express-checkout&token=$token";
	    	}
	    	return $payPalURL;
	    } else  {
	    	exit('SetExpressCheckout failed: ' . print_r($httpParsedResponseAr, true));
	    }
    }
    
    // Get checkout info
    public function get_token () {
    	// Obtain the token from PayPal.
    	if(!array_key_exists('token', $_REQUEST)) {
    		exit('Token is not received.');
    	}
    	
    	// Set request-specific fields.
    	$token = urlencode(htmlspecialchars($_REQUEST['token']));
    	
    	// Add request-specific fields to the request string.
    	$nvpStr = "&TOKEN=$token";
    	
    	// Execute the API operation; see the PPHttpPost function above.
    	$httpParsedResponseAr = $this->PPHttpPost('GetExpressCheckoutDetails', $nvpStr);
    	
    	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
    		// Extract the response details.
    		$payerID = $httpParsedResponseAr['PAYERID'];
    		$street1 = $httpParsedResponseAr["SHIPTOSTREET"];
    		if(array_key_exists("SHIPTOSTREET2", $httpParsedResponseAr)) {
    			$street2 = $httpParsedResponseAr["SHIPTOSTREET2"];
    		}
    		$city_name = $httpParsedResponseAr["SHIPTOCITY"];
    		$state_province = $httpParsedResponseAr["SHIPTOSTATE"];
    		$postal_code = $httpParsedResponseAr["SHIPTOZIP"];
    		$country_code = $httpParsedResponseAr["SHIPTOCOUNTRYCODE"];
    	
    		return $httpParsedResponseAr;
    	} else  {
    		exit('GetExpressCheckoutDetails failed: ' . print_r($httpParsedResponseAr, true));
    	}
    }
    
    public function do_ckeckout($amount)
    {
    	// Set request-specific fields.
    	$payerID = urlencode($_REQUEST["PayerID"]);
    	$token = urlencode($_REQUEST["token"]);
    	
    	$paymentType = urlencode("Sale");			// or 'Sale' or 'Order'
    	$paymentAmount = urlencode($amount);
    	$currencyID = urlencode("USD");						// or other currency code ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
    	
    	// Add request-specific fields to the request string.
    	$nvpStr = "&TOKEN=$token&PAYERID=$payerID&PAYMENTACTION=$paymentType&AMT=$paymentAmount&CURRENCYCODE=$currencyID";
    	
    	// Execute the API operation; see the PPHttpPost function above.
    	$httpParsedResponseAr = $this->PPHttpPost('DoExpressCheckoutPayment', $nvpStr);
    	
    	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
    		return $httpParsedResponseAr;
    	} else  {
    		exit('DoExpressCheckoutPayment failed: ' . print_r($httpParsedResponseAr, true));
    	}
    }
    
    public function GetTransactionDetails($transactionID) {
    	// Set request-specific fields.
    	$transactionID = urlencode($transactionID);
    	// Add request-specific fields to the request string.
    	$nvpStr = "&TRANSACTIONID=$transactionID";
    		
    	// Execute the API operation; see the PPHttpPost function above.
    	$httpParsedResponseAr = $this->PPHttpPost('GetTransactionDetails', $nvpStr);
    		
    	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
    		return $httpParsedResponseAr;
    	} else  {
    		exit('GetTransactionDetails failed: ' . print_r($httpParsedResponseAr, true));
//     		return $httpParsedResponseAr;
    	}
    }

}
