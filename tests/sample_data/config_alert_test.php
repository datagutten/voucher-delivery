<?Php
$config['recipients']=array('you@yourdomain.com'); //Array of mail addresses to receive alers
$config['mail_from']='voucher@example.com';
$config['smtp_server']='localhost';
$config['smtp_port']=25;
$config['mail_subject']='Few voucher codes left';
$config['mail_body']='There are %d voucher codes left';
$config['limit']=1; //Send message when there is X voucher codes left
