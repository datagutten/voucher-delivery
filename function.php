<?php
require 'vendor/autoload.php';

/**
 * @param string $user_id Some kind of user identification (user name or phone number) to be written to the log file
 * @param string $logpath Identifier for the delivery method, used as sub folder for the log files
 * @param string $voucher_file Voucher file to override default
 * @return mixed
 * @throws Exception
 */
function get_voucher($user_id,$logpath, $voucher_file=Null)
{
	$vouchers = new \askommune\voucher_delivery\vouchers($logpath, $voucher_file);
    $voucher = $vouchers->get_voucher($user_id);

	return $voucher; //Return the voucher code
}