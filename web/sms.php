<?php
/**
 * Created by PhpStorm.
 * User: abi
 * Date: 22.07.2019
 * Time: 13:12
 */
//SMS gateway fetches this file to get voucher
require '../vendor/autoload.php';
$messages = require 'messages.php';
if(!empty($_POST['sender'])) {
    try {
        $vouchers = new \askommune\VoucherDelivery\vouchers('sms');
        $voucher = $vouchers->get_voucher($_POST['sender']);
        printf($messages['delivery'], $voucher);
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
        echo $messages['error'];
    }
}