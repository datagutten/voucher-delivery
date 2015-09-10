<?Php
//A script to convert the voucher file from pfSense to a format which is easier to handle with php
if(!isset($argv[1]))
	die("Usage: php convertvouchers.php [input file]\n");
elseif(!file_exists($argv[1]))
	die("File not found: {$argv[1]}\n");
$data=file_get_contents($argv[1]); //Read the input file
preg_match_all('^" ([a-zA-Z0-9]+)\"^',$data,$vouchers);
file_put_contents('vouchers.csv',implode("\n",$vouchers[1])); //Save the converted file
echo "Converted file saved as vouchers.csv\n";