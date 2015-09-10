<?Php
//This is a sample of how to implement the voucher delivery
//Include function.php and call get_voucher()
require 'function.php';
echo 'Your vocher code is: '.get_voucher('test','cli')."\n";