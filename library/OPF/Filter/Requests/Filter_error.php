<?php
namespace OPF\Filter\Requests;
	class Filter_error{

	public $error_type	= array();
	public $error_message = array();	
	public $error_status = 0;
	
	
/* 	public function __construct($error)
	{
			$i = 0;
			foreach($data as $kay => $value){				
				$data_back[$i] =$data[$kay];
				$i++;			
			}

	} */

	
	public function isError($error)
	{
		//var_dump($error);
		
		
		foreach($error as $key => $value){				
		
	
			switch($key){
			
				case "error_sex":{
					$this->error_message['error_sex'] = "Какаето ошибка в error_sex";
					$this->error_status +=1;				
					break;
				}


				case "cant_save_file_img":{
					$this->error_message['error_cant_save_file_img'] = "Не удалось сохранить картинку на сервере";
					$this->error_status +=1;				
					break;
				}

				case "error_cr_cat_pdf":{
					$this->error_message['error_cr_cat_pdf'] = "Не удалось создать директорию для пдф файла";
					$this->error_status +=1;				
					break;
				}

				case "error_cr_cat_pdf_1":{
					$this->error_message['error_cr_cat_pdf_1'] = "Не удалось создать 1 директорию для пдф файла";
					$this->error_status +=1;				
					break;
				}


				case "error_cr_cat_pdf_2":{
					$this->error_message['error_cr_cat_pdf_2'] = "Не удалось создать 2 директорию для пдф файла";
					$this->error_status +=1;				
					break;
				}

				case "error_exe":{
					$this->error_message['error_exe'] = "Данное разширение не допустимо";
					$this->error_status +=1;				
					break;
				}


				case "error_exe_1":{
					$this->error_message['error_exe_1'] = "Стоит точка но нет разширение или оно не правельно составленно";
					$this->error_status +=1;				
					break;
				}

				case "error_exe_2":{
					$this->error_message['error_exe_2'] = "В файле не указанно разрешение";
					$this->error_status +=1;				
					break;
				}



				case "error_resolution":{
					$this->error_message['error_resolution'] = "Данное разрешение  не допустимо";
					$this->error_status +=1;				
					break;
				}

				case "error_mail":{
					$this->error_message['error_mail'] = "Какаето ошибка в error_mail";
					$this->error_status +=1;				
					break;
				}
				case "error_login":{
					$this->error_message['error_login'] = "Какаето ошибка в error_login";
					$this->error_status +=1;				
					break;
				}
				case "error_password":{
					$this->error_message['error_password'] = "Какаето ошибка в error_password";
					$this->error_status +=1;				
					break;
				}
				case "error_name":{
					$this->error_message['error_name'] = "Какаето ошибка в error_name";
					$this->error_status +=1;				
					break;
				}
				case "error_last_name":{
					$this->error_message['error_last_name'] = "Какаето ошибка в error_last_name";
					$this->error_status +=1;				
					break;
				}
				case "error_middle_name":{
					$this->error_message['error_middle_name'] = "Какаето ошибка в error_middle_name";
					$this->error_status +=1;				
					break;
				}
				case "error_topic_conf":{
					$this->error_message['error_topic_conf'] = "Какаето ошибка в error_topic_conf";
					$this->error_status +=1;				
					break;
				}
				case "error_type_presentation":{
					$this->error_message['error_type_presentation'] = "Какаето ошибка в error_type_presentation";
					$this->error_status +=1;				
					break;
				}
				case "error_mob_phone":{
					$this->error_message['error_tel'] = "Какаето ошибка в error_mob_phone";
					$this->error_status +=1;				
					break;
				}
				case "error_skype":{
					$this->error_message['error_skype'] = "Какаето ошибка в error_skype";
					$this->error_status +=1;				
					break;
				}
				case "error_title_public":{
					$this->error_message['error_title_public'] = "Какаето ошибка в error_title_public";
					$this->error_status +=1;				
					break;
				}
				case "error_abstracts":{
					$this->error_message['error_abstracts'] = "Какаето ошибка в error_abstracts";
					$this->error_status +=1;				
					break;
				}
				case "error_uch_stepen":{
					$this->error_message['error_uch_stepen'] = "Какаето ошибка в error_uch_stepen";
					$this->error_status +=1;				
					break;
				}				
				case "error_degree":{
					$this->error_message['error_degree'] = "Какаето ошибка в error_degree";
					$this->error_status +=1;				
					break;
				}
				case "error_organization":{
					$this->error_message['error_organization'] = "Какаето ошибка в error_organization";
					$this->error_status +=1;				
					break;
				}
				case "error_captcha":{
					$this->error_message['error_captcha'] = "Какаето ошибка в error_captcha";
					$this->error_status +=1;				
					break;
				}
				case "error_trans":{
					$this->error_message['error_trans'] = "Какаето ошибка при тразакции";
					$this->error_status +=1;				
					break;
				}
				//default:
				///	 	$this->error_message[$i] = "Какаето непредвиденная ошибка";
					//	$this->error_text = $this->error_type[$i];		
					///break;
			}
		}
		$this->error_message['error_status'] = $this->error_status ;
		return $this->error_message;
		
	}











}















?>