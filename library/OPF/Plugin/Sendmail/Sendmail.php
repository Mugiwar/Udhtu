<?php 
namespace OPF\Plugin\Sendmail;
use OPF\Plugin\Sendmail\PHPMailer;
Class Sendmail{
	

	
	public function __construct(){	
			}
	
		public function sdf_email($data_mail){

			$mail = new PHPMailer;

			//$mail->SMTPDebug = 3;                               // Enable verbose debug output

			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = $data_mail['smtp_server'];			//'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = $data_mail['smtp_login'];			//'user@example.com';                 // SMTP username
			$mail->Password = $data_mail['smtp_password'];                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port =$data_mail['smtp_server_port'];			// 587;                                    // TCP port to connect to
			$mail->CharSet = 'utf-8';
			//$mail->setFrom('from@example.com', 'Mailer');
			$mail->setFrom($data_mail['smtp_login'], $data_mail['email_send_name']);
			$mail->addAddress($data_mail['address'], 'Joe User');     // Add a recipient
		//	$mail->addAddress('ellen@example.com');               // Name is optional
		//	$mail->addReplyTo('info@example.com', 'Information');
		//	$mail->addCC('cc@example.com');
		//	$mail->addBCC('bcc@example.com');

			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject = $data_mail['title'];
			$mail->Body    = $data_mail['text'];
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if(!$mail->send()) {
			   
			   return  $mail->ErrorInfo;
			} else {
			   return true;
			}
					
					

	
	}

	
}

