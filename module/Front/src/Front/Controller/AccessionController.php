<?php
namespace Front\Controller;


use OPF\Mvc\Controller\AbstractController;
use OPF\Plugin\Sendmail\PHPMailer;
use OPF\Filter\Requests\FormValidator;
use OPF\Filter\Requests\Filter_error;
use Front\Model\GetContent;
use OPF\Plugin\Captcha\Captcha;
use OPF\Plugin\Sendmail\Sendmail;

class AccessionController extends AbstractController
{
	
	public function indexAction(){
		if (($this->storageUser['active'] != true) && ($this->storageUser['role'] != true)) {					
			$getAccess = new GetContent();	
			$method = $this->request->getMethod();

			if($method == 'GET' && ($this->getAction() == 'index')){
				if($_SESSION['recov_pass_info']){
					$errorAuth = $_SESSION['recov_pass_info'];
					unset($_SESSION['recov_pass_info']);
					
				}


			}


			
			if($method == 'POST' && ($this->getAction() == 'index')){
				$login 			= $this->request->getPost('login');			
				$password 		= $this->request->getPost('password');
				$this->storageUser = $getAccess->getIdentity($login,$password);
				if ($this->storageUser && $this->storageUser['send_mail'] == 1) {
						$_SESSION['storageUser'] = ($this->storageUser) ? $this->storageUser : false;
						$this->goToUrl('/mychem/cpanel/udhtu-folder');
				}else{
					//$errorAuth = $this->storageUser['send_mail'];
					if ($this->storageUser['send_mail'] == '0') 
						$errorAuth = "Нажаль Ви не авторизовані.<br>
							Для авторизації зробіть підтвердження через свій e-mail.";
					else
						$errorAuth = "Десь є помилка";
				}			
			}		
		}else{
			$this->goToUrl('/mychem/cpanel/udhtu-folder');
		}
		$this->view->render('index', array( 
												'action' => $action,
												'method' => $method,
												'post' 	 => $_SESSION['storageUser'],
												'errorAuth' 	 => $errorAuth,
												));

	}









	public function activationAction(){

		$GetContent = new GetContent();	

		if($this->request->getMethod() == 'GET' && ($this->getAction() == 'activation')){


if($_GET['step'] == 2){
				$info_activation = "<center><div style='font-size:18px;font-weight:bold;color:green;'> Перша частина реєстрації пройшла успішно.<br> На Вашу електронну адресу має надійти лист з підтвердженням.</div></center>";
}



			if(!empty($_GET['login']) && !empty($_GET['key']) ){

				if(preg_match("/^[a-z][a-zA-Z0-9_]{4,16}$/iu",trim($_GET['login']))){
					$login =trim((htmlspecialchars(strip_tags(($_GET['login'])))));
					$activ =trim((htmlspecialchars(strip_tags(($_GET['key'])))));

					$data_select = array(	
											$login,	
										);	
					$query = "id,mail,login,salt,send_mail from mu_users where login=?";
					$id_for_key = $GetContent->goSelect($query,$data_select);

				    if(md5($id_for_key[0]['login'].$id_for_key[0]['mail'].$id_for_key[0]['salt']) == $activ ){

				    	switch ($id_for_key[0]['send_mail']) {
				    			case 1:
				    				$info_activation = "<center><div style='font-size:18px;font-weight:bold;color:green;'>Ви вже авторизовані. Натисніть кнопку 'Вхід'.</div></center><br><br><center><a href='/login'><button class='btnLk'>&nbsp;Вхід&nbsp;</button></a></center>";
				    			break;
				    			case 2:
				    				$info_activation = "<center><div style='font-size:18px;font-weight:bold;color:green;'>Возникла ошибка сообщите администрации.</div></center><br><br><center><a href='/login'><button class='btnLk'>&nbsp;Сообщить &nbsp;</button></a></center>";
				    			break;
				    		 		
				    		default:
				    				$upd_stat_mail = array(
														1,	
														$id_for_key[0]['id'],
												);								
									$query = "mu_users SET send_mail= ? WHERE id =?";			
									$mu_upd_content = $GetContent->goUpdate($query,$upd_stat_mail);	
									$info_activation = "<center><div style='font-size:18px;font-weight:bold;color:green;'>Поздоровляємо! Ви авторизовані. Для початку роботи натисніть на кнопку входу.</div></center><br><br><center><a href='/login'><button class='btnLk'>&nbsp;Вхід&nbsp;</button></a></center>";	
				    			break;
				    	}



	   				 }
				}
			}

			
		}


		
		$this->view->render('activation', array( 
												'action' => $action,
												'method' => $method,
												'info_activation' 	 => $info_activation,
												'errorAuth' 	 => $errorAuth,
												));

	}















