<?php
namespace Mychem\Controller;

use OPF\Mvc\Controller\AbstractController;
use OPF\Filter\Requests\FormValidator;
use Mychem\Model\SqlContent;
use Mychem\Filter\FilterError;
class MyactivController extends AbstractController
{
	
	
	public function indexAction(){		
		$SqlContent = new SqlContent();
		$action = $this->getAction();
		$method = $this->request->getMethod();
		$contr  = $this->request->getPost();				
		$user = $_SESSION['storageUser'];
		$confInfo = $SqlContent->getConfInfo();
		$this->view->render('index', array( 'action' => $action,
											'method' => $method,
											'post' 	 => $contr,
											'user' 	 => $user,
											'confInfo' 	 => $confInfo,
										));
	}




		public function activconfAction(){		
$SqlContent = new SqlContent();
		$action = $this->getController();
		$method = $this->request->getMethod();
		$post  = $this->request->getPost();	
		$params = $this->getParams();
		$user = $_SESSION['storageUser'];
		if ($method == "GET") {				
			if(!empty($params))	{
				foreach ($this->getParams() as $key => $value) {					
					$params[urldecode($key)]=urldecode($value);					
						switch ($key) {
							case 'fuel':
								$topicConf = 1;
								break;
							case 'himsovrtehn':
								$topicConf = 2;
								break;
						}

					
				}				
			}
		}













		
			if(!($this->request->getPost('id_section')))	{
			$confInfo = $SqlContent->getConfInfo($topicConf);
		}else{
			$topicConf_section = array(2,$this->request->getPost('id_section') );	
			$confInfo = $SqlContent->getConfInfoSort($topicConf_section);

			echo json_encode($confInfo)	;		
		}
		$data_userid_typeconf = array($this->storageUser['id'],$topicConf );
		$titlePublic = $SqlContent->getUserTitlePublic($data_userid_typeconf);
		

		
			if(is_numeric($params['fuel'])){
				$id_conf = (int)trim((htmlspecialchars(strip_tags($params['fuel']))));	
				 $id_conf = array($id_conf,$user['id']);	
				$conf_data = $SqlContent->getConfData($id_conf);
				
			}
			if(is_numeric($params['himsovrtehn'])){
				$id_conf = (int)trim((htmlspecialchars(strip_tags($params['himsovrtehn']))));
				 $id_conf = array($id_conf,$user['id']);	
				$conf_data = $SqlContent->getConfData($id_conf);
			}
		
			

		



		$topic_conf = $SqlContent->getTopicConf($topicConf);
			$degree = $SqlContent->getDegree();
				$uch_stepen = $SqlContent->getUchStepen();
				$type_presentation = $SqlContent->getTypePresent();









if(($this->request->getPost('conf') == 1)	){
			$id_conf = (int)trim((htmlspecialchars(strip_tags($params['fuel']))));
			$id_work = (int)trim((htmlspecialchars(strip_tags($_POST['id_work']))));
			SetCookie("err_reg",null);
			$FilterError = new FilterError();
			$FormValidator = new FormValidator($this->request->getPost());	
			$data_conf = array(
						"title_public"				=> $FormValidator->title_public(),
						"mu_type_presentation"		=> $FormValidator->type_presentation(),
						"party" 					=> $FormValidator->party(),
						//"hotel" 					=> $FormValidator->hotel(),
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
										// 'mu_user'			=> $this->storageUser['id'],
										 'mu_uch_stepen'	=> $FormValidator->uch_stepen(),
										// "mu_conf_type" 	=> $this->request->getPost('conf'),	
									);
					$data_insert_conf = array(
										//'mu_user'				 => $this->storageUser['id'],
										"title_public"			 => $FormValidator->title_public(),
										"mu_type_presentation"	 => $FormValidator->type_presentation(),
										"party" 				 => $FormValidator->party(),
										//"hotel" 				 => $FormValidator->hotel(),
										"advanced_training_courses"	 => $FormValidator->training_courses(),
										"mu_topic_conf"				 => $FormValidator->topic_conf(),
										"abstracts" 				 => $FormValidator->abstracts(),
										//"mu_status" 				 => '2',
										//"mu_conf_type" 				 => $this->request->getPost('conf'),
										//"mu_status_view" 				=> '2',
										//"mu_status_oplata" 				=> '2',
										//"register_date"					=> date("Y-m-d H:i:s"),
									);									

					if(is_numeric($id_conf) && is_numeric($id_work) ){
								$query = "mu_conf SET title_public=?, mu_type_presentation=?, party=? , advanced_training_courses=?  ,mu_topic_conf=? ,abstracts=?  WHERE id=? and mu_user=?";
								$data_update_conf = array($data_insert_conf['title_public'],$data_insert_conf['mu_type_presentation'],$data_insert_conf['party'],$data_insert_conf['advanced_training_courses'],$data_insert_conf['mu_topic_conf'],$data_insert_conf['abstracts'],$id_conf,$user['id']);						
								$done_conf = $SqlContent->goUpdate($query,$data_update_conf);

								$query = "mu_work_info SET organization=?, mu_degree=? ,mu_uch_stepen=?  WHERE id=? and mu_user=?";
								$data_update_work = array($data_insert_work['organization'],$data_insert_work['mu_degree'],$data_insert_work['mu_uch_stepen'],$id_work,$user['id']);						
								$done_work = $SqlContent->goUpdate($query,$data_update_work);
							}


					if(($done_work)&&($done_conf)){
						$this->goToUrl('http://udhtu.waterh.net/mychem/activconf/'.key($params).'/done');
					}else{
						SetCookie("err_reg","Десь є помилка");
						//var_dump($done_work."<br>".$done_conf);
					$this->goToUrl('http://udhtu.waterh.net/mychem/activconf/fuel/'.$id_conf);
						
					}
					}else{
					SetCookie("err_reg","Десь є помилка");
					$this->goToUrl('http://udhtu.waterh.net/mychem/activconf/fuel/'.$id_conf);
				}

					
		
		}


























