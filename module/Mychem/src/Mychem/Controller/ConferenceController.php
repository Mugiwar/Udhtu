<?php
namespace Mychem\Controller;

use OPF\Mvc\Controller\AbstractController;
use OPF\Filter\Requests\FormValidator;
use OPF\Loader\PHPMailer;
use Mychem\Model\SqlContent;
use Mychem\Filter\FilterError;
class ConferenceController extends AbstractController
{
	
	
	public function indexAction(){	
		SetCookie("err_reg",null);
		$SqlContent = new SqlContent();
		$action = $this->getAction();
		$method = $this->request->getMethod();
		$post  = $this->request->getPost();
		$params = $this->getParams();		


			//var_dump($params);
		if ($method == "GET") {				
			if(!empty($params))	{
				foreach ($this->getParams() as $key => $value) {					
					$params[urldecode($key)]=urldecode($value);
					if($key == 'registration'){
						switch ($value) {
							case 'fuel':
								$topicConf = 1;
								break;
							case 'himsovrtehn':
								$topicConf = 2;
								break;
							case 'shevchenko':
								$topicConf = 3;
								break;
							case 'himsovrtehn_85year':
								$topicConf = 4;
								break;
							case 'tnr_2015':
								$topicConf = 5;
								$conf_email = 'tnv15@ukr.net';
								break;
						}

					}
				}	
				$content = $SqlContent->getPage($params);
				$degree = $SqlContent->getDegree();
				$uch_stepen = $SqlContent->getUchStepen();
				$type_presentation = $SqlContent->getTypePresent();
				$topic_conf = $SqlContent->getTopicConf($topicConf);
			}
		}



				$user = $_SESSION['storageUser'];
			if($this->request->getPost('id_section'))	{

							if(!empty($params))	{
				foreach ($this->getParams() as $key => $value) {					
					$params[urldecode($key)]=urldecode($value);
					if($key == 'partaker'){
						switch ($value) {
							case 'fuel':
								$topicConf = 1;
								break;
							case 'himsovrtehn':
								$topicConf = 2;
								break;
							case 'shevchenko':
								$topicConf = 3;
								break;
							case 'himsovrtehn_85year':
								$topicConf = 4;
								break;
							case 'tnr_2015':
								$topicConf = 5;
								$conf_email = 'tnv15@ukr.net';
								break;
						}

					}
				}}





			$topicConf_section = array($topicConf,$this->request->getPost('id_section') );	
			$partakerInfo = $SqlContent->getConfInfoSort($topicConf_section);

			foreach ($partakerInfo as $key => &$value111) {
				$value111['mail'] = substr_replace($value111['mail'], '****', 3,-10);

			}
			unset($value111);

			echo json_encode($partakerInfo)	;	
			exit;	
		}





		//echo $this->request->getPost('conf');
		
		if(($this->request->getPost('conf') == 1)	){
			SetCookie("err_reg",null);
			$FilterError = new FilterError();
			$FormValidator = new FormValidator($this->request->getPost());	
			$data_conf = array(
						"title_public"				=> $FormValidator->title_public(),
						"mu_type_presentation"		=> $FormValidator->type_presentation(),
						"party" 					=> $FormValidator->party(),
						"hotel" 					=> $FormValidator->hotel(),
						"advanced_training_courses" => $FormValidator->training_courses(),
						"mu_topic_conf" 			=> $FormValidator->topic_conf(),
						"abstracts" 				=> $FormValidator->abstracts(),
					); 

			$data_work_info = array(
							"organization"	=> $FormValidator->organization(),
							"mu_uch_stepen" => $FormValidator->uch_stepen(),
							"mu_degree" 	=> $FormValidator->degree(),						
						);

			$error_conf		 = $FilterError->isError($data_conf);
			$error_work_info = $FilterError->isError($data_work_info);
			
			//var_dump($error_conf);
			$data_all = $data_conf + $data_work_info;	
			//var_dump($error_conf)."<br>";
			if(($error_conf['error_status'] == 0)&&($error_work_info['error_status'] == 0)){
					$data_insert_work = array(
										"organization"	=> $FormValidator->organization(),
										// 'mu_city' 			=> $section,										 										
										 'mu_degree'		=> $FormValidator->degree(),
										 //'job'				=> $date,
										 'mu_user'			=> $this->storageUser['id'],
										 'mu_uch_stepen'	=> $FormValidator->uch_stepen(),
										 "mu_conf_type" 	=> $this->request->getPost('conf'),	
									);
					$data_insert_conf = array(
										'mu_user'				 => $this->storageUser['id'],
										"title_public"			 => $FormValidator->title_public(),
										"mu_type_presentation"	 => $FormValidator->type_presentation(),
										"party" 				 => $FormValidator->party(),
										"hotel" 				 => $FormValidator->hotel(),
										"advanced_training_courses"	 => $FormValidator->training_courses(),
										"mu_topic_conf"				 => $FormValidator->topic_conf(),
										"abstracts" 				 => $FormValidator->abstracts(),
										"mu_status" 				 => '2',
										"mu_conf_type" 				 => $this->request->getPost('conf'),
										"mu_status_view" 				=> '2',
										"mu_status_oplata" 				=> '2',
										"register_date"					=> date("Y-m-d H:i:s"),
									);									
					$done_work = $SqlContent->goInsert('mu_work_info',$data_insert_work);
										$data_insert_conf['mu_work_info'] = $SqlContent->lastInsertsId();
														 
									
								
					
					$done_conf = $SqlContent->goInsert('mu_conf',$data_insert_conf);
					//echo $done_work;
					if(($done_work)&&($done_conf)){
						$this->goToUrl('http://udhtu.waterh.net/mychem/conference/registration/done');
					}else{
						SetCookie("err_reg","Десь є помилка");
						$this->goToUrl('http://udhtu.waterh.net/mychem/conference/registration/fuel');
						
					}
				}else{
					SetCookie("err_reg","Десь є помилка");
					$this->goToUrl('http://udhtu.waterh.net/mychem/conference/registration/fuel');
				}

					
		
		}

		if(($this->request->getPost('conf') == 2)	){
			SetCookie("err_reg",null);
			$FilterError = new FilterError();
			$FormValidator = new FormValidator($this->request->getPost());	
			$data_conf = array(
						"title_public"				=> $FormValidator->title_public(),
						"mu_type_presentation"		=> $FormValidator->type_presentation(),						
						"hotel" 					=> $FormValidator->hotel(),						
						"mu_topic_conf" 			=> $FormValidator->topic_conf(),
						
					); 

			$data_work_info = array(
							"organization"	=> $FormValidator->organization(),
							"mu_uch_stepen" => $FormValidator->uch_stepen(),
							"mu_degree" 	=> $FormValidator->degree(),						
						);

			$error_conf		 = $FilterError->isError($data_conf);
			$error_work_info = $FilterError->isError($data_work_info);
			


			$data_all = $data_conf + $data_work_info;	
			//var_dump($error_conf)."<br>";
			if(($error_conf['error_status'] == 0)&&($error_work_info['error_status'] == 0)){
			
					$data_insert_work = array(
										"organization"	=> $FormValidator->organization(),
										// 'mu_city' 			=> $section,										 										
										 'mu_degree'		=> $FormValidator->degree(),
										 //'job'				=> $date,
										 'mu_user'			=> $this->storageUser['id'],
										 'mu_uch_stepen'	=> $FormValidator->uch_stepen(),
										 "mu_conf_type" 				 => $this->request->getPost('conf'),	
									);
					$data_insert_conf = array(
										'mu_user'				 => $this->storageUser['id'],
										"title_public"			 => $FormValidator->title_public(),
										"mu_type_presentation"	 => $FormValidator->type_presentation(),
										//"party" 				 => $FormValidator->party(),
										"hotel" 				 => $FormValidator->hotel(),
										//"advanced_training_courses"	 => $FormValidator->training_courses(),
										"mu_topic_conf"				 => $FormValidator->topic_conf(),
										//"abstracts" 				 => $FormValidator->abstracts(),
										"mu_status" 				 => '2',
										"mu_conf_type" 				 => $this->request->getPost('conf'),
										"mu_status_view" 				=> '2',
										"mu_status_oplata" 				=> '2',
										"register_date"					=> date("Y-m-d H:i:s"),
									);									
					$done_work = $SqlContent->goInsert('mu_work_info',$data_insert_work);
					$data_insert_conf['mu_work_info'] = $SqlContent->lastInsertsId();
														 
									
								
					$done_conf = $SqlContent->goInsert('mu_conf',$data_insert_conf);
					if(($done_work)&&($done_conf)){
						$this->goToUrl('http://udhtu.waterh.net/mychem/conference/registration/done');
					}else{
						SetCookie("err_reg","Десь є помилка");
						$this->goToUrl('http://udhtu.waterh.net/mychem/conference/registration/himsovrtehn');
						
					}
					}else{
					SetCookie("err_reg","Десь є помилка");
					$this->goToUrl('http://udhtu.waterh.net/mychem/conference/registration/himsovrtehn');
				}
		
		}	





				if(($this->request->getPost('conf') == 3)	){
			SetCookie("err_reg",null);
			$FilterError = new FilterError();
			$FormValidator = new FormValidator($this->request->getPost());	
			$data_conf = array(
						"title_public"				=> $FormValidator->title_public(),
						"mu_type_presentation"		=> $FormValidator->type_presentation(),						
						"hotel" 					=> $FormValidator->hotel(),	
						"buy_book" 					=> $FormValidator->buy_book(),							
						"mu_topic_conf" 			=> $FormValidator->topic_conf(),
						
					); 

			$data_work_info = array(
							"organization"	=> $FormValidator->organization(),
							"mu_uch_stepen" => $FormValidator->uch_stepen(),
							"mu_degree" 	=> $FormValidator->degree(),						
						);

			$error_conf		 = $FilterError->isError($data_conf);
			$error_work_info = $FilterError->isError($data_work_info);
			


			$data_all = $data_conf + $data_work_info;	
			//var_dump($error_conf)."<br>";
			if(($error_conf['error_status'] == 0)&&($error_work_info['error_status'] == 0)){
			
					$data_insert_work = array(
										"organization"	=> $FormValidator->organization(),
										// 'mu_city' 			=> $section,										 										
										 'mu_degree'		=> $FormValidator->degree(),
										 //'job'				=> $date,
										 'mu_user'			=> $this->storageUser['id'],
										 'mu_uch_stepen'	=> $FormValidator->uch_stepen(),
										 "mu_conf_type" 	=> $this->request->getPost('conf'),	
									);
					$data_insert_conf = array(
										'mu_user'				 => $this->storageUser['id'],
										"title_public"			 => $FormValidator->title_public(),
										"mu_type_presentation"	 => $FormValidator->type_presentation(),
										//"party" 				 => $FormValidator->party(),
										//"hotel" 				 => $FormValidator->hotel(),
										"buy_book" 				 => $FormValidator->buy_book(),
										//"advanced_training_courses"	 => $FormValidator->training_courses(),
										"mu_topic_conf"				 => $FormValidator->topic_conf(),
										//"abstracts" 				 => $FormValidator->abstracts(),
										"mu_status" 				 => '2',
										"mu_conf_type" 				 => $this->request->getPost('conf'),
										"mu_status_view" 				=> '2',
										"mu_status_oplata" 				=> '2',
										"register_date"					=> date("Y-m-d H:i:s"),
									);									
					$done_work = $SqlContent->goInsert('mu_work_info',$data_insert_work);
					$data_insert_conf['mu_work_info'] = $SqlContent->lastInsertsId();
														 
									
								
					$done_conf = $SqlContent->goInsert('mu_conf',$data_insert_conf);
					if(($done_work)&&($done_conf)){
						$this->goToUrl('http://udhtu.waterh.net/mychem/conference/registration/done');
					}else{
						SetCookie("err_reg","Десь є помилка");
						$this->goToUrl('http://udhtu.waterh.net/mychem/conference/registration/shevchenko');
						
					}
					}else{
					SetCookie("err_reg","Десь є помилка");
					$this->goToUrl('http://udhtu.waterh.net/mychem/conference/registration/shevchenko');
				}
		
		}



				if(($this->request->getPost('conf') == 4)	){
			SetCookie("err_reg",null);
			$FilterError = new FilterError();
			$FormValidator = new FormValidator($this->request->getPost());	
			$data_conf = array(
						"title_public"				=> $FormValidator->title_public(),
						"mu_type_presentation"		=> $FormValidator->type_presentation(),						
						"hotel" 					=> $FormValidator->hotel(),	
						"buy_book" 					=> $FormValidator->buy_book(),							
						"mu_topic_conf" 			=> $FormValidator->topic_conf(),
						
					); 

			$data_work_info = array(
							"organization"	=> $FormValidator->organization(),
							"mu_uch_stepen" => $FormValidator->uch_stepen(),
							"mu_degree" 	=> $FormValidator->degree(),						
						);

			$error_conf		 = $FilterError->isError($data_conf);
			$error_work_info = $FilterError->isError($data_work_info);
			


			$data_all = $data_conf + $data_work_info;	
			//var_dump($error_conf)."<br>";
			if(($error_conf['error_status'] == 0)&&($error_work_info['error_status'] == 0)){
			
					$data_insert_work = array(
										"organization"	=> $FormValidator->organization(),
										// 'mu_city' 			=> $section,										 										
										 'mu_degree'		=> $FormValidator->degree(),
										 //'job'				=> $date,
										 'mu_user'			=> $this->storageUser['id'],
										 'mu_uch_stepen'	=> $FormValidator->uch_stepen(),
										 "mu_conf_type" 	=> $this->request->getPost('conf'),	
									);
					$data_insert_conf = array(
										'mu_user'				 => $this->storageUser['id'],
										"title_public"			 => $FormValidator->title_public(),
										"mu_type_presentation"	 => $FormValidator->type_presentation(),
										//"party" 				 => $FormValidator->party(),
										"hotel" 				 => $FormValidator->hotel(),
										"buy_book" 				 => $FormValidator->buy_book(),
										//"advanced_training_courses"	 => $FormValidator->training_courses(),
										"mu_topic_conf"				 => $FormValidator->topic_conf(),
										//"abstracts" 				 => $FormValidator->abstracts(),
										"mu_status" 				 => '2',
										"mu_conf_type" 				 => $this->request->getPost('conf'),
										"mu_status_view" 				=> '1',
										"mu_status_oplata" 				=> '2',
										"register_date"					=> date("Y-m-d H:i:s"),
									);									
					$done_work = $SqlContent->goInsert('mu_work_info',$data_insert_work);
					$data_insert_conf['mu_work_info'] = $SqlContent->lastInsertsId();
														 
									
								
					$done_conf = $SqlContent->goInsert('mu_conf',$data_insert_conf);
					if(($done_work)&&($done_conf)){
						$this->goToUrl('http://udhtu.waterh.net/mychem/conference/partaker/himsovrtehn_85year');
					}else{
						SetCookie("err_reg","Десь є помилка");
						$this->goToUrl('http://udhtu.waterh.net/mychem/conference/registration/himsovrtehn_85year');
						
					}
					}else{
					SetCookie("err_reg","Десь є помилка");
					$this->goToUrl('http://udhtu.waterh.net/mychem/conference/registration/himsovrtehn_85year');
				}
		
		}







						if(($this->request->getPost('conf') == 5)	){
			SetCookie("err_reg",null);
			$FilterError = new FilterError();
			$FormValidator = new FormValidator($this->request->getPost());	
			$data_conf = array(
						"title_public"				=> $FormValidator->title_public(),
						"mu_type_presentation"		=> $FormValidator->type_presentation(),						
						"hotel" 					=> $FormValidator->hotel(),	
						"buy_book" 					=> $FormValidator->buy_book(),							
						"mu_topic_conf" 			=> $FormValidator->topic_conf(),
						
					); 

			$data_work_info = array(
							"organization"	=> $FormValidator->organization(),
							"mu_uch_stepen" => $FormValidator->uch_stepen(),
							"mu_degree" 	=> $FormValidator->degree(),						
						);

			$error_conf		 = $FilterError->isError($data_conf);
			$error_work_info = $FilterError->isError($data_work_info);
			


			$data_all = $data_conf + $data_work_info;	
			//var_dump($error_conf)."<br>";
			if(($error_conf['error_status'] == 0)&&($error_work_info['error_status'] == 0)){
			
					$data_insert_work = array(
										"organization"	=> $FormValidator->organization(),
										// 'mu_city' 			=> $section,										 										
										 'mu_degree'		=> $FormValidator->degree(),
										 //'job'				=> $date,
										 'mu_user'			=> $this->storageUser['id'],
										 'mu_uch_stepen'	=> $FormValidator->uch_stepen(),
										 "mu_conf_type" 	=> $this->request->getPost('conf'),	
									);
					$data_insert_conf = array(
										'mu_user'				 => $this->storageUser['id'],
										"title_public"			 => $FormValidator->title_public(),
										"mu_type_presentation"	 => $FormValidator->type_presentation(),
										//"party" 				 => $FormValidator->party(),
										"hotel" 				 => $FormValidator->hotel(),
										//"buy_book" 				 => $FormValidator->buy_book(),
										//"advanced_training_courses"	 => $FormValidator->training_courses(),
										"mu_topic_conf"				 => $FormValidator->topic_conf(),
										//"abstracts" 				 => $FormValidator->abstracts(),
										"mu_status" 				 => '2',
										"mu_conf_type" 				 => $this->request->getPost('conf'),
										"mu_status_view" 				=> '1',
										"mu_status_oplata" 				=> '2',
										"register_date"					=> date("Y-m-d H:i:s"),
									);									
					$done_work = $SqlContent->goInsert('mu_work_info',$data_insert_work);
					$data_insert_conf['mu_work_info'] = $SqlContent->lastInsertsId();
														 
									
								
					$done_conf = $SqlContent->goInsert('mu_conf',$data_insert_conf);
					if(($done_work)&&($done_conf)){
						$this->goToUrl('http://udhtu.waterh.net/mychem/conference/partaker/tnr_2015');
					}else{
						SetCookie("err_reg","Десь є помилка");
						$this->goToUrl('http://udhtu.waterh.net/mychem/conference/registration/tnr_2015');
						
					}
					}else{
					SetCookie("err_reg","Десь є помилка");
					$this->goToUrl('http://udhtu.waterh.net/mychem/conference/registration/tnr_2015');
				}
		
		}



		if ($method == "GET") {				
			if(!empty($params))	{
				foreach ($this->getParams() as $key => $value) {					
					$params[urldecode($key)]=urldecode($value);
					if($key == 'partaker'){
						switch ($value) {
							case 'fuel':
								$topicConf = 1;
								break;
							case 'himsovrtehn':
								$topicConf = 2;
								break;
							case 'shevchenko':
								$topicConf = 3;
								break;
							case 'himsovrtehn_85year':
								$topicConf = 4;
								break;
							case 'tnr_2015':
								$topicConf = 5;
								$conf_email = 'tnv15@ukr.net';
								break;
						}

					}
				}				
			}
		}

		if(!empty($_FILES['file_tezis']))
			if(isset($_FILES['file_tezis']))
		if($_FILES['file_tezis']['error'] == 0){
			if(!empty($params))	{
				foreach ($this->getParams() as $key => $value) {					
					$params[urldecode($key)]=urldecode($value);
					if($key == 'partaker'){
						switch ($value) {
							case 'fuel':
								$topicConf = 1;
								$nameConf = "FUELL";
								break;
							case 'himsovrtehn':
								$topicConf = 2;
								$nameConf = "HIMSOVRTEHN";
								break;
							case 'shevchenko':
								$topicConf = 3;
								$nameConf = "SHEVCHENKO";
								break;
							case 'himsovrtehn_85year':
								$topicConf = 4;
								$nameConf = "HIMSOVRTEHN_85year";
								break;
							case 'tnr_2015':
								$topicConf = 5;
								$nameConf = "TNR_2015";
								$conf_email = 'tnv15@ukr.net';
								break;
						}
					}
				}				
			}			
		$data_select_mail = array($post['id_conf'],$this->storageUser['id']);
		$dataMail = $SqlContent->getConfMailData($data_select_mail);
		foreach ($dataMail as $key => $value) 
			foreach ($value as $key => $value){		
				$dataMail[$key] = $value;
			}
		if($dataMail['mu_status'] && $dataMail['mail'] && $dataMail['name']){
			if($dataMail['mu_status'] == '2' || $dataMail['mu_status'] == '4'  ){		
			$mess = $dataMail['sectionName'];
			$email = $dataMail['mail'];
			$name = $dataMail['name'];
			$message = '<b>Ф.И.О. пославшего: </b>'.$dataMail["last_name"].' '.$dataMail["name"].' '.$dataMail["middle_name"].'<br> <b>Электронный адрес: </b>'.$email.'<br><b>Секция: </b>'.$mess;
			//include "PHPMailer.php";// подключаем класс
			$mail = new PHPMailer();
			if ((isset($_o['cp1251'])) and ($_o['cp1251']==1))// если требуется кодировка cp1251
				{ $mail->CharSet='cp1251';// выставляем с какой кодировкой работать
				  $title=iconv('utf-8','windows-1251',$_o['title']);// кодируем заголовок
				  $text_=iconv('utf-8','windows-1251',$_o['text_']);// кодируем сам текст
				}
			else// иначе, по умолчанию используется кодировка UTF-8
				{ $mail->CharSet='utf-8';// выставляем с какой кодировкой работать
				  $title=$_o['title'];// прописываем заголовок
				  $text_=$_o['text_'];// прописываем текст
				}
			$mail->From = $email;
			$mail->FromName = $name;
			$mail->AddAddress('tnv15@ukr.net');
			switch ($topicConf) {
				case 1:
					$mail->AddCC('demy3@ukr.net'); 
					break;
				case 2:
					$mail->AddCC('demy4@ukr.net'); 
					break;
			}
			$mail->IsHTML(true);
			$mail->Subject = $nameConf;

			if(isset($_FILES['file_tezis'])){
				if($_FILES['file_tezis']['error'] == 0){
					$mail->AddAttachment($_FILES['file_tezis']['tmp_name'],$_FILES['file_tezis']['name']);
				}
			}
			$mail->Body = $message;
			if ($mail->Send()){
				$query = "mu_conf SET mu_status=? WHERE id=? and mu_user=?";
				$data_update_conf = array('3',$post['id_conf'],$this->storageUser['id']);						
				$done = $SqlContent->goUpdate($query,$data_update_conf);
				$this->goToUrl('http://udhtu.waterh.net/mychem/conference/send/done');
				//echo 'Спасибо за отправку вашего сообщения<br>';
				//var_dump($dataMail);
			}else{				
				$this->goToUrl('http://udhtu.waterh.net/mychem/conference/send/error');
			}		
			}
		
				}else{				
				$this->goToUrl('http://udhtu.waterh.net/mychem/conference/user/error');
			}		


		}else{
			$this->goToUrl('http://udhtu.waterh.net/mychem/conference/send/error');
		}
	
		$partakerInfo = $SqlContent->getConfPartaker($topicConf);
		$topic_conf = $SqlContent->getTopicConf($topicConf);
				$this->view->render('index', array( 'action' => $action,
											'method' => $method,
											'content' 	 => $content,
											'degree' 	 => $degree,
											'uch_stepen' 	 => $uch_stepen,
											'type_presentation' 	 => $type_presentation,
											'topic_conf' 	 => $topic_conf,
											'err' 	 => $err ,
											'params' 	 => $params ,
											'role' 	 => $this->storageUser['role'],
											'partakerInfo' 	 => $partakerInfo,
											'conf_email' 	 => $conf_email,

										));
	}