	public function registrationAction(){
		$GetContent = new GetContent();	
		$err 		= new Filter_error();
		$Captcha = new Captcha();
		//$Sendmail = new Sendmail();

		if($this->request->getMethod() == 'GET' && ($this->getAction() == 'registration')){
			$_SESSION['capch'] = $Captcha->sum();
			$cptch = $Captcha->draw();
		}

	if($this->request->getMethod() == 'POST' && ($this->getAction() == 'registration')){
		$FormValidator = new FormValidator($this->request->getPost(),$_FILES);









	
	
		
	$send_mail = 0;
	$status=1;// означет enable
	$role = 2;// означет user
	$level= 1;// дописать уровні прав(создать таблицу в Бд)	
		
	$data_users = array(
					"name"		=> $FormValidator->name(),
					"last_name"	=> $FormValidator->last_name(),
					"middle_name"	=> $FormValidator->middle_name(),
					"mail"	=> $FormValidator->mail(),
					"login"	=> $FormValidator->login(),
					"password" => $FormValidator->password(),
					"sex" => $FormValidator->sex(),
				); 
/*				
	$data_conf = array(
					"title_public" => $FormValidator->title_public(),
					"mu_type_presentation" => $FormValidator->type_presentation(),
					"party" => $FormValidator->party(),
					"hotel" => $FormValidator->hotel(),
					"advanced_training_courses" => $FormValidator->training_courses(),
					"mu_topic_conf" => $FormValidator->topic_conf(),
					"abstracts"  => $FormValidator->abstracts(),
				); 
	$data_contact = array(
						"mob_phone"	=> $FormValidator->tel(),
						"skype" => $FormValidator->skype(),
					); 
					
	$data_work_info = array(
						"organization"	=> $FormValidator->organization(),
						"mu_uch_stepen" => $FormValidator->uch_stepen(),
						"mu_degree" => $FormValidator->degree(),						
					);
	*/
	$data_temp = array(
						"captcha" => $FormValidator->captcha()								
					); 					

	$error_users	= $err->isError(array_flip($data_users) );
	//$error_conf		= $err->isError($data_conf);
	//$error_contact	= $err->isError($data_contact);	
	//$error_work_info= $err->isError($data_work_info);
	$error_temp		= $err->isError(array_flip($data_temp));
	//var_dump($error_users)."<br>";
	//var_dump($error_conf)."<br>";
	//var_dump($error_contact)."<br>";
	//var_dump ($error_work_info)."<br>";	
	//$data_all = $data_users + $data_conf + $data_contact + $data_work_info + $data_temp ;	
	$data_all = $data_users + $data_temp ;	
	//var_dump ($data_all)."<br>";
	if (($error_users['error_status'] != 0)		|| 
		//($error_conf['error_status'] != 0)		|| 
		//($error_contact['error_status'] != 0)	|| 
		//($error_work_info['error_status'] != 0)||
		($error_temp['error_status'] != 0)
		){
			

			//var_dump($data_all);
			$_SESSION['capch'] = $Captcha->sum();
			$cptch = $Captcha->draw();
			$data_all[] = $cptch;
			
			echo json_encode($data_all);
			exit;
	}else{	
		$data_users["send_mail"]	= $send_mail;
		$data_users["mu_status"]		= $status;
		$data_users["mu_role"]			= $role;
		$data_users["level"]		= $level;
		$data_users["salt"]			= $FormValidator->salt;
		$data_users["ip"]			= $FormValidator->ip();
		$data_users["last_visit_date"]		= date("Y-m-d H:i:s"); 
		$data_users["register_date"]		= date("Y-m-d H:i:s"); 
		//$data_conf["mu_status"]		= 2;
		//$data_conf["mu_conf_type "]	= 1;
		$GetContent->goInsert("mu_users",$data_users);
		$last_Insert_User_id		= $GetContent->lastInsertsId();	
	//	$data_conf["mu_user"]			= $last_Insert_User_id;
		//$sql->inserts("mu_conf",$data_conf);
		//$data_contact["mu_user"]		= $last_Insert_User_id;
		//$sql->inserts("mu_contact_info",$data_contact);
		//$data_work_info["mu_user"]		= $last_Insert_User_id;
		//$sql->inserts("mu_work_info",$data_work_info);


	if ($row['sex'] == 'М') {
		$sex_p = 'Шановний '; 
	}

	if ($row['sex'] == 'Ж') {
		$sex_p = 'Шановна '; 
	}	




			$email = $data_users["mail"];
			$name = 'UDHTU';
			$login = 'demy2@ukr.net';
			$message = $sex_p.$data_users["last_name"].' '.$data_users["name"].' '.$data_users["middle_name"].'!<br>
	Дякуемо за реєстрацію на сайті <b>"Українського державного хіміко-технологічного університету"</b>.<br>
	Для входу в свій аккаунт необхідна активація:<br><br>
		http://udhtu.com.ua/activation/account?login='.$data_users["login"].'&key='.md5($data_users["login"].$data_users["mail"].$data_users["salt"]).'<br><br>З повагою,
	адміністрація сайту';//содержание сообщение


		

$Sendmail = new Sendmail();
$data_mail=array();// прописываем опции
$data_mail['smtp_server']='ssl://smtp.ukr.net';// SMTP server
$data_mail['smtp_login']='demy2@ukr.net';// имя пользователя
$data_mail['smtp_password']='demy2666';// пароль пользователя
$data_mail['smtp_server_port']=465;// SMTP port
				


$data_mail['email_send']=$email;// от кого письмо
$data_mail['email_send_name']='UDHTU';// от кого письмо (Имя)
//$data_mail['debug']=2;// от кого письмо (Имя)



$data_mail['address']=$email;// кому письмо sv_udhtu@ukr.net
$data_mail['title']='Підтвердження реєстрації';// тема письма
//$data_mail['html']=1;// 0 - письмо в текстовом формате, 1 - в HTML формате
$data_mail['text']= $message;//содержание сообщение
	
if ($Sendmail->sdf_email($data_mail)){
		$upd_stat_mail = array(
							3,	
							$last_Insert_User_id,
						
				);								
		$query = "mu_users SET send_mail= ? WHERE id =?";			
		$mu_upd_content = $GetContent->goUpdate($query,$upd_stat_mail);	

	}else{
		$upd_stat_mail = array(
							2,	
							$last_Insert_User_id,
						
						);								
				$query = "mu_users SET send_mail= ? WHERE id =?";			
				$mu_upd_content = $GetContent->goUpdate($query,$upd_stat_mail);	

	}  








		$redir  = array('redir'=>'true');
		echo json_encode($redir);
		exit;
		//echo "Zapis";
	}












}


		

		$this->view->render('registration', array( 
												'captcha' => $cptch,
												'action' => $action,
												'method' => $method,
												'post' 	 => $_SESSION['storageUser'],
												'errorAuth' 	 => $errorAuth,
												));

	}









