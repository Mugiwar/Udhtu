<?php
namespace Mychem\Controller;

use OPF\Mvc\Controller\AbstractController;
use OPF\Filter\Requests\FormValidator;
use Mychem\Model\SqlContent;
//use OPF\Filter\Requests\Filter_error;
class CpanelController extends AbstractController
{
	
	
	public function indexAction(){		
		$SqlContent = new SqlContent();
		$params = $this->getParams();	
		$action = $this->getAction();
		$method = $this->request->getMethod();
		$contr  = $this->request->getPost();				
		$user = $_SESSION['storageUser'];
		$confInfo = $SqlContent->getConfInfo();
		$this->view->render('index', array( 'action' => $action,
											'method' => $method,
											'post' 	 => $contr,
											'params' 	 => $params,
											'user' 	 => $user,
											'confInfo' 	 => $confInfo,
										));
	}


		public function users_adminAction(){		
		$SqlContent = new SqlContent();
		$params = $this->getParams();	
		$action = $this->getAction();
		$method = $this->request->getMethod();
		$contr  = $this->request->getPost();				
		$user = $_SESSION['storageUser'];

		$main_job = $SqlContent->getMRD(3,5); //1 - основная работа в таблице и тп 
		$degree = $SqlContent->getMRD(2,7);
		$uch_stepen = $SqlContent->getMRD(2,6);







			if (($method == "POST") && ($this->request->getPost('mus_login')) ) {
	

	$mus_login_data = $SqlContent->getLoginData($this->request->getPost('mus_login'));

					//$json_data = array ('id'=>$mus_login_data);

									echo json_encode($mus_login_data);
									exit;


			}



		$this->view->render('users-admin', array( 'action' => $action,
											'main_job' 	 => $main_job,
											'degree' 	 => $degree,
											'uch_stepen' 	 => $uch_stepen,
											'method' => $method,
											'post' 	 => $contr,
											'params' 	 => $params,
											'user' 	 => $user,
											'confInfo' 	 => $confInfo,
										),'layout1');
	}





		public function adminka_udhtu_check_inAction(){		
		$SqlContent = new SqlContent();
		$FormValidator = new FormValidator($this->request->getPost());
		$params_all = $this->getParams();		
		$action = $this->getAction();
		$method = $this->request->getMethod();
		$contr  = $this->request->getPost();				
		$user = $_SESSION['storageUser'];
		$_SESSION['l_menu'] = '/check_in_left_menu.phtml';
		$UserPermission = $this->getUserPermission();

		if ($method == "GET") {	
			
			list($url_part, $qs_part) = array_pad(explode("?", $_SERVER['REQUEST_URI']), 2, ""); // Разбиваем URL на 2 части: до знака ? и после
			//var_dump($url_part);	
			switch ($_GET['l']) {
				case 1:					
					$_SESSION['lang_lk'] = 1;
					//$leftMenuName = $SqlContent->getLeftMenuName(1);
					$this->goToUrl($url_part);	
					break;
				case 2:					
					$_SESSION['lang_lk'] = 2;
					//$leftMenuName = $SqlContent->getLeftMenuName(2);
					$this->goToUrl($url_part);	
					break;
				case 3:					
					$_SESSION['lang_lk'] = 3;
					//$leftMenuName = $SqlContent->getLeftMenuName(2);
					$this->goToUrl($url_part);	
					break;
				default:
					$_SESSION['lang_lk'] = ($_SESSION['lang_lk']) ? $_SESSION['lang_lk'] : 1;
					break;
			}


			$params_last =	each(array_reverse($params_all,TRUE));
			//var_dump($params_last['key']);
			$params_last['value'] = (($params_last['value'])=== "endo") ? $params_last['key'] : $params_last['value'];
			//$params_last['value'] = ((int)is_numeric($params_last['value'])) ? $params_last['value'] : $params_last['value'] = "";
				//var_dump($params_last['key']);
			//var_dump($params_last);




			$arr_user_data1 = $UserPermission['params'][$this->getAction()];

		if ($arr_user_data1['privilege']['delete'] == 'allow') {
				$delet_div = '<div id="trash" class="ui-widget-content ui-state-default"><h4 class="ui-widget-header"><span class="ui-icon ui-icon-trash">Урна</span> Урна</h4></div>';
			}
		if ($arr_user_data1['privilege']['update'] == 'allow') {
				$update_div = '<div id="edit_all" class="ui-widget-content ui-state-default"><h4 class="ui-widget-header"><span class="ui-icon ui-icon-pencil">Редактор</span> Редактор</h4>Для редактирования информации передяните нужній блок сюда или нажмите маркер карандаша</div>';
			}
		if ($arr_user_data1['privilege']['write'] == 'allow') {
				$write_div = '  <div id="catalog">	<div type_block="section" block="<?=$params_last_key?>" parent="<?=$params_last_key?>" style="cursor: pointer;margin-left: 270px;">Ссылка ВСЕМОГУЩАЯ!</div> </div>';
			}

			$arr_user_data = $arr_user_data1['page'];
			$arr_user_block = $arr_user_data1['block'];
			$arr_user_acess = $arr_user_data1['punct'];

			$arr_block_id_user = array_keys($arr_user_block);

$arr_user_acess_id_punct = array_keys($arr_user_acess);







			
				for ($i=0; $i < count($arr_user_acess_id_punct) ; $i++) { 
					 $arr_user_acess_id_page = $arr_user_acess[$arr_user_acess_id_punct[$i]]['page'];
					for ($ii=0; $ii < count($arr_user_acess_id_page) ; $ii++) { 

						if ($arr_user_acess_id_page[$ii] == 'all') {

										if ($userPage) {
											$userPage = $userPage.',' ;
										}
									$query = "	call_url_value FROM mu_content_info WHERE mu_block_punct=? and mu_status_check = 3 and mu_status_show= 1";												
									$arr_acess_for_edit = $SqlContent->getAllCallUrl($query,$arr_user_acess_id_punct[$i]);
									$userPage =$userPage.$arr_acess_for_edit;
									continue;
							
						}


						if ($userPage) {
							$userPage = $userPage.',' ;
						}
						$userPage = $userPage.$arr_user_acess_id_page[$ii] ;
						//$userPage = ($ii ==  count($arr_user_acess_id_page)-1) ? $userPage : $userPage.',' ;
					}



					if ($userPunct) {
						$userPunct = $userPunct.',' ;
					}
					$userPunct = $userPunct.$arr_user_acess_id_punct[$i] ;
					//$userPunct = ($i ==  count($arr_user_acess_id_punct)-1) ? $userPunct : $userPunct.',' ;
				}

				//var_dump($userPage);
				//$content = $SqlContent->getPage1($params_last['key'],NULL,$FormValidator->language_lk(),$userPage1);
				//var_dump($content);
			








						if($_COOKIE['block_switcher']) {
							$type_age =  'new_page';
							if ($_COOKIE['block_switcher'] == 'update_page') {
								$type_age =  'update_page';
							}
								if ($_COOKIE['block_switcher'] == 'new_page') {
								$type_age =  'new_page';

							}

						}	

				
				
						$available_data = array(
													'punct' => $userPunct, 
													'page' => $userPage,


											);


						if($action == "adminka_udhtu_check_in"){
							$available_data = 'all';

						}

				
				$checkPage = $SqlContent->getCheckPage($FormValidator->language_lk(),$available_data,$type_age);
				$_SESSION['check_page'] = $checkPage;
			//var_dump($available_data);
		//	if(($params_last['key'] != "") && ($params_last['value'] != "all")) {
			//	$content = $SqlContent->getPage1($params_last['key'],$params_last['value'],$FormValidator->language_lk());
				
			//}
		}






if ($method == "POST") {	


			switch ($this->request->getPost('edit')) {
				

				case 'check_in_page':



if (($this->request->getPost('data_or_id') != '') && ($this->request->getPost('check_status') == 1) ) {
								




						
									$id = $this->request->getPost('data_id');
									$or_id = $this->request->getPost('data_or_id');
									$query = "mu_content_info SET mu_status_check=?,notification=?,mu_author_check=?,data_check=? WHERE id=?";
									$data_update = array(
														1,
														$this->request->getPost('mu_notification'),
														$this->storageUser['id'],
														date("Y-m-d H:i:s"),
														$id,
													);			
									$mu_content_info = $SqlContent->goUpdate($query,$data_update);

									$query = "mu_content SET content=(SELECT mu_content_info.content
																									FROM
																									  mu_content_info 
																									  where 
																									  mu_content_info.id = ?
																									  )
																									   WHERE id=?";
														$data_update = array(
														$id,												
														$or_id,
														
													);			
									$mu_content = $SqlContent->goUpdate($query,$data_update);
											
									//var_dump($data_update);
									$json_data = array ('id'=>4,'name'=>$data_update,'con'=>$FormValidator->language_lk());

									echo json_encode($json_data);
									exit;



							}else{
								if (($this->request->getPost('data_id') != '') && ($this->request->getPost('check_status') == 1) ) {
									
									
										$id = $this->request->getPost('data_id');

										$query = "mci.main_page,mci.call_url_value,mci.mu_language,mci.mu_block_punct,mci.mu_author_create,mci.content,mci.preview,mci.title,mci.data_create
														FROM mu_content_info mci
														WHERE 
														mci.id =?";													 
										$content_data = $SqlContent->checkDate($query,$id);


										$data_content_page = array(
																	"main_page"			=> $content_data['main_page'],
																	"call_url_value"	=> $content_data['call_url_value'],										
																	"mu_language"		=> $content_data['mu_language'],					
																	"mu_block_punct"	=> $content_data['mu_block_punct'],
																	"mu_author_create" 	=> $content_data['mu_author_create'],
																	"content" 			=> $content_data['content'],
																	"preview" 			=> $content_data['preview'],
																	"title" 			=> $content_data['title'],
																	"data_create" 		=> $content_data['data_create'],
																	"mu_status_show" 	=> 1,
															);										
										//var_dump($data_insert_page);
										$mu_content = $SqlContent->goInsert('mu_content',$data_content_page);
										$last_Insert_id		= $SqlContent->lastInsertsId();

										$query = "mu_content_info SET mu_status_check=?,notification=?,mu_author_check=?,data_check=?,mu_content=? WHERE id=?";
										$data_update = array(
															1,
															$this->request->getPost('mu_notification'),
															$this->storageUser['id'],
															date("Y-m-d H:i:s"),
															$last_Insert_id,
															$id,

														);			
										$mu_content_info = $SqlContent->goUpdate($query,$data_update);






										//Поиск первого предка
										$query = "id,parents_punct FROM mu_block_punct";
										$test_find_punct = $SqlContent->goSelect($query);
										$par = $content_data['mu_block_punct'];
										$parent_right =& $par;

										while($parent_right > 1){ 

											foreach ($test_find_punct as $key => $value) {	
												if($value['id'] == $par){
													$par = $value['parents_punct'];	
													$par1 = $value['id'];												
												}
											}
										}


										$data_content_user = array(
													"mu_right"	=> $par1,
													"id_data"	=> $last_Insert_id,										
													"data"		=> 'page',
												);
													
										//var_dump($data_insert_page);
										$mu_content_user = $SqlContent->goInsert('mu_content_user',$data_content_user);






										$json_data = array ('id'=>4,'name'=>$last_Insert_id,'con'=>$FormValidator->language_lk());

										echo json_encode($json_data);
										exit;

								}

						}





						if (($this->request->getPost('check_status') == 5) ) {
								




						
									$id = $this->request->getPost('data_id');
									$or_id = $this->request->getPost('data_or_id');
									$query = "mu_content_info SET mu_status_check=?,notification=?,mu_author_check=?,data_check=? WHERE id=?";
									$data_update = array(
														5,
														$this->request->getPost('mu_notification'),
														$this->storageUser['id'],
														date("Y-m-d H:i:s"),
														$id,
													);			
									$mu_content_info = $SqlContent->goUpdate($query,$data_update);

					
											
									//var_dump($data_update);
									$json_data = array ('id'=>4,'name'=>$data_update,'con'=>$FormValidator->language_lk());

									echo json_encode($json_data);
									exit;



							}














					break;



				
				default:
					# code...
					break;
			}





		}






