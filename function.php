<?php
require_once 'vendor/autoload.php';

/**
 * @param string $user_id Some kind of user identification (user name or phone number) to be written to the log file
 * @param string $logpath Identifier for the delivery method, used as sub folder for the log files
 * @return mixed
 * @throws Exception
 */
function get_voucher($user_id,$logpath)
{
	$config = require 'config_voucher-delivery.php';
	$path=dirname(realpath(__FILE__));
	$logger=new logger($config['logdir'].'/'.$logpath);
	if(!file_exists($path.'/vouchers.csv'))
	    throw new Exception('Voucher file not found');

	$vouchers=explode("\n",trim(file_get_contents($path.'/vouchers.csv'))); //Read the voucher file
	$voucher=array_pop($vouchers); //Get a code

	$logger->writelog(array($user_id,$voucher)); //Write to the log
	
	file_put_contents($path.'/vouchers.csv',implode("\n",$vouchers)); //Write the code file

	return $voucher; //Return the voucher code
}