	public function registrationAction(){
		$SqlContent = new SqlContent();

		$module = $this->getModule();
		$method = $this->request->getMethod();		
		$action = $this->getAction();
		$params = $this->getParams();
		if ($method = "GET") {				
			if(!empty($params))	{
			foreach ($this->getParams() as $key => $value) {
					$params[urldecode($key)]=urldecode($value);
			}							
			$content = $SqlContent->getPage($params);
		}

		}


	
		$this->view->render('index', array(
											'content' => $content,
											'module' => $module,
											'contr' => $contr,
											'action' => $action,
											'method' => $method,
											)
							);

	}



	public function subSectionAction(){
		$SqlContent = new SqlContent();		
		$method = $this->request->getMethod();	
		$params = $this->getParams();	
		$arrSection = $SqlContent->getSection();
		$arrStatus = $SqlContent->getStatus();
		$arrSubSection = $SqlContent->getSubSection();

		if ($method == "GET") {
			if ((!empty($params))) {				
				if (key($params) === 'edit') {
					$pageAction = "edit_";
				}elseif (key($params) === 'new') {
					$pageAction = "new_";
				}else{
					$this->goToUrl('http://galtex.ua/admin/subSection');
				}								
			}
		}

		if($method == 'POST' && ($this->getAction() == 'subSection')){
				$pageAction = $this->request->getPost('pageAction');					
				$subSection = $this->request->getPost($pageAction.'subSection');
				$url = ( $this->request->getPost($pageAction.'url_subSection')) ? $this->request->getPost($pageAction.'url_subSection') : null ;
				$section = $this->request->getPost($pageAction.'section');
				$status = $this->request->getPost($pageAction.'status');
				$date 	= date("Y-m-d H:i:s"); 
				if ($pageAction === "new_") {
					$data_insert = array('subsection'	=> $subSection,
										 'gx_section' 	=> $section,
										 'gx_status' 	=> $status,
										 'url'			=> $url,
										 'date_create'	=> $date,
										 'date_update'	=> $date,
										 'gx_author_update'	=> $this->storageUser['id'],
										 'gx_author_create'	=> $this->storageUser['id'],	
									);			
					$done = $SqlContent->goInsert('gx_subsection',$data_insert);
				}elseif ($pageAction === "edit_") {
					$id  = $params['edit'];										
					$query = "gx_subsection SET subsection=?,gx_section=?, url=?, gx_status=?,date_update=?,gx_author_update=? WHERE id=?";
					$data_update = array($subSection,$section,$url,$status,$date,$this->storageUser['id'],$id);						
					$done = $SqlContent->goUpdate($query,$data_update);
				}							
				if ($done) {
					$this->goToUrl('http://galtex.ua/admin/subSection');
				}else{
					echo "Ne 4ego  s bazoy ne viwlo";
				}
		}

		$this->view->render('subSection', array( 
											'action'	=> $action,
											'section' 	=> $arrSection,
											'status' 	=> $arrStatus,
											'pageAction' 	=> $pageAction,
											'arrSubSection' => $arrSubSection,
											'id'			=>	$params['edit'],																					
										));
	}



