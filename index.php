<?php

include __DIR__ . "/vendor/autoload.php";

$payer = new \PayPal\Api\Payer();


$clientId = 'AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS';
$clientSecret = 'EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL';

function getApiContext($clientId, $clientSecret)
{

	$apiContext = new \PayPal\Rest\ApiContext(
		new \PayPal\Auth\OAuthTokenCredential(
			$clientId,
			$clientSecret
		)
	);

	$apiContext->setConfig(
		array(
			'mode' => 'sandbox',
			'log.LogEnabled' => true,
			'log.FileName' => '../PayPal.log',
			'log.LogLevel' => 'DEBUG',
			'cache.enabled' => true,
			// 'http.CURLOPT_CONNECTTIMEOUT' => 30
			// 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
			//'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
		)
	);

	return $apiContext;
}

$apiContext = getApiContext($clientId, $clientSecret);
