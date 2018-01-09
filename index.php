<?php

include __DIR__ . "/vendor/autoload.php";
include __DIR__ . "/config.php";

$payer = new \PayPal\Api\Payer();
$payer->setPaymentMethod('paypal');

$item = new \PayPal\Api\Item();
$item->setName('Fresh Apple')
	->setCurrency('EUR')
	->setQuantity(1)
	->setSku('#fds')
	->setPrice(5);

$itemList = new \PayPal\Api\ItemList();
$itemList->setItems([$item]);

$details = new \PayPal\Api\Details();
$details->setShipping(2)
	->setTax(1)
	->setSubtotal(5);

$amount = new \PayPal\Api\Amount();
$amount->setCurrency('EUR')
	->setTotal(8)
	->setDetails($details);

$transaction = new \PayPal\Api\Transaction();
$transaction->setAmount($amount)
	->setItemList($itemList)
	->setDescription('apples evrywhere!')
	->setInvoiceNumber(uniqid("FDS", true));

$redirectUrls = new \PayPal\Api\RedirectUrls();
$redirectUrls->setReturnUrl($base . "/success.php?payment=true")
	->setCancelUrl($base . "/cancel.php?payment=false");

$payment = new \PayPal\Api\Payment();
$payment->setIntent('sale')
	->setPayer($payer)
	->setRedirectUrls($redirectUrls)
	->setTransactions([$transaction]);

$request = clone $payment;

try{
	$payment->create($apiContext);
}catch (Exception $e){
	echo $e->getMessage();
}

$approvalUrl = $payment->getApprovalLink();

echo "<a href='{$approvalUrl}' target='_blank'>Jetzt Bezahlen!</a>";
