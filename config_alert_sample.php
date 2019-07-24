<?Php
$config['recipients']=array('you@yourdomain.com'); //Array of mail addresses to receive alerts
$config['mail_from']='voucher@yourdomain.com';
$config['smtp_server']='yoursmtp.local';
$config['smtp_port']=25;
$config['mail_subject']='Few voucher codes left';
$config['mail_body']='There are %d voucher codes left';
$config['limit']=200; //Send message when there is X voucher codes left
