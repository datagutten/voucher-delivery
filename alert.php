<?Php
require 'vendor/autoload.php';
//Create a new PHPMailer instance
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use askommune\voucher_delivery\vouchers;

$mail = new PHPMailer;
require 'config_alert.php';

//These lines are copied from PHPMailer example smtp_no_auth.phps
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Set the hostname of the mail server
$mail->Host = $config['smtp_server'];
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = $config['smtp_port'];
//Whether to use SMTP authentication
$mail->SMTPAuth = false;
//Set who the message is to be sent from
$mail->setFrom($config['mail_from']);
$mail->Timeout = 1;
//Set who the message is to be sent to
foreach($config['recipients'] as $recipient)
	$mail->addAddress($recipient);


$mail->isHTML(true); // Set email format to HTML


//$vouchers=explode("\n",trim(file_get_contents('vouchers.csv')));
$vouchers = new vouchers();
$count=$vouchers->voucher_count();
//$count=9;
//var_dump($count);

if($count<$config['limit'] || (isset($argv[1]) && $argv[1]=='debug'))
{
	$mail->Subject=$config['mail_subject'];
	$mail->Body=sprintf($config['mail_body'],$count);

	try {
	    $mail->send();
        echo "Message has been sent\n";
    }
     catch (Exception $e) {
        echo $e->errorMessage();
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
}
elseif(isset($argv[1]) && $argv[1]=='check')
	echo "$count koder gjenstår\n";
