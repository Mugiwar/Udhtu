<?php
namespace Front\Controller;

use OPF\Mvc\Controller\AbstractController;
use Front\Model\GetContent;
use OPF\Filter\Requests\FormValidator;

class OprosController extends AbstractController
{

public function indexAction(){
		$GetContent = new GetContent();
		$FormValidator = new FormValidator($this->request->getPost());
		$module = $this->getModule();
		$method = $this->request->getMethod();		
		$action = $this->getAction();
		$params_all = $this->getParams();
		list($url_part, $qs_part) = array_pad(explode("?", $_SERVER['REQUEST_URI']), 2, ""); // Разбиваем URL на 2 части: до знака ? и после
		//Кодировки язіков как в базе 1-укр 2-енг 3-рус
			$splitssss = explode('/',trim($request,'/'));


//ini_set("display_errors",2);

		if ($method == "GET") {				
			switch ($_GET['l']) {
					case 'ukr':					
					$_SESSION['lang'] = 1;
					//$leftMenuName = $GetContent->getLeftMenuName(1);
					$this->goToUrl($url_part);	
					break;
				case 'eng':					
					$_SESSION['lang'] = 2;
					//$leftMenuName = $GetContent->getLeftMenuName(2);
					$this->goToUrl($url_part);	
					break;
				case 'rus':					
					$_SESSION['lang'] = 3;
					//$leftMenuName = $GetContent->getLeftMenuName(2);
					$this->goToUrl($url_part);	
					break;
				default:
					$_SESSION['lang'] = ($_SESSION['lang']) ? $_SESSION['lang'] : 1;
					break;
			}			
			//$leftMenuName = $GetContent->getLeftMenuName($_SESSION['lang']);
			
			if(!empty($params_all))	{  //Порверка на присутствие парамитров с url
				//var_dump($url_part);

				//Получаем  по первому параметру урл(єто блок) его path
				$block_path = $GetContent->getUrlBF($_SESSION['lang'],key($params_all));	
				//Получаем все дерево по текушему path блокa
				$tree_path = $GetContent->getTreeContent($_SESSION['lang'],$block_path[0]['path']);
				
					//print_r($block_path[0]['path']);				
					//$path_d = $block_path[0]['path'];
					$center_punct_data['path_full'] = $block_path[0]['path'];
					//print_r($params_all);
					$firs_key = each($params_all);
					$end_key = end($params_all);
				
					
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
								$center_punct_data['id_mtt_fak'] 			= $value1['id_mrd'];
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
				
			//	print_r($center_punct_data['name'].'--'.$center_punct_data['id_mtt_fak'].'---'.$center_punct_data['url'].'++++++'.$center_punct_data['type_position']);		


			$contact = $GetContent->getContact($center_punct_data['id_mtt_fak'],6,$_SESSION['lang']);
		//	$FakKaf = $GetContent->getFakKaf($center_punct_data['id_mtt_fak'],4,'kaf',$_SESSION['lang']);
		//	$Fakosp = $GetContent->getFakKaf($center_punct_data['id_mtt_fak'],4,'osp',$_SESSION['lang']);
			$otdel =  $GetContent->getFakKaf($center_punct_data['id_mtt_fak'],4,'opros_cat',$_SESSION['lang']);
			$opross = $GetContent->getFakKaf($center_punct_data['url'],4,'opros_p',$_SESSION['lang']);
			foreach ($opross as $key => $value) {				
				$opros[]=$value['opros'];
				$fm .= '_'.$value['opros']; 
			}
			$opros_testq = $GetContent->getOprosq($opros);
			$opros_testa = $GetContent->getOprosa($opros);
//print_r($opross);

$opr = '';
$echo = '<form id="fm_opros" name=op'.$fm.'>';
foreach ($opros_testq as $keyq => $valueq) {	
		foreach ($opros_testa as $keya => $valuea) {		
			if($valueq['mu_opros_q'] == $valuea['mu_opros_q']){
				//print_r($valuea['label']);
				if($valueq['mu_opros_name'] != $opr){
					$echo .= '<p><b>'.$valueq['mu_opros_name'].'. '.$valueq['priview'].'</b></p>';  
					$opr = $valueq['mu_opros_name'];
				}
				switch ($valuea['label']) {
						case 'checkbox':
							$echo .= $valuea['open'].' id="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'" name="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'_'.$valueq['mu_opros_name'].'"'.$valuea['close'].$valueq['open'].' for="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'"'.$valueq['middle'].$valueq['data'].$valueq['close'];
							break;
						case 'text':
							$echo .=$valueq['open'].'id="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'_'.$valueq['mu_opros_name'].'"'.' for="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'"'.$valueq['middle'].$valueq['data'].$valueq['close']. $valuea['open'].' id="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'" name="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'_'.$valueq['mu_opros_name'].'"'.$valuea['close'];
							break;
						case 'div_ih':
							$echo .=$valueq['open'].$valueq['middle'].$valueq['data'].$valueq['close'];
							break;
						case 'select':						
							if($valueq['mu_opros_q'] == 59){
								$tree_path = $GetContent->getTreeContent($_SESSION['lang'],'143','one');
								$echo .= $valueq['open'].'id="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'_'.$valueq['mu_opros_name'].'"'.$valueq['middle'].$valueq['data'].$valueq['close'];
								$echo .=$valuea['open'].'name="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'_'.$valueq['mu_opros_name'].'"'.$valuea['middle'];
								foreach ($tree_path as $k_otdel => $v_otdel) {									
									if($v_otdel['id_mrd'] == 143)
										$echo .=$valuea['middle2'].' selected disabled'.$valuea['middle'].$v_otdel['short_name'];
									else
										$echo .=$valuea['middle2'].' value="'.$v_otdel['path'].'/'.$v_otdel['id_mtt'].'"'.$valuea['middle'].$v_otdel['short_name'];
								}	
								$echo .='<option value="244">Факультет</option><option value="272">Кафедри</option>';	
								$echo .=$valuea['close'];
								break;
							}
							$echo .=$valueq['open'].' for="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'"'.$valueq['middle'].$valueq['data'].$valueq['close']. $valuea['open'].' id="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'" name="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'_'.$valueq['mu_opros_name'].'"'.$valuea['close'];
							break;		
						case 'radio':
							if($valueq['mu_opros_q'] ==  $valuea['mu_opros_a']){
								$echo .= $valueq['open'].'id="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_name'].'"'.$valueq['middle'].$valueq['data'].$valueq['close'];
								break;
							}		
							$echo .= $valuea['open'].' id="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'"  value="'.$valuea['mu_opros_a'].'" name="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_name'].'"'.$valuea['close'].$valueq['open'].' for="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'"'.$valueq['middle'].$valuea['data'].$valueq['close'];
							break;
						case 'radiohr':
							if($valueq['mu_opros_q'] ==  $valuea['mu_opros_a']){
								$num += 1;
								if($num == 2)
									$echo .= '<div>'.$echo1.'</div>'.$echo2 ;								
								if($num == 1){
									$echo2 ='<p style="margin: 0;">'.$valueq['open'].'id="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_name'].'"'.$valueq['middle'].$valueq['data'].$valueq['close'];
								}else{
									$echo .='<p style="margin: 0;">'.$valueq['open'].'id="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_name'].'"'.$valueq['middle'].$valueq['data'].$valueq['close'];	
								}
								
								
								break;
							}	
							if($num == 1){
							$echo1 .= '<span class="radiohr_num">'.$valuea['data'].'</span>';
							
							$echo2 .= $valuea['open'].' id="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'" value="'.$valuea['mu_opros_a'].'" name="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_name'].'"'.$valuea['close'];
							}else{
								$echo .= $valuea['open'].' id="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_a'].'" value="'.$valuea['mu_opros_a'].'" name="'.$valuea['label'].'_'.$valuea['mu_opros_q'].'_'.$valuea['mu_opros_name'].'"'.$valuea['close'];
							}
							break;									
						default:
							# code...
							break;
					}	


			}	
		}
}

