<?Php
chdir(dirname(realpath(__FILE__))); //Bytt til mappen scriptet ligger i så relative filbaner blir riktige
require 'PHPMailer/PHPMailerAutoload.php';
//Create a new PHPMailer instance
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
//Set who the message is to be sent to
foreach($config['recipients'] as $recipient)
	$mail->addAddress($recipient);


$mail->isHTML(true); // Set email format to HTML


$vouchers=explode("\n",trim(file_get_contents('vouchers.csv')));
$count=count($vouchers);
//$count=9;
//var_dump($count);

if($count<$config['limit'] || (isset($argv[1]) && $argv[1]=='debug'))
{
	$mail->Subject=$config['mail_subject'];
	$mail->Body=sprintf($config['mail_body'],$count);

	if(!$mail->send()) {
	   echo 'Message could not be sent.';
	   echo 'Mailer Error:'.$mail->ErrorInfo;
	   exit;
	}
	else
		echo "Message has been sent\n";

}
elseif(isset($argv[1]) && $argv[1]=='check')
	echo "$count koder gjenstår\n";
?>