<?php
/**
 * Created by PhpStorm.
 * User: workstation
 * Date: 09.01.18
 * Time: 11:30
 */
echo "test";
include __DIR__."/vendor/autoload.php";
include __DIR__."/config.php";


if ($_GET['payment'] && isset($_GET['token'], $_GET['paymentId'])) {

	$paymentId = $_GET['paymentId'];
	$payment = \PayPal\Api\Payment::get($paymentId, $apiContext);

	$execution = new \PayPal\Api\PaymentExecution();
	$execution->setPayerId($_GET['PayerID']);

	$transaction = new \PayPal\Api\Transaction();
	$amount = new \PayPal\Api\Amount();
	$details = new \PayPal\Api\Details();

	$details->setShipping(2)
		->setTax(1)
		->setSubtotal(5);

	$amount->setCurrency('EUR')
		->setTotal(8)
		->setDetails($details);

	$transaction->setAmount($amount);

	$execution->addTransaction($transaction);

	try {
		$result = $payment->execute($execution, $apiContext);
		try {
			$payer = \PayPal\Api\Payment::get($paymentId, $apiContext);
			echo "<pre>";
			    print_r($payer);
			echo "</pre>";
		} catch (Exception $e) {
			echo $e->getMessage();
			exit(1);
		}
	} catch (Exception $e) {
		echo $e->getMessage();
		exit(1);
	}

}