	public function contentAction(){
		$SqlContent = new SqlContent();
		$query = "id,language FROM gx_language";
		$arrLanguage = $SqlContent->goSelect($query);
		$query = "id,subsection FROM gx_subsection";
		$arrSubSection = $SqlContent->goSelect($query);
		$arrStatus = $SqlContent->getStatus();
		$method = $this->request->getMethod();
		$params = $this->getParams();



		if ($this->request->getPost('id_sub')){
			$data_select = array($this->request->getPost('id_sub'));			
			$query = "
			con.title,con.id
			FROM gx_content as con
			WHERE con.gx_subsection=?";
		$arrTitle = $SqlContent->goSelect($query,$data_select);
			echo json_encode($arrTitle);
			exit();
		}
	

		$query = "
			distinct(sub.subsection),sub.id,stat.status
			FROM gx_content as con
			INNER JOIN gx_subsection as sub
			ON con.gx_subsection = sub.id
			INNER JOIN gx_status as stat
			ON con.gx_status = stat.id";
		$arrConSub = $SqlContent->goSelect($query);
		//var_dump($arrSubSection);


		if ($method == "GET") {
			if ((!empty($params))) {				
				if (key($params) === 'edit') {
					$pageAction = "edit_";

		$query = "
				con.id,con.content,con.gx_language,con.date_create,con.date_update,con.title,con.gx_subsection,con.gx_author_create,con.gx_author_update,con.combine_name,con.abstract,con.num_row,con.gx_status,con.call_url_value,con.call_url_key
				FROM gx_content as con 
				WHERE con.id=?";
		$data_select = array($params['edit']);
		$arrContent = $SqlContent->goSelect($query,$data_select);		
				}elseif (key($params) === 'new') {
					$pageAction = "new_";
				}else{
					$this->goToUrl('http://galtex.ua/admin/content');
				}								
			}
		}





		if($method == 'POST' && ($this->getAction() == 'content')){
			$pageAction = $this->request->getPost('pageAction');
			$sub_section 	= $this->request->getPost($pageAction.'subsection');
			$language 		= $this->request->getPost($pageAction.'language');
			$pk_language 	= $this->request->getPost($pageAction.'pk_language');			
			$title 			= $this->request->getPost($pageAction.'title');
			$abstract 		= $this->request->getPost($pageAction.'abstract');
			$content 		= $this->request->getPost($pageAction.'text');
			$status 		= $this->request->getPost($pageAction.'status');
			$call_value		= $this->request->getPost($pageAction.'call_value');
			$call_key 		= $this->request->getPost($pageAction.'call_key');
			$date 			= date("Y-m-d H:i:s");
			if ($pageAction === "new_") {
			$data_insert 	= array(
									'gx_subsection' 	=> $sub_section,
									 'gx_language' 		=> $language,
									 'combine_name' 	=> $pk_language,
									 'title' 			=> $title,
									 'abstract' 		=> $abstract,
									 'content' 			=> $content,
									 'gx_author_update'	=> $this->storageUser['id'],
									 'gx_author_create' => $this->storageUser['id'],
									 'date_create' 		=> $date,
									 'date_update'		=> $date,
									 'gx_status' 		=> $status,
									 'call_url_key' 	=> $call_key,
									 'call_url_value' 	=> $call_value,
								);
								//var_dump($data_insert);			
			$done = $SqlContent->goInsert('gx_content',$data_insert);
			}elseif ($pageAction === "edit_") {		
			$id  = $params['edit'];										
					$query = "gx_content SET gx_subsection=?,
											 gx_language=?,
											  combine_name=?,
											   title=?,
											   abstract=?,
											   content=?,
											   gx_author_update=?,
											   date_update=?,
											   gx_status=?,
											   call_url_key=?,
											   call_url_value=?
											   WHERE id=?";

					$data_update = array(
										$sub_section,
										$language,
										$pk_language,
										$title,
										$abstract,
										$content,
										$this->storageUser['id'],
										$date,
										$status,
										$call_key,
										$call_value,
										$id
									);						
					$done = $SqlContent->goUpdate($query,$data_update);
				}								
			if ($done) {
						$this->goToUrl('http://galtex.ua/admin/content');
					}else{
						$this->goToUrl('http://galtex.ua/admin/content/new/insert');
						echo "Ne 4ego  s bazoy ne viwlo";
					}
		}
		
		$this->view->render('content', array( 
											'subSection'	=> $arrSubSection,
											'language'		=> $arrLanguage,
											'status'		=> $arrStatus,
											'pageAction' 	=> $pageAction,
											'arrContent' 	=> $arrContent,
											'post' 	=> $posts,
											'conSub'	=> $arrConSub,
										));
	}


	


