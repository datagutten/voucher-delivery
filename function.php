<?php
require_once 'vendor/autoload.php';

function get_voucher($user_id,$logpath) //First argument is some kind of user identification, like user name or phone number, second is the delivery method
{
	$config = require 'config_voucher-delivery.php';
	$path=dirname(realpath(__FILE__));
	$logger=new logger($config['logdir'].'/'.$logpath);

	$vouchers=explode("\n",trim(file_get_contents($path.'/vouchers.csv'))); //Read the voucher file
	$voucher=array_pop($vouchers); //Get a code

	$logger->writelog(array($user_id,$voucher)); //Write to the log
	
	file_put_contents($path.'/vouchers.csv',implode("\n",$vouchers)); //Write the code file

	return $voucher; //Return the voucher code
}