$echo .= '<input type="hidden" name="op_form" value="op'.$fm.'"></form><p><button class="btnLogin" id="op_btn_save">Надіслати</button></p>';



			$conten = $GetContent->getPageParams($center_punct_data['url']);
			//var_dump($center_punct_data['url']);
			$content['text'] 		= 	$conten[0]['content'];
			//название факультета из шапки
			$content['opros_all'] 	=	$echo;
			
			
					$this->view->render('index', array(
											'content' => $content,
											'contact' => $contact,
											'otdel_staff' => $otdel_staff,										
											'action' => $action,
											'method' => $method,
											)
							);
			}else{

					unset($_SESSION['active_block']);
					unset($_SESSION['active_subblock']);

				//header("Location: http://udhtu.waterh.net"); /* Redirect browser */
    			//var_dump($content);	
		$this->view->render('index', array(
											'content' => $content,												
											'module' => $module,
											'contr' => $contr,
											'action' => $action,
											'method' => $method,
											)
							);

				


			}
			exit();
		}



		if ($method == "POST" ) {	
			if($this->request->getPost('mu_ints')){
				$main_otdel = (string)trim(htmlspecialchars(strip_tags($this->request->getPost('mu_ints'))));		;
				if($main_otdel){					
					$tree_path = $GetContent->getTreeContent($_SESSION['lang'],$main_otdel,'#');
				}

				$json_data = array ($tree_path);		
				echo json_encode($json_data);
				exit();
			}


			// Аякс запрос при клике на каталог в левом меню , получает его содержимое для вывода в центральном блоке меню
			if($this->request->getPost('op_form')){
				$id_unique = md5(date("Y-m-d H:i:s").$this->request->getPost('op_form').mt_rand());
				$op_form = trim((htmlspecialchars(strip_tags(strtolower($this->request->getPost('op_form'))))));		
				$op_form = explode('_', $op_form);
				for ($i=1; $i < count($op_form) ; $i++) { 
					$data_select[] = $op_form[$i];
				}
				$opros_testa = $GetContent->getOprosa($data_select);
				foreach ($this->request->getPost() as $k_post1 => $v_post1) {					
					$parse_post1[1] = explode('_', $k_post1.'_'.$v_post1);	

					foreach ($opros_testa as $keya => $valuea) {		
						if($valuea['mu_opros_q'] == $parse_post1[1][1] ){

							switch ($parse_post1[1][0]) {
							case 'text':
								if($valuea['mu_opros_a'] == $parse_post1[1][2] && $valuea['mu_opros_name'] == $parse_post1[1][3]  ){						
										$data_insert[] = array(
														'mu_opros_name' => $valuea['mu_opros_name'],
														'mu_opros_q'	=> $valuea['mu_opros_q'],
														'mu_opros_a'	=> trim((htmlspecialchars(strip_tags(strtolower($parse_post1[1][4]))))),
														'id_unique'		=> $id_unique																
													); 


								}
								break;
							case 'select':
								if($valuea['mu_opros_a'] == $parse_post1[1][2] && $valuea['mu_opros_name'] == $parse_post1[1][3]  ){						
										$data_insert[] = array(
														'mu_opros_name' => $valuea['mu_opros_name'],
														'mu_opros_q'	=> $valuea['mu_opros_q'],
														'mu_opros_a'	=> trim((htmlspecialchars(strip_tags(strtolower($parse_post1[1][4]))))),
														'id_unique'		=> $id_unique																
													); 


								}
								break;
							case 'checkbox':
								if($valuea['mu_opros_a'] == $parse_post1[1][2] && $valuea['mu_opros_name'] == $parse_post1[1][3]  ){
									$data_insert[] = array(
														'mu_opros_name' => $valuea['mu_opros_name'],
														'mu_opros_q'	=> $valuea['mu_opros_q'],
														'mu_opros_a'	=> $valuea['mu_opros_a'],
														'id_unique'		=> $id_unique																
													); 

								}
								break;	
							case 'radio':
								if($valuea['mu_opros_a'] == $parse_post1[1][3] && $valuea['mu_opros_name'] == $parse_post1[1][2]  ){
									$data_insert[] = array(
														'mu_opros_name' => $valuea['mu_opros_name'],
														'mu_opros_q'	=> $valuea['mu_opros_q'],
														'mu_opros_a'	=> $valuea['mu_opros_a'],
														'id_unique'		=> $id_unique																
													); 


								}
								break;
							case 'radiohr':
								if($valuea['mu_opros_a'] == $parse_post1[1][3] && $valuea['mu_opros_name'] == $parse_post1[1][2]  ){
									$data_insert[] = array(
														'mu_opros_name' => $valuea['mu_opros_name'],
														'mu_opros_q'	=> $valuea['mu_opros_q'],
														'mu_opros_a'	=> $valuea['mu_opros_a'],
														'id_unique'		=> $id_unique																
													); 


								}
								break;

							default:
								# code...
								break;
						}



						}
					}
				}

				//var_dump($data_insert);
				$data_field = array('mu_opros_name','mu_opros_q','mu_opros_a','id_unique');
				$ins = $GetContent->goInsertArr("mu_opros_ua",$data_field,$data_insert);
				$json_data = array ('data_form'=>$this->request->getPost(),'content'=>$opros_testa,'errrr'=>$ins);		
				echo json_encode($json_data);
			//$content = $GetContent->getPageParams(3);
			//var_dump($params_all);	
				exit();
			}	








			// Аякс запрос при клике на каталог в левом меню , получает его содержимое для вывода в центральном блоке меню
			if($this->request->getPost('subblock_path')){
				$subBlockMenu = $GetContent->getSubBlockMenu($this->request->getPost('subblock_path'),$_SESSION['lang']);
					$content = $GetContent->getPageParams($subBlockMenu[0]['url']);	
					$content[0]['content'] = ($content[0]['content']) ? $content[0]['content'] : 'Coming soon';
					$json_data = array ('subBlockMenu'=>$subBlockMenu,'content'=>$content);		
				echo json_encode($json_data);
			//$content = $GetContent->getPageParams(3);
			//var_dump($params_all);	
				exit();
			}	

// Аякс запрос на данные по стрнице при клике на центральном меню с перепиской урлов не перегружаеяс черех хистори
			if($this->request->getPost('page_path')){			
$block_path = $GetContent->getUrlBF($_SESSION['lang'],key($params_all));	

				$tree_path = $GetContent->getTreeContent($_SESSION['lang'],$block_path[0]['path']);

					
					$center_punct_data['path_full'] = $block_path[0]['path'];
					//echo $path_d;
					$firs_key = each($params_all);
					$end_key = end($params_all);
					//print_r($end_key);


				foreach ($params_all as $key => $value) {
					$center_punct_data['href'] = ($value !=  'endo') ? $center_punct_data['href'].'/'.$key.'/'.$value : $center_punct_data['href'].'/'.$key ;
					$center_punct_data['href_tree'] = ($value !=  'endo') ? $center_punct_data['href_tree'].'/'.$key.'/'.$value : $center_punct_data['href_tree'];
					foreach ($tree_path as $key1 => $value1) {								
						if($value1['url_title'] == $key && $key != $firs_key['key'] && $center_punct_data['path_full'] == $value1['path'] ){
							$center_punct_data['name'] 			= $value1['name'];
							$center_punct_data['url'] 			= $value1['url'];
							$center_punct_data['type_position'] = $value1['type_position'];
							$center_punct_data['path_full']		= $value1['path'].'/'.$value1['id_mtt']; // путь центр пункта дерева, но уже с добавленной к нему страницей(полный текуший путь)
							$center_punct_data['path_tree']		= $value1['path']; //путь центр пункта дерева, по нему получаем корневую папку и все что вней лежит с позицией центр							
							
							//echo  $path_d;
						}
						if($value1['url_title'] == $value && $value !=  'endo' && $value1['path'] == $center_punct_data['path_full']  ){
							$center_punct_data['name'] 			= $value1['name'];
							$center_punct_data['url'] 			= $value1['url'];
							$center_punct_data['type_position'] = $value1['type_position'];
							$center_punct_data['path_full']		= $value1['path'].'/'.$value1['id_mtt']; // путь центр пункта дерева, но уже с добавленной к нему страницей(полный текуший путь)
							$center_punct_data['path_tree']		= $value1['path']; //путь центр пункта дерева, по нему получаем корневую папку и все что вней лежит с позицией центр		
						}
					}					 
				}	
				
				
				//print_r($center_punct_data['path_full'].'--'.$center_punct_data['path_tree'].'---'.$center_punct_data['url'].'++++++'.$center_punct_data['type_position']);
				if($center_punct_data['url'] != '#'){
					if($center_punct_data['type_position'] == 'left'){					
						$menu_center =  '<div id="center-punct" style="min-height: 0px; display: block;"><div class="punct_menu_lvl_1  once_c_p active_c_p"><a class="active_c"  href="'.$center_punct_data['href'].'">'.$center_punct_data['name'].'<img class="pulse" ></a></div></div>';
					}
					if($center_punct_data['type_position'] == 'center'){						
						$find_path_tree = $center_punct_data['path_tree'];
						$center_punct =	$GetContent->getCenterPunct($find_path_tree,$_SESSION['lang']);
						$width_c_p = (950 - ((count($center_punct))*10))/count($center_punct); // Расчет ширини центральніх пунктов  делением ширині контейнера на колво ячеек
						$menu_center =  '<div id="center-punct" class=" style="display: block;">';
						foreach ($center_punct as $key => $value) {
							//$active_c = ($key == 0) ? 'active_c' : '';
							$menu_center =  $menu_center.'<div  class="punct_menu_lvl_1 "><a style="width:'.$width_c_p.'" href="'.$center_punct_data['href_tree'].'/'.$value['url_title'].'">'.$value['name'].'<img class="pulse" ></a></div>';
						}
						$menu_center = $menu_center.'</div>';
						
					}
				}else{
					$find_path_tree = $center_punct_data['path_full'];
					$center_punct =	$GetContent->getCenterPunct($find_path_tree,$_SESSION['lang']);
					$this->goToUrl($center_punct_data['href_tree'].'/'.$center_punct[0]['url_title']);
					exit;
				}
				
				//print_r($center_punct);

		

			$content = $GetContent->getPageParams($center_punct_data['url']);			
			//$content[0]['content'] = $menu_center.$content[0]['content'];


				$json_data = array ('menu_center'=>$menu_center,'content'=>$content);		
				echo json_encode($json_data);
				exit();
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

//echo json_encode(array('name' => 'Andrew', 'nickname' => 'Aramis'));
	}


	



}