		$this->view->render('adminka-udhtu-check-in', array( 
											'write_div' => $write_div,
											'delet_div' => $delet_div,
											'update_div' => $update_div,
											'content' => $content,											
											'method' => $method,
											'post' 	 => $contr,
											'params_last_key' 	 => $params_last['key'],
											'user' 	 => $user,
											'confInfo' 	 => $confInfo,
										),'layout1');
	}





	public function udhtu_blockAction(){		
		$SqlContent = new SqlContent();
		$FormValidator = new FormValidator($this->request->getPost());
		$params_all = $this->getParams();		
		$action = $this->getAction();
		$method = $this->request->getMethod();
		$contr  = $this->request->getPost();				
		$user = $_SESSION['storageUser'];
		$_SESSION['l_menu'] = '/left_menu.phtml';
		//unset($_SESSION['l_menu']);
		$UserPermission = $this->getUserPermission();
		






		if ($method == "GET") {	
			list($url_part, $qs_part) = array_pad(explode("?", $_SERVER['REQUEST_URI']), 2, ""); // Разбиваем URL на 2 части: до знака ? и после
			var_dump($url_part);	
			switch ($_GET['l']) {
				case 1:					
					$_SESSION['lang_lk'] = 1;
					//$leftMenuName = $SqlContent->getLeftMenuName(1);
					$this->goToUrl($url_part);	
					break;
				case 2:					
					$_SESSION['lang_lk'] = 2;
					//$leftMenuName = $SqlContent->getLeftMenuName(2);
					$this->goToUrl($url_part);	
					break;
				case 3:					
					$_SESSION['lang_lk'] = 3;
					//$leftMenuName = $SqlContent->getLeftMenuName(2);
					$this->goToUrl($url_part);	
					break;
				default:
					$_SESSION['lang_lk'] = ($_SESSION['lang_lk']) ? $_SESSION['lang_lk'] : 1;
					break;
			}


				//функция смены ключа масива
			function change_key($key,$new_key,&$arr,$rewrite=true){
    if(!array_key_exists($new_key,$arr) || $rewrite){
        $arr[$new_key]=$arr[$key];
        unset($arr[$key]);
        return true;
    }
        return false;
}
		

//print_r($params_all);

			
			$params_last =	each(array_reverse($params_all,TRUE));
			//var_dump($params_last['key']);
			$params_last['value'] = (($params_last['value'])=== "endo") ? $params_last['key'] : $params_last['value'];
			//$params_last['value'] = ((int)is_numeric($params_last['value'])) ? $params_last['value'] : $params_last['value'] = "";
				//var_dump($params_last['key']);
			//var_dump($params_last);
			


			// Получаем права которые лежат в UserPermission и начинаем фасовать
			$arr_user_data1 = $UserPermission['params'][$this->getAction()];

		if ($arr_user_data1['privilege']['delete'] == 'allow') {
				$delet_div = '<div id="trash" class="ui-widget-content ui-state-default"><h4 class="ui-widget-header"><span class="ui-icon ui-icon-trash">Урна</span> Урна</h4></div>';
			}
		if ($arr_user_data1['privilege']['update'] == 'allow') {
				$update_div = '<div id="edit_all" class="ui-widget-content ui-state-default"><h4 class="ui-widget-header"><span class="ui-icon ui-icon-pencil">Редактор</span> Редактор</h4>Для редактирования информации передяните нужній блок сюда или нажмите маркер карандаша</div>';
			}
		if ($arr_user_data1['privilege']['write'] == 'allow') {
				$write_div = '  <div id="catalog">	<div type_block="section" block="'.$params_last['key'].'" parent="'.$params_last['key'].'" style="cursor: pointer;margin-left: 270px;">Ссылка ВСЕМОГУЩАЯ!</div> </div>';
			}

			$arr_user_data = $arr_user_data1['punct'];
			$arr_user_block = $arr_user_data1['block'];


			$arr_block_id_user = array_keys($arr_user_block);
//var_dump($arr_block_id_user);





			if (key($arr_user_data) == 'all'){
				change_key('all',$params_last['key'],$arr_user_data);
			}
			
			



					for ($i=0; $i < count($arr_block_id_user) ; $i++) { 
						$qw = array_values($arr_user_block[$arr_block_id_user[$i]]);						
				for ($ii=0; $ii < count($qw) ; $ii++) { 
					if ($userPunct) {
						$userPunct = $userPunct.',' ;
					}
					$userPunct = $userPunct.$qw[$ii] ;
					//$userPunct = ($ii ==  count($qw)-1) ? $userPunct : $userPunct.',' ;
				}



				


					$userBlock = $userBlock.$arr_block_id_user[$i] ;
					$userBlock = ($i ==  count($arr_block_id_user)-1) ? $userBlock : $userBlock.',' ;
				}
				$_SESSION['block'] = $userBlock;
				$_SESSION['punct'] = $userPunct;
				//var_dump($userPunct);
				//var_dump(array_values($arr_user_block[54]));


			if(($params_last['key'] != "") && ($params_last['value'] === "all") && ($arr_user_data[$params_last['key']]['folder'])) {
				
				$arr_user_folder =$arr_user_data[$params_last['key']]['folder'];




				
				for ($i=0; $i < count($arr_user_folder) ; $i++) { 
					
					$userFolder = $userFolder.$arr_user_folder[$i] ;
					$userFolder = ($i ==  count($arr_user_folder)-1) ? $userFolder : $userFolder.',' ;
				}

				//var_dump($userFolder);
				$folder1111 = $SqlContent->getFolder($params_last['key'],$FormValidator->language_lk(),$userFolder);
				
			}









			if(($params_last['key'] != "") && ($params_last['value'] === "all") && ($arr_user_data[$params_last['key']]['page'])) {
				
				




				$arr_user_page = $arr_user_data[$params_last['key']]['page'];
				for ($i=0; $i < count($arr_user_page) ; $i++) { 
					
					$userPage = $userPage.$arr_user_page[$i] ;
					$userPage = ($i ==  count($arr_user_page)-1) ? $userPage : $userPage.',' ;
				}

				
				$content = $SqlContent->getPage1($params_last['key'],NULL,$FormValidator->language_lk(),$userPage);
				//var_dump($content);
			}
			//if(($params_last['key'] != "") && ($params_last['value'] != "all")) {
				//$content = $SqlContent->getPage1($params_last['key'],$params_last['value'],$FormValidator->language_lk());

			//}

		}




		
		if (($method == "POST") && ($UserPermission['privilege']['write'] == 'allow') ) {

			switch($this->request->getPost('insert')){
				case 'block':
														//mrd
							$block_path = $SqlContent->getUrlBFId('BF',trim($this->request->getPost('mu_url_title')));
							
							if(empty($block_path[0]['mrd_id'])){
								$data_insert_block_mrd = array(
											"mu_reference_catalog"	=>	"1",
											"data"					=> $this->request->getPost('mu_url_title'),
										);
								$mu_block = $SqlContent->goInsert('mu_reference_data',$data_insert_block_mrd);
								$last_Insert_id		= $SqlContent->lastInsertsId();
							}else{
								$last_Insert_id	= $block_path[0]['mrd_id'];
							}			
						
							



							//mu_table_taranslate		
							$data_insert_block_mtt = array(
												"mu_table_using"	=> "4",													
												"id_data_using"		=> $last_Insert_id,	
												"data"				=> $this->request->getPost('mu_name'),
												"short_data"		=> $this->request->getPost('mu_name'),
												"mu_language"		=> $FormValidator->language_lk(),
											);
							$mu_block = $SqlContent->goInsert('mu_table_translate',$data_insert_block_mtt);
							$last_Insert_id		= $SqlContent->lastInsertsId();

								
//var_dump($FormValidator->position());
							//mu_info_mtt		
							$data_insert_info_mtt = array(		
												"mu_table_translate"	=> $last_Insert_id,												
												"type_content"			=> $this->request->getPost('type_content'),		
												"type_position"			=> $FormValidator->position(),
												"type_face"				=> $this->request->getPost('type_face'),															
												"type_access"			=> "privacy",	
												"path"					=> $last_Insert_id,											
																	
												"url"					=> "#",
												"porydok"				=> 1,
												//"mu_status"				=> $FormValidator->status_chb_rb(),
												"mu_status"				=> 1,
											);
							$mu_block = $SqlContent->goInsert('mu_info_mtt',$data_insert_info_mtt);
							
							$last_Insert_id		= $SqlContent->lastInsertsId();

							


							//mu_log_imtt	
							$data_insert_log_imtt = array(
								
								"mu_table_using"	=> '5',
								"id_data_using"		=> $last_Insert_id,														
								"mu_users" 			=> $this->storageUser['id'],
								"date" 				=> date("Y-m-d H:i:s"),
								"action"			=> 'create',
								"ip"				=> $FormValidator->ip(),
								
							);
							$mu_block = $SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt);

				

							

							echo json_encode($json_data);
							exit;

							break;



					
				case 'punct':

							//mrd	

							$path_url	= $SqlContent->getPathUrl($this->request->getPost('mrd'),$FormValidator->language_lk());
							if(count($path_url) > 1){
								foreach ($path_url as $key => $value) {
									if($value['path'] != $value['id_mtt']){
										$path.=$value['path'].'/'.$value['id_mtt'].'|';
									}else{
										$path.=$value['path'].'|';
									}
								}

		


								$block_path = $SqlContent->getUrlBFId('subBF',trim($this->request->getPost('mu_url_title')),$path);
							}else{
								if ($path_url[0]['id_mtt'] != $path_url[0]['path'] ) {
									$path = $path_url[0]['path'].'/'.$path_url[0]['id_mtt'];
								}else{
									$path = $path_url[0]['path'];
								}

								$block_path = $SqlContent->getUrlBFId('subBF',trim($this->request->getPost('mu_url_title')),$path);
							}


							if(empty($block_path[0]['mrd_id'])){
								$data_insert_block_mrd = array(
											"mu_reference_catalog"	=>	"1",
											"data"					=> $this->request->getPost('mu_url_title'),
										);
								$mu_block = $SqlContent->goInsert('mu_reference_data',$data_insert_block_mrd);
								$last_Insert_id		= $SqlContent->lastInsertsId();
							}else{
								$last_Insert_id	= $block_path[0]['mrd_id'];
							}	





							//mu_table_taranslate		
							$data_insert_block_mtt = array(
												"mu_table_using"	=> "4",													
												"id_data_using"		=> $last_Insert_id,	
												"data"				=> $this->request->getPost('mu_name'),
												"short_data"		=> $this->request->getPost('mu_name'),
												"mu_language"		=> $FormValidator->language_lk(),
											);
							$mu_block = $SqlContent->goInsert('mu_table_translate',$data_insert_block_mtt);
							$last_Insert_id		= $SqlContent->lastInsertsId();

								
//var_dump($FormValidator->position());
							//mu_info_mtt		
							$data_insert_info_mtt = array(		
												"mu_table_translate"	=> $last_Insert_id,												
												"type_content"			=> $this->request->getPost('type_content'),		
												"type_position"			=> $FormValidator->position(),
												"type_face"				=> $this->request->getPost('type_face'),															
												"type_access"			=> "privacy",	
												"path"					=> $this->request->getPost('mu_ints'),										
																	
												"url"					=> "#",
												"porydok"				=> 1,
												//"mu_status"				=> $FormValidator->status_chb_rb(),
												"mu_status"				=> 1,
											);
							$mu_block = $SqlContent->goInsert('mu_info_mtt',$data_insert_info_mtt);
							
							$last_Insert_id		= $SqlContent->lastInsertsId();

							


							//mu_log_imtt	
							$data_insert_log_imtt = array(
								
								"mu_table_using"	=> '5',
								"id_data_using"		=> $last_Insert_id,														
								"mu_users" 			=> $this->storageUser['id'],
								"date" 				=> date("Y-m-d H:i:s"),
								"action"			=> 'create',
								"ip"				=> $FormValidator->ip(),
								
							);
							$mu_block = $SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt);

				

							

							echo json_encode($block_path);
							exit;
								break;

				case 'center_punct':

							$data_insert_punct = array(
												"url_title"			=> $this->request->getPost('mu_url_title'),
												"url"				=> $FormValidator->url(),
												"parents_punct"		=> (int)$this->request->getPost('mu_parents'),
												"mu_block" 			=> (int)$this->request->getPost('mu_block'),			
												"punct"				=> $this->request->getPost('mu_name'),																		
												"type_face"			=> "front",
												"permission"		=> "2",
												"mu_status"			=> $FormValidator->status_chb_rb(),
												"porydok"			=> "1",
												"level_deep"		=> "1",
												"mu_file_user"		=> "1",
												"mu_language"		=> $FormValidator->language_lk(),
												"mu_author_create" 	=> $this->storageUser['id'],	
												"data_create" 		=> date("Y-m-d H:i:s"),
											);



							$mu_punct = $SqlContent->goInsert('mu_block_punct',$data_insert_punct);
				

							$json_data = array ('id'=>2,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;
								break;

				case 'folder':

							$data_insert_folder = array(
												"url_title"			=> $this->request->getPost('mu_url_title'),
												"url"				=> "folder",
												"parents_punct"		=> (int)$this->request->getPost('mu_parents'),
												"mu_block" 			=> (int)$this->request->getPost('mu_block'),			
												"punct"				=> $this->request->getPost('mu_name'),																		
												"type_face"			=> "back",
												"permission"		=> "2",
												"mu_status"			=> "1",
												"porydok"			=> "1",
												"level_deep"		=> $this->request->getPost('level_deep')+1,	
												"mu_file_user"		=> "1",
												"mu_language"		=> $FormValidator->language_lk(),
												"mu_author_create" 	=> $this->storageUser['id'],	
												"data_create" 		=> date("Y-m-d H:i:s"),
											);



							$mu_folder = $SqlContent->goInsert('mu_block_punct',$data_insert_folder);


							$last_Insert_id		= $SqlContent->lastInsertsId();



												//Поиск первого предка
										$query = "id,parents_punct FROM mu_block_punct";
										$test_find_punct = $SqlContent->goSelect($query);
										$par = $last_Insert_id;
										$parent_right =& $par;

										while($parent_right > 1){ 

											foreach ($test_find_punct as $key => $value) {	
												if($value['id'] == $par){
													$par = $value['parents_punct'];	
													$par1 = $value['id'];												
												}
											}
										}


										$data_content_user = array(
													"mu_right"	=> $par1,
													"id_data"	=> $last_Insert_id,										
													"data"		=> 'folder',
												);
													
										//var_dump($data_insert_page);
										$mu_content_user = $SqlContent->goInsert('mu_content_user',$data_content_user);





				

							$json_data = array ('id'=>2,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;
					
				case 'page':					

							//mrd	
							$path_url	= $SqlContent->getPathUrl($this->request->getPost('mrd'),$FormValidator->language_lk());
							if(count($path_url) > 1){
								foreach ($path_url as $key => $value) {
									if($value['path'] != $value['id_mtt']){
										$path.=$value['path'].'/'.$value['id_mtt'].'|';
									}else{
										$path.=$value['path'].'|';
									}
								}		


								$block_path = $SqlContent->getUrlBFId('page',trim($this->request->getPost('mu_url_title')),$path);
							}else{
								if ($path_url[0]['id_mtt'] != $path_url[0]['path'] ) {
									$path = $path_url[0]['path'].'/'.$path_url[0]['id_mtt'];
								}else{
									$path = $path_url[0]['path'];
								}
								$block_path = $SqlContent->getUrlBFId('page',trim($this->request->getPost('mu_url_title')),$path);
							}

							
							if(empty($block_path[0]['mrd_id'])){
								$data_insert_block_mrd = array(
											"mu_reference_catalog"	=>	"1",
											"data"					=> $this->request->getPost('mu_url_title'),
										);
								$mu_block = $SqlContent->goInsert('mu_reference_data',$data_insert_block_mrd);
								$last_Insert_id		= $SqlContent->lastInsertsId();
							}else{
								$last_Insert_id	= $block_path[0]['mrd_id'];
							}	





							//mu_page
							$data_page = array(
										"preview"			=> $this->request->getPost('mu_preview'),	
										"title"				=> $this->request->getPost('mu_title'),	
										"content" 			=> $this->request->getPost('editor2'),	
										"status_published" 	=> 2,
									);							
										
										//var_dump($data_insert_page);
							$mu_content_check = $SqlContent->goInsert('mu_page',$data_page);				

							$last_id_page		= $SqlContent->lastInsertsId();




							//mu_table_taranslate		
							$data_insert_block_mtt = array(
												"mu_table_using"	=> "4",													
												"id_data_using"		=> $last_Insert_id,	
												"data"				=> $this->request->getPost('mu_title'),
												"short_data"		=> $this->request->getPost('mu_title'),
												"mu_language"		=> $FormValidator->language_lk(),
											);
							$mu_block = $SqlContent->goInsert('mu_table_translate',$data_insert_block_mtt);
							$last_Insert_id	 = $SqlContent->lastInsertsId();

								

							//mu_info_mtt		
							$data_insert_info_mtt = array(		
												"mu_table_translate"	=> $last_Insert_id,	
												"type_content"			=> $this->request->getPost('type_content'),		
												"type_position"			=> $FormValidator->position(),
												"type_face"				=> $this->request->getPost('type_face'),																									
												"type_access"			=> "root_all",	
												"path"					=> $this->request->getPost('mu_ints'),	
												"url"					=> $last_id_page,
												"porydok"				=> 1,
												"mu_status"				=> 1,
											);
							$mu_block = $SqlContent->goInsert('mu_info_mtt',$data_insert_info_mtt);
							
							$last_Insert_id		= $SqlContent->lastInsertsId();

							


							//mu_log_imtt	
							$data_insert_log_imtt = array(
												
												"mu_table_using"	=> '9',
												"id_data_using"		=> $last_Insert_id,														
												"mu_users" 			=> $this->storageUser['id'],
												"date" 				=> date("Y-m-d H:i:s"),
												"action"			=> 'create',
												"ip"				=> $FormValidator->ip(),
												
											);
							$mu_block = $SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt);













						//	$json_data = array ('id'=>4,'name'=>$data_insert_page,'con'=>$FormValidator->language_lk());

							echo json_encode($path_url);
							exit;
							break;
					
					
				default:
					
					break;
			}


			switch ($this->request->getPost('edit')) {
				case 'block':

							

							$id = $this->request->getPost('id');
							$query = "mu_block SET url_title= ?,block=?,mu_status=? WHERE id =?";
							$data_update = array(
												$this->request->getPost('mu_url_title'),														
												$this->request->getPost('mu_name'),												
												$FormValidator->status_chb_rb(),
												$id,
											);			
							$mu_block = $SqlContent->goUpdate($query,$data_update);
									
							//var_dump($data_update);
							$json_data = array ('id'=>4,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;






					break;
				case 'punct':
				
							$id = $this->request->getPost('id');
							$query = "mu_block_punct SET url_title= ?,url= ?,punct=?,mu_status=? WHERE id =?";
							$data_update = array(
												$this->request->getPost('mu_url_title'),
												$this->request->getPost('mu_url'),														
												$this->request->getPost('mu_name'),												
												$FormValidator->status_chb_rb(),
												$id,
											);			
							$mu_block = $SqlContent->goUpdate($query,$data_update);
									
							//var_dump($data_update);
							$json_data = array ('id'=>4,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;




					break;
				case 'center_punct':
				
							$id = $this->request->getPost('id');
							$query = "mu_block_punct SET url_title= ?,punct=?,mu_status=? WHERE id =?";
							$data_update = array(
												$this->request->getPost('mu_url_title'),														
												$this->request->getPost('mu_name'),												
												$FormValidator->status_chb_rb(),
												$id,
											);			
							$mu_block = $SqlContent->goUpdate($query,$data_update);
									
							//var_dump($data_update);
							$json_data = array ('id'=>4,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;




					break;

				case 'page':
					/*
							$new_content = $this->request->getPost('editor2');

							$id = $this->request->getPost('id');
							$query = "mu_content SET content= ?,title=?,preview=? WHERE id =?";
							$data_update = array(
												$new_content,
												$this->request->getPost('mu_title'),
												$this->request->getPost('mu_preview'),										
												$FormValidator->ints(),
												
											);			
							$content = $SqlContent->goUpdate($query,$data_update);
									

							$json_data = array ('id'=>4,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;
						*/
							//Редактировать через проверку
									//$data_select 	= array($FormValidator->ints());

									$query = "	id,mu_status_check,mu_content FROM mu_content_info 
												WHERE 
												id = ? ";
												// where f.date = (select max(date) from foo)
									$id_data = $SqlContent->checkDate($query,$FormValidator->ints());


									if ($id_data['mu_status_check'] != 1) {


										$new_content = $this->request->getPost('editor2');

										$id = $this->request->getPost('id');
										$query = "mu_content_info SET mu_status_check=?, content= ?, title=?, preview=?, mu_author_update=?, data_update=?  WHERE id =?";
										$data_update = array(
															3,
															$new_content,
															$this->request->getPost('mu_title'),
															$this->request->getPost('mu_preview'),										
															$this->storageUser['id'],
															date("Y-m-d H:i:s"),
															$id_data['id'],
															
														);			
										$content = $SqlContent->goUpdate($query,$data_update);
												

										$json_data = array ('id'=>4,'name'=>$id_data['mu_status_check'],'con'=>$FormValidator->language_lk());

										echo json_encode($json_data);
										exit;






										
									}
									

									if ($id_data['mu_status_check'] == 1) {




												$query = "mci.main_page,mci.call_url_value,mci.mu_language,mci.mu_block_punct,mci.mu_author_create,mci.mu_content	 FROM mu_content_info mci
												WHERE 
		                                             mci.mu_content =? and
		                                             mci.mu_status_check = 1 and		                                          
		                                             mci.data_update = (select max(t2.data_update) from mu_content_info t2 WHERE 
		                                             										t2.mu_content =? and
		                                                                                    t2.mu_status_check = 1 )";
												 $data_select = array($id_data['mu_content'],$id_data['mu_content']);
									$content_data = $SqlContent->checkDate($query,$data_select);


							$data_content_info = array(


										"main_page"			=> $content_data['main_page'],
										"call_url_value"	=> $content_data['call_url_value'],										
										"mu_language"		=> $content_data['mu_language'],					
										"mu_block_punct"	=> $content_data['mu_block_punct'],
										"mu_author_create" 	=> $content_data['mu_author_create'],
										"mu_content" 		=> $content_data['mu_content'],
										"mu_status_check"	=> 3,
										"preview"			=> $this->request->getPost('mu_preview'),	
										"title"				=> $this->request->getPost('mu_title'),	
										"content" 			=> $this->request->getPost('editor2'),
										"mu_author_update" 	=> $this->storageUser['id'],																			
										"data_update" 		=> date("Y-m-d H:i:s"),
										"mu_status_show" 	=> 1,





										
										
										
									);
										
										//var_dump($data_insert_page);
							$mu_content = $SqlContent->goInsert('mu_content_info',$data_content_info);
							



										
										$query = "mu_content_info SET mu_status_show=? WHERE id =?";
										$data_update = array(
															2,
															$id_data['id'],															
														);			
										$mu_content_info = $SqlContent->goUpdate($query,$data_update);


							$json_data = array ('id'=>4,'name'=>$data_content_info,'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;
						}

				case 'check_in_page':


							

					break;



				
				default:
					# code...
					break;
			}


			switch ($this->request->getPost('delet')) {
				case 'block':
							$id = $this->request->getPost('data_id');
							$query = "from mu_block WHERE id =?";
							$data_update = array(		

												$this->request->getPost('data_id'),											
												
											);			
							$sql_data = $SqlContent->goDelete($query,$data_update);
									

							$json_data = array ('id'=>4,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;
					
					break;
				case 'punct':
							$id = $this->request->getPost('data_id');
							$data_delete = array(	
										$this->request->getPost('data_id'),	
									);	


							$query = "id FROM mu_block_punct WHERE parents_punct =?";
							$check_parents = $SqlContent->goSelect($query,$data_delete);
							//Если является чимто предком то не удаляется по ну удалять все дети
							if($check_parents){
									break;
							}



							$query = "from mu_block_punct WHERE id =?";							
							$sql_data = $SqlContent->goDelete($query,$data_delete);
									

							$json_data = array ('id'=>4,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;
					
					break;
				case 'center_punct':
							
							$id = $this->request->getPost('data_id');
							$query = "from mu_block_punct WHERE id =?";
							$data_update = array(		

												$this->request->getPost('data_id'),											
												
											);			
							$sql_data = $SqlContent->goDelete($query,$data_update);
									

							$json_data = array ('id'=>4,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;
					break;
				case 'page':
									
									$id = $this->request->getPost('data_id');
							
									$query = "	mu_content,mu_status_check
													FROM mu_content_info 
													WHERE 
														id = ? ";												
									$id_data = $SqlContent->checkDate($query,$id);




									if ($id_data['mu_status_check'] == 1) {
										exit;
										$query = "from mu_content WHERE id =?";
										$data_delete = array(
																$id_data['mu_content'],
														);			
										$sql_data = $SqlContent->goDelete($query,$data_delete);





										$query = "mu_content_info SET mu_status_show=? WHERE id =?";
										$data_update = array(
															6,
															$id ,															
														);			
										$mu_content_info = $SqlContent->goUpdate($query,$data_update);


										$json_data = array ('id'=>4,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

										echo json_encode($json_data);
										exit;
									}

									if ($id_data['mu_status_check'] != 1) {


									$query = " mci.id,mci.mu_status_show FROM mu_content_info mci
                                            WHERE 
                                            mci.mu_content =? and
                                            mci.mu_status_check = 1 and
                                            mci.mu_status_show = 2 and
                                            mci.data_update = (select max(t2.data_update) from mu_content_info t2 WHERE 
                                            										t2.mu_content =? and
                                                                                    t2.mu_status_check = 1 and
                                           											 t2.mu_status_show = 2  ) ";

								
									 $data_select = array($id_data['mu_content'],$id_data['mu_content']);
									$recovery_data = $SqlContent->checkDate($query,$data_select);

										if ($recovery_data['mu_status_show'] == 2) {
											

										$query = "from mu_content_info WHERE id =?";
										$data_delete = array(
																$id,
														);			
										$sql_data = $SqlContent->goDelete($query,$data_delete);


										$query = "mu_content_info SET mu_status_show=? WHERE id =?";
										$data_update = array(
															1,
															$recovery_data['id'] ,															
														);			
										$mu_content_info = $SqlContent->goUpdate($query,$data_update);

											$json_data = array ('id'=>4,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;

										}


							if ($id_data['mu_content'] == '0') {
								
								$query = "from mu_content_info WHERE id =? and mu_content = 0";
										$data_delete = array(
																$id,
														);			
										$sql_data = $SqlContent->goDelete($query,$data_delete);

										$json_data = array ('id'=>4,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;

							}


									}	

					


						exit;
					break;
				case 'folder':
							$id = $this->request->getPost('data_id');							
							$data_delete = array(
												$this->request->getPost('data_id'),	
											);			

							$query = "id FROM mu_block_punct WHERE parents_punct =?";
							$check_parents = $SqlContent->goSelect($query,$data_delete);
							//Если является чимто предком то не удаляется по ну удалять все дети
							if($check_parents){
									break;
							}
							$query = "from mu_block_punct WHERE id =?";
							$sql_data = $SqlContent->goDelete($query,$data_delete);

							//Удаление заипси и принадлежности папки вместе с папкой
							$query = "from mu_content_user WHERE id_data =? and data = 'folder'";								
							$sql_data = $SqlContent->goDelete($query,$data_delete);
									

							$json_data = array ('id'=>4,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;
					
					break;
				default:
					# code...
					break;
			}







		/*

		if((int)is_numeric($this->request->getPost('insert1'))){
			$data_insert_page = array(


										"mu_language"		=> $_SESSION['lang_lk'],							
										"mu_block_punct"	=> $this->request->getPost('block_ints'),
										"main_page"			=> "",
										"call_url_value"	=> "",
										"preview"			=> "",
										"title"				=> $this->request->getPost('title'),
										"content" 			=> $this->request->getPost('editor1'),	
										"mu_author_create" 	=> $this->storageUser['id'],	
										"mu_status_show" 	=> 1,	
										"data_create" 		=> date("Y-m-d H:i:s"),
									);
										var_dump($data_insert_page);
										
					$mu_content = $SqlContent->goInsert('mu_content',$data_insert_page);


				if ($mu_content) {
					$this->goToUrl('http://udhtu.waterh.net/mychem/adminka-site-udhtu');
				}else{
					$this->goToUrl('http://udhtu.waterh.net/mychem/conference/registration/fuel');
				}
		}		


*/




			if($this->request->getPost('data_id_for_folder')){
				$punctForFolder = $SqlContent->getPunctForFolder($this->request->getPost('data_id_for_folder'),$FormValidator->language_lk());
				//var_dump($punctForFolder);
				echo json_encode($punctForFolder);
				exit;
			}

			
			if($this->request->getPost('subblock_path')){
				$subPunctMenu = $SqlContent->getSubBlockMenu($this->request->getPost('subblock_path'),$FormValidator->language_lk());
				//var_dump($subPunctMenu);
				echo json_encode($subPunctMenu);
				exit;
			}			
		

		}





















		
		$this->view->render('udhtu-block', array( 											
											'write_div' => $write_div,
											'delet_div' => $delet_div,
											'update_div' => $update_div,
											'content' => $content,
											'folder1111' => $folder1111,
											'method' => $method,
											'post' 	 => $contr,											
											'params_last_key' 	 => $params_last['key'],
											'user' 	 => $user,
											'confInfo' 	 => $confInfo,
										),'layout1');
	}









	public function confAction(){		
		$SqlContent = new SqlContent();
		$action = $this->getController();
		$method = $this->request->getMethod();
		$post  = $this->request->getPost();	
		$params = $this->getParams();
		if ($method == "GET") {				
			if(!empty($params))	{
				foreach ($this->getParams() as $key => $value) {					
					$params[urldecode($key)]=urldecode($value);
					if($key == 'users'){
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













		$user = $_SESSION['storageUser'];
			if(!($this->request->getPost('id_section')))	{
			$confInfo = $SqlContent->getConfInfo($topicConf);
		}else{
			$topicConf_section = array(5,$this->request->getPost('id_section') );	
			$confInfo = $SqlContent->getConfInfoSort($topicConf_section);

			echo json_encode($confInfo)	;	
			exit;	
		}
		
		$topic_conf = $SqlContent->getTopicConf($topicConf);
		
			

			if($post['id_conf'] && ($post['mu_status_view'] || $post['mu_status_oplata'] || $post['conf_status_public']) ){			
				if (!empty($post['mu_status_view'])) {				
			//$id  = 1;										
			$query = "mu_conf SET mu_status_view=? WHERE id=?";
			$data_update_conf = array($post['mu_status_view'],$post['id_conf']);						
			$done = $SqlContent->goUpdate($query,$data_update_conf);
			//echo $post['testtext']; 

		}

						if (!empty($post['mu_status_oplata'])) {				
			//$id  = 1;										
			$query = "mu_conf SET mu_status_oplata=? WHERE id=?";
			$data_update_conf = array($post['mu_status_oplata'],$post['id_conf']);						
			$done = $SqlContent->goUpdate($query,$data_update_conf);
			//echo $post['testtext']; 

		}


								if(!empty($post['conf_status_public'])) {				
			//$id  = 1;										
			$query = "mu_conf SET mu_status=? WHERE id=?";
			$data_update_conf = array($post['conf_status_public'],$post['id_conf']);						
			$done = $SqlContent->goUpdate($query,$data_update_conf);
			echo $post['conf_status_public'];

		}


	}



	if($post['generator'] == "gogo"){
		$query = "users.id";
		if ($_POST['name'] == 1) {
			$query =$query.",users.name";
		}
		if ($_POST['section'] == 1) {
			$query =$query.",topic.section_number";
		}
		if ($_POST['last_name'] == 1) {
			$query = $query.",users.last_name";
		}
		if ($_POST['middle_name'] == 1) {
			$query = $query.",users.middle_name";
		}	
		if ($_POST['mail'] == 1) {
			$query = $query.",users.mail";
		}
		if ($_POST['title_public'] == 1) {
			$query = $query.",conf.title_public";
		}
		if ($_POST['mu_type_presentation'] == 1) {
			$query = $query.",conf.mu_type_presentation";
		}	
		if ($_POST['mu_status_oplata'] == 1) {
			$query = $query.",conf.mu_status_oplata";
		}
		if ($_POST['mu_status'] == 1) {
			$query = $query.",status.status";
		}	
		if ($_POST['mob_phone'] == 1) {
			$query = $query.",info.mob_phone";
		}	
		if ($_POST['organization'] == 1) {
			$query = $query.",work.organization";
		}
		if ($_POST['buy_book'] == 1) {
			$query = $query.",conf.buy_book";
		}
		if ($_POST['hotel'] == 1) {
			$query = $query.",conf.hotel";
		}
		if ($_POST['skype'] == 1) {
			$query = $query.",info.skype";
		}



		

		if ((int)$this->request->getPost('gen_status_user') != 0) {
				//$status_user = array((int)$this->request->getPost('gen_status_user'));	
				$qwery_where = 'and conf.mu_status = ?';	

			if ((int)$this->request->getPost('gen_conf') != 0) {
				$topicConf = array((int)$this->request->getPost('gen_status_user'),(int)$this->request->getPost('gen_conf'));	
				$qwery_where = $qwery_where. ' and conf.mu_conf_type = ?';	

			if ((int)$this->request->getPost('gen_topic') != 0) {
				$topicConf = array((int)$this->request->getPost('gen_status_user'),(int)$this->request->getPost('gen_conf'),(int)$this->request->getPost('gen_topic'));	

				$qwery_where = $qwery_where.' and mu_topic_conf = ?';			
			}
			}else{			
				$qwery_where = 5;
			}


		}else{



			if ((int)$this->request->getPost('gen_conf') != 0) {
				$topicConf = array((int)$this->request->getPost('gen_conf'));	
				$qwery_where = $qwery_where. ' and conf.mu_conf_type = ?';	

			if ((int)$this->request->getPost('gen_topic') != 0) {
				$topicConf = array((int)$this->request->getPost('gen_conf'),(int)$this->request->getPost('gen_topic'));	

				$qwery_where = $qwery_where.' and mu_topic_conf = ?';			
			}
			}else{			
				$qwery_where = 5;
			}




		}


	if ($_POST['mu_status_view'] == 1) {
	array_push($topicConf,(int)$this->request->getPost('mu_status_view'));		
			//$topicConf = $topicConf.array((int)$this->request->getPost('mu_status_view'));
	//var_dump($topicConf);
				$qwery_where = $qwery_where.' and conf.mu_status_view = ?';		
		}



		
		
	//var_dump((int)$this->request->getPost('gen_status_user'));

		
		$gen_info = $SqlContent->getGenInfo($query,$topicConf,$qwery_where);
				//$gen_info =$query;






	} 


		if($this->request->getPost('gen_type_conf')){	
			$data_select = (int)$this->request->getPost('gen_type_conf');
			$gen_section = $SqlContent->getTopicConf($data_select);
			//echo $post['testtext']; 
			
			echo json_encode($gen_section);	
			exit;	

		}



		
//var_dump($post);
		//echo $post['testtext']; 

		// $this->goToUrl('http://udhtu.waterh.net/mychem/conf/users/fuel');

		
		$this->view->render('conf', array( 'action' => $action,
											'method' => $method,
											'post1' 	 => $post1,
											'user' 	 => $user,
											'confInfo' 	 => $confInfo,
											'params' 	 => $params,
											'topic_conf' 	 => $topic_conf,
											'gen_info' 	 => $gen_info,
											'conf_email' 	 => $conf_email,
											
										));




	}	

	public function udhtu_folderAction(){		
		$SqlContent = new SqlContent();
			$FormValidator = new FormValidator($this->request->getPost(),$_FILES);
		$params_all = $this->getParams();		
		$action = $this->getAction();
		$method = $this->request->getMethod();
		$contr  = $this->request->getPost();				
		$user = $_SESSION['storageUser'];
		unset($_SESSION['l_menu']);
		$UserPermission = $this->getUserPermission();
		//var_dump($UserPermission["privilege"]);

	//ini_set("display_errors",2);



$_SESSION['fm_kf_108'] = array(
    'disabled' => false
);


		if ($method == "GET") {	
			list($url_part, $qs_part) = array_pad(explode("?", $_SERVER['REQUEST_URI']), 2, ""); // Разбиваем URL на 2 части: до знака ? и после
			//var_dump($url_part);	
			switch ($_GET['l']) {
				case 1:					
					$_SESSION['lang_lk'] = 1;
					//$leftMenuName = $SqlContent->getLeftMenuName(1);
					$this->goToUrl($url_part);	
					break;
				case 2:					
					$_SESSION['lang_lk'] = 2;
					//$leftMenuName = $SqlContent->getLeftMenuName(2);
					$this->goToUrl($url_part);	
					break;
				case 3:					
					$_SESSION['lang_lk'] = 3;
					//$leftMenuName = $SqlContent->getLeftMenuName(2);
					$this->goToUrl($url_part);	
					break;
				default:
					$_SESSION['lang_lk'] = ($_SESSION['lang_lk']) ? $_SESSION['lang_lk'] : 1;
					break;
			}


				//функция смены ключа масива
			function change_key($key,$new_key,&$arr,$rewrite=true){
    if(!array_key_exists($new_key,$arr) || $rewrite){
        $arr[$new_key]=$arr[$key];
        unset($arr[$key]);
        return true;
    }
        return false;
}
		



			$params_last =	each(array_reverse($params_all,TRUE));
			//var_dump($params_last['key']);
			$params_last['value'] = (($params_last['value'])=== "endo") ? $params_last['key'] : $params_last['value'];
			//$params_last['value'] = ((int)is_numeric($params_last['value'])) ? $params_last['value'] : $params_last['value'] = "";
				//var_dump($params_last['key']);
			//var_dump($params_last);
			


			// Получаем права которые лежат в UserPermission и начинаем фасовать
			$arr_user_data1 = $UserPermission['params'][$this->getAction()];

		if ($arr_user_data1['privilege']['delete'] == 'allow') {
				$delet_div = '<div id="trash" class="ui-widget-content ui-state-default"><h4 class="ui-widget-header"><span class="ui-icon ui-icon-trash">Урна</span> Урна</h4></div>';
			}
		if ($arr_user_data1['privilege']['update'] == 'allow') {
				$update_div = '<div id="edit_all" class="ui-widget-content ui-state-default"><h4 class="ui-widget-header"><span class="ui-icon ui-icon-pencil">Редактор</span> Редактор</h4>Для редактирования информации передяните нужній блок сюда или нажмите маркер карандаша</div>';
			}
		if ($arr_user_data1['privilege']['write'] == 'allow') {
				$write_div = '  <div id="catalog">	<div type_block="section" block="'.$params_last['key'].'" parent="'.$params_last['key'].'" style="cursor: pointer;margin-left: 270px;">Ссылка ВСЕМОГУЩАЯ!</div> </div>';
			}

			$arr_user_data = $arr_user_data1['punct'];
			$arr_user_block = $arr_user_data1['block'];


			$arr_block_id_user = array_keys($arr_user_block);
//var_dump($arr_block_id_user);





			if (key($arr_user_data) == 'all'){
				change_key('all',$params_last['key'],$arr_user_data);
			}
			
			



					for ($i=0; $i < count($arr_block_id_user) ; $i++) { 
						$qw = array_values($arr_user_block[$arr_block_id_user[$i]]);						
				for ($ii=0; $ii < count($qw) ; $ii++) { 
					if ($userPunct) {
						$userPunct = $userPunct.',' ;
					}
					$userPunct = $userPunct.$qw[$ii] ;
					//$userPunct = ($ii ==  count($qw)-1) ? $userPunct : $userPunct.',' ;
				}



				


					$userBlock = $userBlock.$arr_block_id_user[$i] ;
					$userBlock = ($i ==  count($arr_block_id_user)-1) ? $userBlock : $userBlock.',' ;
				}
				$_SESSION['block'] = $userBlock;
				$_SESSION['punct'] = $userPunct;
				//var_dump($userPunct);
				//var_dump(array_values($arr_user_block[54]));
		
			//$leftMenuName = $SqlContent->getLeftMenuName($_SESSION['lang_lk']);
			
			if(!empty($params_all))	{  //Порверка на присутствие парамитров с url
				//print_r($params_all);

				//Получаем  по первому параметру урл(єто блок) его path
				$block_path = $SqlContent->getUrlBF($_SESSION['lang_lk'],key($params_all));	
				//Получаем все дерево по текушему path блокa
				//print_r($block_path);
				$tree_path = $SqlContent->getTreeContent($_SESSION['lang_lk'],$block_path[0]['path']);
				
					//print_r($tree_path);				
					//$path_d = $block_path[0]['path'];
					$center_punct_data['path_full'] = $block_path[0]['path'];
					//echo $path_d;
					$firs_key = each($params_all);
					$end_key = end($params_all);
					//print_r($end_key);
					// Пишем в сессию переменніе для разкрітия активного пункта меню при переходе на него по ссілке
					$_SESSION['active_block'] = $firs_key['key'];
					$_SESSION['active_subblock'] = $params_all[$firs_key['key']];
				//Перебор и сверка текушего урл с имеюшимися в базе урл_титлами и поиска страниці по принціпу  зная первородца (єто первый параметр урл) 
				//потом проверяем второй параметр на наличия родителя котором должен быть первый и так далее
			foreach ($params_all as $key => $value) {
						
					$center_punct_data['href'] = ($value !=  'endo') ? $center_punct_data['href'].'/'.$key.'/'.$value : $center_punct_data['href'].'/'.$key ;
					$center_punct_data['href_tree'] = ($value !=  'endo') ? $center_punct_data['href_tree'].'/'.$key.'/'.$value : $center_punct_data['href_tree'];
					//print_r($center_punct_data['href']);
					foreach ($tree_path as $key1 => $value1) {	
					//print_r($value1['url_title']."<br>");							
						if($value1['url_title'] == $key && $key != $firs_key['key'] && $center_punct_data['path_full'] == $value1['path'] ){
						//	print_r($value1['url_title']."<br>");	
							
							$center_punct_data['url'] 			= $value1['url'];						
							$center_punct_data['type_position'] = $value1['type_position'];
							$center_punct_data['path_full']		= $value1['path'].'/'.$value1['id_mtt']; // путь центр пункта дерева, но уже с добавленной к нему страницей(полный текуший путь)
							$center_punct_data['path_tree']		= $value1['path']; //путь центр пункта дерева, по нему получаем корневую папку и все что вней лежит с позицией центр							
							
							//echo  $path_d;
						}
						if($value1['url_title'] == $value && $value !=  'endo' && $value1['path'] == $center_punct_data['path_full']  ){
							//print_r($value1['url_title']."<br>");	
							if(empty($center_punct_data['name']))	
								$center_punct_data['name'] 			= $value1['name'];
							if(empty($center_punct_data['id_mtt_fak']))	{
								$center_punct_data['id_mtt_fak'] 			= $value1['id_mtt'];
								$center_punct_data['otdel'] = $value1['otdel'];
								$center_punct_data['short_name'] = $value1['short_name'];
							}
							$center_punct_data['url'] 			= $value1['url'];						
							$center_punct_data['type_position'] = $value1['type_position'];
							$center_punct_data['path_full']		= $value1['path'].'/'.$value1['id_mtt']; // путь центр пункта дерева, но уже с добавленной к нему страницей(полный текуший путь)
							$center_punct_data['path_tree']		= $value1['path']; //путь центр пункта дерева, по нему получаем корневую папку и все что вней лежит с позицией центр		
						}
					}					 
				}				
				//Формирование центрального блока меню 
				print_r($center_punct_data['path_full'].'--'.$center_punct_data['path_tree'].'---'.$center_punct_data['url'].'++++++'.$center_punct_data['type_position']);
				//$conten = $GetContent->getPageParams($center_punct_data['url']);	
				//print_r($conten);
				//----------------------------

			}else{

					if ($this->storageUser['role'] != 'budda') {
						$content_access = $SqlContent->getContentAccess($this->storageUser['id_rg']);
					}else{
						$content_access = $this->storageUser['role'];

					}
				//	print_r($this->storageUser);
					

					$udhtu_folder = $SqlContent->getBFMenu($_SESSION['lang_lk'],'block/subblock/folder/subfolder/page',$content_access);

				//header("Location: http://udhtu.waterh.net"); /* Redirect browser */
    			//var_dump($content);	
		
		$this->view->render('udhtu-folder', array( 											
											'write_div' => $write_div,
											'delet_div' => $delet_div,
											'update_div' => $update_div,
											'content' => $content,
											'udhtu_folder' => $udhtu_folder,
											'method' => $method,
											'post' 	 => $contr,											
											'params_last_key' 	 => $params_last['key'],
											'user' 	 => $user,
											'confInfo' 	 => $confInfo,
										),'layout1');

				
				exit();

			}
		
		

		}







if ($method == "POST" && $this->request->getPost('upd') == 1) { 

		//var_dump($FormValidator->upload_file());
	//var_dump($this->request->getPost());
		print json_encode($FormValidator->upload_file());
					 		 exit;

	}





	if ($method == "POST" && $this->request->getPost('crop') == 1) {

//var_dump($this->request->getPost());
	print json_encode($FormValidator->img_crop($this->request->getPost()));
					 		 exit;
}











		
		if (($method == "POST") ) {


			$FormValidator->upload_file();
			if($FormValidator->ints() && $this->request->getPost('epid')){
				
				$page_data		= $SqlContent->getPageData($FormValidator->ints());
				echo json_encode($page_data);
				exit;

			}




		if($UserPermission['privilege']['write'] == 'allow')
			switch($this->request->getPost('insert')){
				case 'block':

						$SqlContent->goTrans();
							try { 	

							//mrd
							$block_path = $SqlContent->getUrlBFId('BF',trim($this->request->getPost('mu_url_title')));

							
							if(empty($block_path[0]['mrd_id'])){
								$data_insert_block_mrd = array(
											"mu_reference_catalog"	=>	"1",
											"data"					=> $this->request->getPost('mu_url_title'),
										);
								//$mu_block = $SqlContent->goInsert('mu_reference_data',$data_insert_block_mrd);
								if(!$SqlContent->goInsert('mu_reference_data',$data_insert_block_mrd))									  
        							throw new Exception();
								$last_Insert_id		= $SqlContent->lastInsertsId();
							}else{
								$last_Insert_id	= $block_path[0]['mrd_id'];
							}			
						



							//mu_table_taranslate		
							$data_insert_block_mtt = array(
												"mu_table_using"	=> "4",													
												"id_data_using"		=> $last_Insert_id,	
												"data"				=> $this->request->getPost('mu_name'),
												"short_data"		=> $this->request->getPost('mu_name'),
												"mu_language"		=> $FormValidator->language_lk(),
											);
							//$mu_block = $SqlContent->goInsert('mu_table_translate',$data_insert_block_mtt);
							if(!$SqlContent->goInsert('mu_table_translate',$data_insert_block_mtt))									  
    							throw new Exception();
							$last_Insert_id		= $SqlContent->lastInsertsId();

								

							//mu_info_mtt		
							$data_insert_info_mtt = array(		
												"mu_table_translate"	=> $last_Insert_id,												
												"type_content"			=> "block",		
												"type_position"			=> $FormValidator->position(),	
												"type_face"				=> "front",															
												"type_access"			=> "privacy",	
												"path"					=> $last_Insert_id,									
																	
												"url"					=> "#",
												"porydok"				=> 1,
												"mu_status"				=> $FormValidator->status_chb_rb(),
											);
							//$mu_block = $SqlContent->goInsert('mu_info_mtt',$data_insert_info_mtt);
							if(!$SqlContent->goInsert('mu_info_mtt',$data_insert_info_mtt))									  
    							throw new Exception();

							
							$last_Insert_id		= $SqlContent->lastInsertsId();

							


							$data_insert_log_imtt = array(
								
								"mu_table_using"	=> '5',
								"id_data_using"		=> $last_Insert_id,														
								"mu_users" 			=> $this->storageUser['id'],
								"date" 				=> date("Y-m-d H:i:s"),
								"action"			=> 'create',
								"ip"				=> $FormValidator->ip(),
								
							);
						//	$mu_block = $SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt);
							if(!$SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt))									  
        							throw new Exception();

							$SqlContent->goCommit();
							} catch (Exception $e) {
								$SqlContent->goRoll();								 
									
							}

							$json_data = array ('id'=>1,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;




					
				case 'punct':

						$SqlContent->goTrans();
							try { 	
						//mrd	
							$path_url	= $SqlContent->getPathUrl($this->request->getPost('mrd'),$FormValidator->language_lk());
							if(count($path_url) > 1){
								foreach ($path_url as $key => $value) {
									if($value['path'] != $value['id_mtt']){
										$path.=$value['path'].'/'.$value['id_mtt'].'|';
									}else{
										$path.=$value['path'].'|';
									}
								}

		


								$block_path = $SqlContent->getUrlBFId('subBF',trim($this->request->getPost('mu_url_title')),$path);
							}else{
								if ($path_url[0]['id_mtt'] != $path_url[0]['path'] ) {
									$path = $path_url[0]['path'].'/'.$path_url[0]['id_mtt'];
								}else{
									$path = $path_url[0]['path'];
								}

								$block_path = $SqlContent->getUrlBFId('subBF',trim($this->request->getPost('mu_url_title')),$path);
							}


							if(empty($block_path[0]['mrd_id'])){
								$data_insert_block_mrd = array(
											"mu_reference_catalog"	=>	"1",
											"data"					=> $this->request->getPost('mu_url_title'),
										);
								//$mu_block = $SqlContent->goInsert('mu_reference_data',$data_insert_block_mrd);
								if(!$SqlContent->goInsert('mu_reference_data',$data_insert_block_mrd))									  
        							throw new Exception();

								$last_Insert_id		= $SqlContent->lastInsertsId();
							}else{
								$last_Insert_id	= $block_path[0]['mrd_id'];
							}	


							//mu_table_taranslate		
							$data_insert_block_mtt = array(
												"mu_table_using"	=> "4",													
												"id_data_using"		=> $last_Insert_id,	
												"data"				=> $this->request->getPost('mu_name'),
												"short_data"		=> $this->request->getPost('mu_name'),
												"mu_language"		=> $FormValidator->language_lk(),
											);
							//$mu_block = $SqlContent->goInsert('mu_table_translate',$data_insert_block_mtt);
							if(!$SqlContent->goInsert('mu_table_translate',$data_insert_block_mtt))									  
        							throw new Exception();

							$last_Insert_id		= $SqlContent->lastInsertsId();

								
//var_dump($FormValidator->position());
							//mu_info_mtt		
							$data_insert_info_mtt = array(		
												"mu_table_translate"	=> $last_Insert_id,												
												"type_content"			=> $this->request->getPost('type_content'),		
												"type_position"			=> $FormValidator->position(),
												"type_face"				=> $this->request->getPost('type_face'),															
												"type_access"			=> "privacy",	
												"path"					=> $this->request->getPost('mu_ints'),										
																	
												"url"					=> "#",
												"porydok"				=> 1,
												//"mu_status"				=> $FormValidator->status_chb_rb(),
												"mu_status"				=> 1,
											);
							//$mu_block = $SqlContent->goInsert('mu_info_mtt',$data_insert_info_mtt);
							if(!$SqlContent->goInsert('mu_info_mtt',$data_insert_info_mtt))									  
        							throw new Exception();
							
							$last_Insert_id		= $SqlContent->lastInsertsId();

							


							//mu_log_imtt	
							$data_insert_log_imtt = array(
								
								"mu_table_using"	=> '5',
								"id_data_using"		=> $last_Insert_id,														
								"mu_users" 			=> $this->storageUser['id'],
								"date" 				=> date("Y-m-d H:i:s"),
								"action"			=> 'create',
								"ip"				=> $FormValidator->ip(),
								
							);
							//$mu_block = $SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt);
							if(!$SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt))									  
        							throw new Exception();

				
							$SqlContent->goCommit();
							} catch (Exception $e) {
								$SqlContent->goRoll();	
							}
							

							echo json_encode($json_data);
							exit;


								
				case 'page':


						$SqlContent->goTrans();
							try { 
							//mrd	
							$path_url	= $SqlContent->getPathUrl($this->request->getPost('mrd'),$FormValidator->language_lk());
							if(count($path_url) > 1){
								foreach ($path_url as $key => $value) {
									if($value['path'] != $value['id_mtt']){
										$path.=$value['path'].'/'.$value['id_mtt'].'|';
									}else{
										$path.=$value['path'].'|';
									}
								}		


								$block_path = $SqlContent->getUrlBFId('page',trim($this->request->getPost('mu_url_title')),$path);
							}else{
								if ($path_url[0]['id_mtt'] != $path_url[0]['path'] ) {
									$path = $path_url[0]['path'].'/'.$path_url[0]['id_mtt'];
								}else{
									$path = $path_url[0]['path'];
								}
								$block_path = $SqlContent->getUrlBFId('page',trim($this->request->getPost('mu_url_title')),$path);
							}

							
							if(empty($block_path[0]['mrd_id'])){
								$data_insert_block_mrd = array(
											"mu_reference_catalog"	=>	"1",
											"data"					=> $this->request->getPost('mu_url_title'),
										);
								//$mu_block = $SqlContent->goInsert('mu_reference_data',$data_insert_block_mrd);
								if(!$SqlContent->goInsert('mu_reference_data',$data_insert_block_mrd))									  
        							throw new Exception();

								$last_Insert_id		= $SqlContent->lastInsertsId();
							}else{
								$last_Insert_id	= $block_path[0]['mrd_id'];
							}	


							

							//mu_page
							$data_page = array(
										"preview"			=> $this->request->getPost('mu_preview'),	
										"title"				=> $this->request->getPost('mu_title'),	
										"content" 			=> $this->request->getPost('editor2'),	
										"status_published" 	=> 2,
									);					
										
							//$mu_content_check = $SqlContent->goInsert('mu_page',$data_page);		
							if(!$SqlContent->goInsert('mu_page',$data_page))									  
    							throw new Exception();		

							$last_id_page		= $SqlContent->lastInsertsId();
							


							//mu_table_taranslate		
							$data_insert_block_mtt = array(
												"mu_table_using"	=> "4",													
												"id_data_using"		=> $last_Insert_id,	
												"data"				=> $this->request->getPost('mu_title'),
												"short_data"		=> $this->request->getPost('mu_title'),
												"mu_language"		=> $FormValidator->language_lk(),
											);
							//$mu_block = $SqlContent->goInsert('mu_table_translate',$data_insert_block_mtt);
							if(!$SqlContent->goInsert('mu_table_translate',$data_insert_block_mtt))									  
    							throw new Exception();	

							$last_Insert_id	 = $SqlContent->lastInsertsId();

								

							//mu_info_mtt		
							$data_insert_info_mtt = array(		
												"mu_table_translate"	=> $last_Insert_id,	
												"type_content"			=> $this->request->getPost('type_content'),		
												"type_position"			=> $FormValidator->position(),
												"type_face"				=> $this->request->getPost('type_face'),																									
												"type_access"			=> "root_all",	
												"path"					=> $this->request->getPost('mu_ints'),	
												"url"					=> $last_id_page,
												"porydok"				=> 1,
												"mu_status"				=> 1,
											);
						//	$mu_block = $SqlContent->goInsert('mu_info_mtt',$data_insert_info_mtt);
							if(!$SqlContent->goInsert('mu_info_mtt',$data_insert_info_mtt))									  
    							throw new Exception();	
							
							$last_Insert_id		= $SqlContent->lastInsertsId();						


							//mu_log_imtt	
							$data_insert_log_imtt = array(
												
												"mu_table_using"	=> '9',
												"id_data_using"		=> $last_Insert_id,														
												"mu_users" 			=> $this->storageUser['id'],
												"date" 				=> date("Y-m-d H:i:s"),
												"action"			=> 'create',
												"ip"				=> $FormValidator->ip(),
												
											);
						//	$mu_block = $SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt);
							if(!$SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt))									  
    							throw new Exception();	


							$SqlContent->goCommit();
							} catch (Exception $e) {
								$SqlContent->goRoll();	
							}
							



							$json_data = array ('id'=>4,'name'=>$data_insert_page,'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;
							break;
					
					
				default:
					
					break;
			}

			if($UserPermission['privilege']['update'] == 'allow')
			switch ($this->request->getPost('edit')) {
				case 'block':

							$SqlContent->goTrans();
							try { 

								$id = $this->request->getPost('id');
								$query = "mu_block SET url_title= ?,block=?,mu_status=? WHERE id =?";
								$data_update = array(
													$this->request->getPost('mu_url_title'),														
													$this->request->getPost('mu_name'),												
													$FormValidator->status_chb_rb(),
													$id,
												);			
								//$mu_block = $SqlContent->goUpdate($query,$data_update);
								if(!$SqlContent->goUpdate($query,$data_update))									  
	    							throw new Exception();	
									
						
							$SqlContent->goCommit();
							} catch (Exception $e) {
								$SqlContent->goRoll();	
							}


							$json_data = array ('id'=>4,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;

					break;
				case 'punct':
							$SqlContent->goTrans();
							try { 
							
							$query = "mu_table_translate SET data= ?,short_data = ? WHERE id =?";
							$data_update = array(
												$this->request->getPost('fname'),
												$this->request->getPost('short_name'),														
												$this->request->getPost('mu_ints'),	
											);			
							//$mu_block = $SqlContent->goUpdate($query,$data_update);
							if(!$SqlContent->goUpdate($query,$data_update))									  
	    							throw new Exception();	


	    					$data_insert_log_imtt = array(								
								"mu_table_using"	=> '5',
								"id_data_using"		=> $FormValidator->ints(),														
								"mu_users" 			=> $this->storageUser['id'],
								"date" 				=> date("Y-m-d H:i:s"),
								"action"			=> 'edit',		
								"ip"				=> $FormValidator->ip(),						
							);							
							if(!$SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt))									  
        						throw new Exception();


							$SqlContent->goCommit();
							} catch (Exception $e) {
								$SqlContent->goRoll();	
							}
							$json_data = array ('id'=>4,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;




					break;				

				case 'page':

							if($this->storageUser['id'] == 1){

							$data_upd_page = array(
										$this->request->getPost('mu_title'),	
										$this->request->getPost('mu_preview'),										
										$this->request->getPost('editor2'),	
									//"status_published" 	=> 2,
										$FormValidator->ints(),
									);	
							$query = "mu_page SET title= ?,preview=?,content=? WHERE id =?";

							}else{

							$data_upd_page = array(
									//	$this->request->getPost('mu_title'),	
									//	$this->request->getPost('mu_preview'),										
										$this->request->getPost('editor2'),	
									//"status_published" 	=> 2,
										$FormValidator->ints(),
									);	
							$query = "mu_page SET content=? WHERE id =?";


							}			
							$SqlContent->goTrans();
							try { 		
							//mu_page							
							 $SqlContent->goUpdate($query,$data_upd_page);		
							if(!$SqlContent->goUpdate($query,$data_upd_page))									  
        						throw new Exception();

							//$last_id_page		= $SqlContent->lastInsertsId();
								
							
							


							//mu_log_imtt	
							$data_insert_log_imtt = array(								
								"mu_table_using"	=> '9',
								"id_data_using"		=> $FormValidator->ints(),														
								"mu_users" 			=> $this->storageUser['id'],
								"date" 				=> date("Y-m-d H:i:s"),
								"action"			=> 'edit',		
								"ip"				=> $FormValidator->ip(),						
							);							
							if(!$SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt))									  
        						throw new Exception();

        						//Запись в случае отсутсвия ошибок
						   $SqlContent->goCommit();
							} catch (Exception $e) {
								$SqlContent->goRoll();								 
									
							}

							$json_data = array ('id'=>4,'name'=>$data_content_info,'con'=>$FormValidator->language_lk());

							echo json_encode($json_data);
							exit;
						

				case 'check_in_page':


							

					break;



				
				default:
					# code...
					break;
			}

			if($UserPermission['privilege']['delete'] == 'allow')
			switch ($this->request->getPost('delet')) {
				

				case 'page':							
									$SqlContent->goTrans();
									try { 
									$id = $this->request->getPost('data_id');
									$path = $this->request->getPost('id_mtt');	
									$data_select = array(
															$path,
															$id,
													);									
							
									$query = "	imtt.id as id_imtt, mtt.id as id_mtt, mrd.id as id_mrd, imtt.url as id_page
													FROM mu_info_mtt as imtt
													LEFT JOIN mu_table_translate as mtt ON mtt.id = imtt.mu_table_translate 
													LEFT JOIN mu_reference_data  as mrd ON mrd.id= mtt.id_data_using
													WHERE 
													imtt.mu_table_translate = ?
													AND imtt.url =?
                                                    AND mtt.mu_table_using = 4 ";
                                    //id для удаления из imtt mtt mrd mu_page												
									$del_id = $SqlContent->checkDate($query,$data_select);

									$query = "from mu_page WHERE id =?";
									$data_delete = array(
															$del_id['id_page'],
													);			
									$sql_data = $SqlContent->goDelete($query,$data_delete);
									
								//	if(!$SqlContent->goDelete($query,$data_delete))									  
        							//	throw new Exception();


									$query = "from mu_info_mtt WHERE id =?";
									$data_delete = array(
															$del_id['id_imtt'],
													);			
									$sql_data = $SqlContent->goDelete($query,$data_delete);
									//if(!$SqlContent->goDelete($query,$data_delete))									  
        							//	throw new Exception();

									$query = "from mu_table_translate WHERE id =?";
									$data_delete = array(
															$del_id['id_mtt'],
													);			
									$sql_data = $SqlContent->goDelete($query,$data_delete);
									//if(!$SqlContent->goDelete($query,$data_delete))									  
        								//throw new Exception();

									$query = "from mu_reference_data WHERE id =?";
									$data_delete = array(
															$del_id['id_mrd'],
													);			
									$sql_data = $SqlContent->goDelete($query,$data_delete);
									//if(!$SqlContent->goDelete($query,$data_delete))									  
        							//	throw new Exception();



									//mu_log_imtt	
									$data_insert_log_imtt = array(
														
														"mu_table_using"	=> '9',
														"id_data_using"		=> $id,														
														"mu_users" 			=> $this->storageUser['id'],
														"date" 				=> date("Y-m-d H:i:s"),
														"action"			=> 'delete',
														"ip"				=> $FormValidator->ip(),			
														
													);
									$mu_block = $SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt);
									//if(!$SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt))									  
        							//	throw new Exception();

						    $SqlContent->goCommit();
							}catch (Exception $e) {
								$SqlContent->goRoll();								 
									
							}



									echo json_encode($del_id);
							exit;

					break;
				case 'folder':

					
					break;
					case 'subfolder':												
										
									$path = $this->request->getPost('path');	
									$data_select = array(
															$path,															
													);	
									$query = "id FROM mu_info_mtt WHERE path =?";
									$check_parents = $SqlContent->checkDate($query,$data_select);
								if($check_parents['id']){
										$json_data = array ('error'=>1,'name'=>$this->request->getPost('mu_name'),'con'=>$FormValidator->language_lk());	
										echo json_encode($json_data);
										exit;
									}

									$SqlContent->goTrans();
									try { 


									$id_mtt = $this->request->getPost('id_mtt');	
									$data_select = array(
															$id_mtt,															
													);	
									$query = "	 imtt.id as id_imtt, mtt.id as id_mtt, mrd.id as id_mrd, imtt.url as id_page
													FROM mu_info_mtt as imtt
													LEFT JOIN mu_table_translate as mtt ON mtt.id = imtt.mu_table_translate 
													LEFT JOIN mu_reference_data  as mrd ON mrd.id= mtt.id_data_using
													WHERE 
													imtt.mu_table_translate = ?
													AND imtt.url ='#'
                                                    AND mtt.mu_table_using = 4";
                                    //id для удаления из imtt mtt mrd mu_page												
									$del_id = $SqlContent->checkDate($query,$data_select);

									$query = "from mu_info_mtt WHERE id =?";
									$data_delete = array(
															$del_id['id_imtt'],
													);			
									$sql_data = $SqlContent->goDelete($query,$data_delete);
									//if(!$SqlContent->goDelete($query,$data_delete))									  
        								//throw new Exception();

									$query = "from mu_table_translate WHERE id =?";
									$data_delete = array(
															$del_id['id_mtt'],
													);			
									$sql_data = $SqlContent->goDelete($query,$data_delete);
									//if(!$SqlContent->goDelete($query,$data_delete))									  
        							//	throw new Exception();

									$query = "from mu_reference_data WHERE id =?";
									$data_delete = array(
															$del_id['id_mrd'],
													);			
									$sql_data = $SqlContent->goDelete($query,$data_delete);
									//if(!$SqlContent->goDelete($query,$data_delete))									  
        							//	throw new Exception();


									//mu_log_imtt	
									$data_insert_log_imtt = array(
														
														"mu_table_using"	=> '5',
														"id_data_using"		=> $del_id['id_imtt'],														
														"mu_users" 			=> $this->storageUser['id'],
														"date" 				=> date("Y-m-d H:i:s"),
														"action"			=> 'delete',
														"ip"				=> $FormValidator->ip(),			
														
													);
									$mu_block = $SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt);
									//if(!$SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt))									  
        							//	throw new Exception();

		 				    $SqlContent->goCommit();
							}catch (Exception $e) {
								$SqlContent->goRoll();								 
									
							}


							echo json_encode($sql_data);
							exit;
				
					break;
				default:
					# code...
					break;
			}





			if($this->request->getPost('data_id_for_folder')){
				$punctForFolder = $SqlContent->getPunctForFolder($this->request->getPost('data_id_for_folder'),$FormValidator->language_lk());
				//var_dump($punctForFolder);
				echo json_encode($punctForFolder);
				exit;
			}

			
			if($this->request->getPost('subblock_path')){
				$subPunctMenu = $SqlContent->getSubBlockMenu($this->request->getPost('subblock_path'),$FormValidator->language_lk());
				//var_dump($subPunctMenu);
				echo json_encode($subPunctMenu);
				exit;
			}	

			//Работа с папками получени вложеных пакок по путю 			
			if($this->request->getPost('path_folder')){


				if ($this->storageUser['role'] != 'budda') {
					$content_access = $SqlContent->getContentAccess($this->storageUser['id_rg']);
				}else{
					$content_access = $this->storageUser['role'];

				}

				$path_folder_tree = $SqlContent->getTreeContent($FormValidator->language_lk(),$this->request->getPost('path_folder'),$content_access);
				//var_dump($subPunctMenu);
				echo json_encode($path_folder_tree);
				exit;
			}	

						//Работа с папками получени вложеных пакок по путю 			
			if($this->request->getPost('user_click')){


			if ($this->storageUser['role'] != 'budda') {
					$path_folder_tree = false;
				}else{
					$path_folder_tree = true;

				}

				
				//var_dump($subPunctMenu);
				echo json_encode(array($path_folder_tree));
				exit;
			}

		

		}


	
		$this->view->render('udhtu-folder', array( 											
											'write_div' => $write_div,
											'delet_div' => $delet_div,
											'update_div' => $update_div,
											'content' => $content,
											'udhtu_folder' => $udhtu_folder,
											'method' => $method,
											'post' 	 => $contr,											
											'params_last_key' 	 => $params_last['key'],
											'user' 	 => $user,
											'confInfo' 	 => $confInfo,
										),'layout1');
	}




	

}