	public function logoutAction(){
		unset($_SESSION['storageUser']);
		$this->goToUrl('login');
		//$post = "LOGOUT";




		$this->view->render('logout', array( 
											'action' => $action,
											'method' => $post,
											'post' 	 => $_SESSION['storageUser'],

										)
							);

	}


		public function resetAction(){
			//ini_set("display_errors",2);
			//echo phpinfo();
			$GetContent = new GetContent();	
			$errorAuth = "Нагадування пароля";
			$method = $this->request->getMethod();
			if($method == 'POST' && ($this->getAction() == 'reset') && $this->request->getPost('mu_rest_pass') == 1 ){

				$FormValidator = new FormValidator($this->request->getPost());
				if($FormValidator->check_mail() != 'error_mail'){				
					
							$data_select = array(
											$FormValidator->check_mail(),	
										);	
							$query	= "mail,name,id,password,login FROM mu_users WHERE mail=? LIMIT 1";
							$dataMail = $GetContent->goSelect($query,$data_select);
							
				if($dataMail == NULL){
					exit;
				}

				foreach ($dataMail as $key => $value) {					
					$dataMail[$value]= $dataMail[$key];
				}



			$hash_url = md5($dataMail['password'].round().$dataMail[0]['id'].date("Y-m-d H:i:s"));
			$mess = 'http://udhtu.com.ua/reset/'.$hash_url;			
			$name = $dataMail[0]['name'];
			$login = $dataMail[0]['login'];

$Sendmail = new Sendmail();
$data_mail=array();// прописываем опции
$data_mail['smtp_server']='ssl://smtp.ukr.net';// SMTP server
$data_mail['smtp_login']='demy2@ukr.net';// имя пользователя
$data_mail['smtp_password']='demy2666';// пароль пользователя
$data_mail['smtp_server_port']=465;// SMTP port
				


$data_mail['email_send']=$dataMail[0]['mail'];// от кого письмо
$data_mail['email_send_name']='UDHTU';// от кого письмо (Имя)
//$data_mail['debug']=2;// от кого письмо (Имя)



$data_mail['address']=$dataMail[0]['mail'];// кому письмо sv_udhtu@ukr.net
$data_mail['title']='Нагадування пароля';// тема письма
//$data_mail['html']=1;// 0 - письмо в текстовом формате, 1 - в HTML формате
$data_mail['text']='<b>Доброго дня, '.$name.'('.$login.')</b><br>'.'Нам стало відомо, що Ви забули пароль. Не засмучуйтесь!<br>Для встановлення нового паролю натисніть <a href="'.$mess.'">"змiнити пароль"</a><br><br>Зверніть увагу! Це посилання дійсне на протязі однієї доби.<br><br>З повагою, адміністрація сайту UDHTU';//содержание сообщение
	
if ($Sendmail->sdf_email($data_mail)){



/*

			$hash_url = md5($dataMail['password'].round().$dataMail[0]['id'].date("Y-m-d H:i:s"));
			$mess = 'http://udhtu.com.ua/reset/'.$hash_url;
			$email = $dataMail[0]['mail'];
			$name = $dataMail[0]['name'];
			$login = $dataMail[0]['login'];
			$message = '<b>Доброго дня, '.$name.'('.$login.')</b><br>'.'Нам стало відомо, що Ви забули пароль. Не засмучуйтесь!<br>Для встановлення нового паролю натисніть <a href="'.$mess.'">"змiнити пароль"</a><br><br>Зверніть увагу! Це посилання дійсне на протязі однієї доби.<br><br>З повагою, адміністрація сайту UDHTU';
			//include "PHPMailer.php";// подключаем класс
			$mail = new PHPMailer();
			$mail->SMTPDebug = 0;
			$mail->MailerDebug = false;
				$mail->CharSet='utf-8';// выставляем с какой кодировкой работать
				
				
			$mail->From = 'udhtu.com.ua@ukr.net';
			$mail->FromName = 'udhtu admin';
			$mail->AddAddress($email);
	
			$mail->IsHTML(true);
			$mail->Subject = "Нагадування пароля";//тема письма
			$mail->Body = $message;

			if ($mail->Send()){ */


				$date 	= date("Y-m-d H:i:s");				
				$data_insert = array(	 'hash_url' 		=> $hash_url,
										 'mu_user' 			=> $dataMail[0]['id'],
										 'date_recovery'	=> $date,									
									);			
				$done = $GetContent->goInsert('mu_recovery',$data_insert);			
				if ($done){
					$_SESSION['recov_pass_info'] = 'На Ваш e-mail надіслано лист з інструкцією для відновлення паролю.';
					$this->goToUrl('/login');
				}else{
					$_SESSION['recov_pass_info'] = $Sendmail->sdf_email($data_mail);
					$this->goToUrl('/login');
				}
			
			}else{				
				$this->goToUrl('/login');
			}
				}else{			
					$errorAuth = $FormValidator->check_mail();	
				}	
			}	


			if($method == 'GET' && ($this->getAction() == 'reset')){
				$params = $this->getParams();
				//var_dump($params);
				if($params['reset']){
					$query	= "mu_user,date_recovery FROM `mu_recovery` WHERE hash_url=? and (TIMESTAMPDIFF(HOUR,NOW(),date_recovery))<24 LIMIT 1"; //проверяет ссылки на истечение 24 часов
					$params1 = trim(htmlspecialchars(strip_tags(($params['reset']))));
					$result = $GetContent->checkDate($query,$params1);
					if($result){
						$recov = $params1;
						$errorAuth = "Введіть новий пароль";
					}
				}	
			}




			if($this->request->getPost('mu_rest_pass') && $this->request->getPost('mu_rest_pass') != 1 ){
				$query	= "mu_user,date_recovery FROM `mu_recovery` WHERE hash_url=? and (TIMESTAMPDIFF(HOUR,NOW(),date_recovery))<24 LIMIT 1"; //проверяет ссылки на истечение 24 часов
					$params1 = trim(htmlspecialchars(strip_tags(($this->request->getPost('mu_rest_pass')))));
					$result = $GetContent->checkDate($query,$params1);
					$recov = $params1;
				$FormValidator = new FormValidator($this->request->getPost());	
				$new_pass = $FormValidator->new_password($result['mu_user']);			
				if($new_pass != 'error_password'){

			$query = "mu_users SET password=? WHERE id=?";
			$data_update_pass = array($new_pass,$result['mu_user']);						
			$done = $GetContent->goUpdate($query,$data_update_pass);
			if($done)
			$this->goToUrl('/login');
			else
			$errorAuth = "Шось трапилось!<br>Перевірте дані";



					
					
}


$errorAuth = "Шось трапилось!<br>Перевірте дані";


}









		$this->view->render('reset', array( 		
												'recov' => $recov,										
												'method' => $method,
												'params' => $params,												
												'errorAuth' 	 => $errorAuth,
												));

	}


}
