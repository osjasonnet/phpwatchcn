<?php
require_once(PW2_PATH . '/src/phpmailer/class.phpmailer.php');
require_once(PW2_PATH . '/src/phpmailer/class.pop3.php');
require_once(PW2_PATH . '/src/phpmailer/class.smtp.php');
/** phpMailer **/
class Mailer {

	/** init **/
	public function __construct(){
		if(MAIL_TYPE != 'client'){
			return false;
		}
	}

	/** send mailer **/
	public static function mail_client($to, $subject, $body, $senderInfo = ''){
		$mailer = new PHPMailer();
		if(empty($senderInfo)){
			$sender_name = DEFAULT_EMAIL_NAME;
			$sender_addr = DEFAULT_EMAIL_ADDR;
		}else{
			$sender_name = $senderInfo['sender_email_name'];
			$sender_addr = $senderInfo['sender_email_addr'];
		}
		$mailer->Mailer = EMAIL_SENDTYPE;
		$mailer->Host = EMAIL_HOST;
		$mailer->Port = EMAIL_PORT;
		if(defined('EMAIL_SSL') && EMAIL_SSL){
			$mailer->SMTPSecure = 'ssl';
		}
		#auth
		$mailer->SMTPAuth = true;
		$mailer->Username = EMAIL_ACCOUNT;
		$mailer->Password = EMAIL_PASSWORD;
		#info
		$mailer->FromName = $sender_name;
		$mailer->From = $sender_addr;
		$mailer->CharSet = 'UTF-8';
		$mailer->Encoding = 'base64';
		#send mail address
		if(is_array($to)){
			foreach($to as $addr){
				$mailer->AddAddress($addr);
			}
		}else{
			$mailer->AddAddress($to);
		}
		#html send
		$mailer->IsHTML(true);
		#SUBJECT
		$mailer->Subject = $subject;
		#body
		$mailer->Body = $body;
		$mailer->AltBody = 'text/html';
		$mailer->SMTPDebug = false;
		return $mailer->Send();
	}
}
?>