	public function leftMenuAction(){
		$SqlContent = new SqlContent();		
		$method = $this->request->getMethod();
		$params = $this->getParams();	
		$arrSection = $SqlContent->getSection();
		$arrStatus = $SqlContent->getStatus();
		$arrSubSection = $SqlContent->getSubSection();	
		//$arrLeftMenu = $SqlContent->getLeftMenu();

		$query = "
			distinct(sub.subsection),lm.gx_subsection
			FROM gx_left_menu as lm
			INNER JOIN gx_subsection as sub 
			ON lm.gx_subsection = sub.id
			ORDER BY sub.subsection";
		$arrLeft = $SqlContent->goSelect($query,$data_select);




if ($this->request->getPost('id_sub')){
			$data_select = array($this->request->getPost('id_sub'));			
			$query = "
			lm.url_name as title,lm.id
			FROM gx_left_menu as lm
			WHERE lm.gx_subsection=?";
		$arrTitle = $SqlContent->goSelect($query,$data_select);
			echo json_encode($arrTitle);
			exit();
		}













if ($method == "GET") {
			if ((!empty($params))) {				
				if (key($params) === 'edit') {
					$pageAction = "edit_";

					
				$query = "lmenu.id,lmenu.url_name,lmenu.url,lmenu.gx_subsection,lmenu.gx_status,stat.status FROM gx_left_menu as lmenu INNER JOIN  gx_status as stat ON lmenu.gx_status = stat.id 
				WHERE lmenu.id=?
				";
		$data_select = array($params['edit']);
		$arrLeftMenu = $SqlContent->goSelect($query,$data_select);		

				}elseif (key($params) === 'new') {
					$pageAction = "new_";
				}else{
					$this->goToUrl('http://galtex.ua/admin/leftMenu');
				}								
			}
		}




	if($method == 'POST' && ($this->getAction() == 'leftMenu')){
			$pageAction = $this->request->getPost('pageAction');
			$sub_section 	= $this->request->getPost($pageAction.'subsection');
			$urlName 		= $this->request->getPost($pageAction.'urlName');
			$url 			= $this->request->getPost($pageAction.'url');
			$status 		= $this->request->getPost($pageAction.'status');
			$date 			= date("Y-m-d H:i:s");
			if ($pageAction === "new_") {			
			$data_insert 	= array(								
									'gx_subsection' => $sub_section,
									'url_name' => $urlName,
									'url' => $url,
									'gx_status' => $status,
									'date_create' 	=> $date,
									'date_update'	=> $date,
									'gx_author_update' => $this->storageUser['id'],
									'gx_author_create' => $this->storageUser['id'],	
									);
			$done = $SqlContent->goInsert('gx_left_menu',$data_insert);

			}elseif ($pageAction === "edit_") {
					$id  = $params['edit'];										
					$query = "gx_left_menu SET url=?, url_name=?,gx_subsection=?, gx_status=?,date_update=?,gx_author_update=? WHERE id=?";
					$data_update = array($url,$urlName,$sub_section,$status,$date,$this->storageUser['id'],$id);						
					$done = $SqlContent->goUpdate($query,$data_update);
				}							
				if ($done) {
					$this->goToUrl('http://galtex.ua/admin/leftMenu');
					}else{						
						echo "Ne 4ego  s bazoy ne viwlo";
				}
			}				
		$this->view->render('leftMenu', array( 
											'action' => $action,
											'arrLeft' => $arrLeft,
											'subSection' => $arrSubSection,
											'status' => $arrStatus,
											'arrLeftMenu' => $arrLeftMenu,
											'pageAction' 	=> $pageAction,
											'id'		 =>	$params['edit'],
										));
	}




}