						if(($this->request->getPost('conf') == 2)	){
							$id_conf = (int)trim((htmlspecialchars(strip_tags($params['himsovrtehn']))));
							$id_work = (int)trim((htmlspecialchars(strip_tags($_POST['id_work']))));
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
										// 'mu_user'			=> $this->storageUser['id'],
										 'mu_uch_stepen'	=> $FormValidator->uch_stepen(),
										// "mu_conf_type" 				 => $this->request->getPost('conf'),	
									);
					$data_insert_conf = array(
										//'mu_user'				 => $this->storageUser['id'],
										"title_public"			 => $FormValidator->title_public(),
										"mu_type_presentation"	 => $FormValidator->type_presentation(),
										//"party" 				 => $FormValidator->party(),
										"hotel" 				 => $FormValidator->hotel(),
										//"advanced_training_courses"	 => $FormValidator->training_courses(),
										"mu_topic_conf"				 => $FormValidator->topic_conf(),
										//"abstracts" 				 => $FormValidator->abstracts(),
										//"mu_status" 				 => '2',
										//"mu_conf_type" 				 => $this->request->getPost('conf'),
										//"mu_status_view" 				=> '2',
										//"mu_status_oplata" 				=> '2',
										//"register_date"					=> date("Y-m-d H:i:s"),
									);


						if(is_numeric($id_conf) && is_numeric($id_work) ){
									$query = "mu_conf SET title_public=?, mu_type_presentation=?, hotel=? ,mu_topic_conf=?  WHERE id=? and mu_user=?";
			$data_update_conf = array($data_insert_conf['title_public'],$data_insert_conf['mu_type_presentation'],$data_insert_conf['hotel'],$data_insert_conf['mu_topic_conf'],$id_conf,$user['id']);						
			$done_conf = $SqlContent->goUpdate($query,$data_update_conf);

												$query = "mu_work_info SET organization=?, mu_degree=? ,mu_uch_stepen=?  WHERE id=? and mu_user=?";
			$data_update_work = array($data_insert_work['organization'],$data_insert_work['mu_degree'],$data_insert_work['mu_uch_stepen'],$id_work,$user['id']);						
			$done_work = $SqlContent->goUpdate($query,$data_update_work);
		}



					if(($done_work)&&($done_conf)){
						$this->goToUrl('http://udhtu.waterh.net/mychem/activconf/'.key($params).'/done');
					}else{
						SetCookie("err_reg","Десь є помилка");
						//var_dump($done_work."<br>".$done_conf);
					$this->goToUrl('http://udhtu.waterh.net/mychem/activconf/himsovrtehn/'.$id_conf);
						
					}
					}else{
					SetCookie("err_reg","Десь є помилка");
					$this->goToUrl('http://udhtu.waterh.net/mychem/activconf/himsovrtehn/'.$id_conf);
				}
		
		}	

		
//var_dump($post);
		//echo $post['testtext']; 

		// $this->goToUrl('http://udhtu.waterh.net/mychem/conf/users/fuel');

		
		$this->view->render('activconf', array( 'action' => $action,
											'method' => $method,
											'post1' 	 => $post1,
											'user' 	 => $user,
											'confInfo' 	 => $confInfo,
											'params' 	 => $params,
											'titlePublic' 	 => $titlePublic,
											'conf_data' 	 => $conf_data,
											'degree' 	 => $degree,
											'uch_stepen' 	 => $uch_stepen,
											'type_presentation' 	 => $type_presentation,
											'topic_conf' 	 => $topic_conf,
											
										));

	}



	

}