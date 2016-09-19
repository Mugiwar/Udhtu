<?php

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
		$this->error_status = 0;
		$i = 0;
		foreach($error as $kay => $value){				
				$this->error_type[$i] =$error[$kay];
				$i++;			
			}
		
		for($i=0;(count($this->error_type)-1) >= $i;$i++){
	
			switch($this->error_type[$i]){
			
				case "error_sex":{
					$this->error_message['error_sex'] = "Какаето ошибка в error_sex";
					//$this->error_status +=1;				
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
			}
		}
		$this->error_message['error_status'] = $this->error_status ;
		return $this->error_message;
		
	}











}















?>