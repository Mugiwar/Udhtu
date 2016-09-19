<?php
namespace Front\Controller;

use OPF\Mvc\Controller\AbstractController;
use Front\Model\GetContent;
use OPF\Filter\Requests\FormValidator;

class NapryamController extends AbstractController
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
				//if($_SESSION['storageUser']['role'] == 'budda')					
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
						//var_dump($value1['path']);
					//print_r($value1['url_title']."<br>");							
						if($value1['url_title'] == $key && $key != $firs_key['key'] && $center_punct_data['path_full'] == $value1['path'] ){
						//	print_r($value1['url_title']."<br>");	
							
							$center_punct_data['url'] 			= $value1['url'];	
								$center_punct_data['porydok'] 			= $value1['porydok'];					
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
								$center_punct_data['porydok'] 			= $value1['porydok'];					
							$center_punct_data['type_position'] = $value1['type_position'];
							$center_punct_data['path_full']		= $value1['path'].'/'.$value1['id_mtt']; // путь центр пункта дерева, но уже с добавленной к нему страницей(полный текуший путь)
							$center_punct_data['path_tree']		= $value1['path']; //путь центр пункта дерева, по нему получаем корневую папку и все что вней лежит с позицией центр		
						}
					}					 
				}				
				//Формирование центрального блока меню 
				//print_r($center_punct_data['path_full'].'--'.$center_punct_data['path_tree'].'---'.$center_punct_data['url'].'++++++'.$center_punct_data['type_position']);
				if($center_punct_data['url'] != '#'){
					if($center_punct_data['type_position'] == 'left' || $center_punct_data['type_position'] == 'top'){					
						$menu_center =  '<div id="center-punct" class="pullDown active_c" style="min-height: 0px; display: block;"><div class="punct_menu_lvl_1 slideUp once_c_p active_c_p"><a class="active_c" href="'.$center_punct_data['href'].'">'.$center_punct_data['name'].'<img class="pulse" ></a></div></div>';
					}
					if($center_punct_data['type_position'] == 'center' ){						
						$find_path_tree = $center_punct_data['path_tree'];
						$center_punct =	$GetContent->getCenterPunct($find_path_tree,$_SESSION['lang']);
						$width_c_p = (950 - ((count($center_punct))*10))/count($center_punct); // Расчет ширини центральніх пунктов  делением ширині контейнера на колво ячеек
						$menu_center =  '<div id="center-punct" class="pullDown" style="min-height: 0px; display: block;">';
						foreach ($center_punct as $key => $value) {
							$active_c = ($value['url'] == $center_punct_data['url'] ) ? 'class="active_c"' : '';
							$menu_center =  $menu_center.'<div  class="punct_menu_lvl_1 slideUp "><a '.$active_c.' style="width:'.$width_c_p.'px" href="'.$center_punct_data['href_tree'].'/'.$value['url_title'].'">'.$value['name'].'<img class="pulse" ></a></div>';
						}
						$menu_center = $menu_center.'</div>';
						
					}
				}else{
					//при переходе по ссілке котороя ведет на  каталог со значение урл # перебрасуем его на 1 пункт находяшийся в самом коталоге
					$find_path_tree = $center_punct_data['path_full'];
					$center_punct =	$GetContent->getCenterPunct($find_path_tree,$_SESSION['lang']);
					$this->goToUrl($center_punct_data['href_tree'].'/'.$center_punct[0]['url_title']);
					exit;
				}
				
				//----------------------------


$contact = $GetContent->getContact($center_punct_data['id_mtt_fak'],6,$_SESSION['lang']);
			$FakKaf = $GetContent->getFakKaf($center_punct_data['id_mtt_fak'],5,'kaf',$_SESSION['lang']);
			//$FakSpec = $GetContent->getFakKaf($center_punct_data['id_mtt_fak'],5,'spec',$_SESSION['lang']);
			//$kaf_rel = $GetContent->getFakKaf($center_punct_data['otdel'],4,'all',$_SESSION['lang']);
			$last_osp = explode('/', $center_punct_data['path_tree']) ; // Последний в пути адресс

			$query = "mfr.id_fak_mrd, mttt.data AS otdel, mttt.id AS id_mtt, imtt.path
						FROM mu_fak_relation AS mfr
						LEFT JOIN mu_table_translate AS mtt ON mtt.id_data_using = mfr.id_data
						LEFT JOIN mu_table_translate AS mttt ON mttt.id_data_using = mfr.id_fak_mrd
						LEFT JOIN mu_info_mtt AS imtt ON imtt.mu_table_translate = mttt.id
						WHERE mtt.id =?
						AND mfr.type_mrd =  'kaf'
						AND mfr.mu_table_using =?
						AND mttt.mu_language =?";
			$data_select = array(end($last_osp),4,$_SESSION['lang']);
			$mfr_kaf = $GetContent->goSelect($query,$data_select);	



			$kaf_rel = $GetContent->getFakKaf($mfr_kaf[0]['id_fak_mrd'],4,'all',$_SESSION['lang']);			
			if($_SESSION['storageUser']['role'] == 'budda'){
				print_r($data_select);
			}
			

if(!empty($kaf_rel) && 	$center_punct_data['porydok'] == 1 && $center_punct_data['url'] != '#')	
	$ech = '<div class="fkns" style="margin-left:15px;"><div class="ns">';
else
	$ech = '<div class="fkns" style="margin-left:15px;" ><div class="ns">';	

	if(!empty($kaf_rel)){		
							
					$sh_specz = '';					
					foreach ($kaf_rel as $key_galuz => $val_galuz) {						
						if($val_galuz['type_data'] == 'galuz'  && $val_galuz['short_data'] == $center_punct_data['short_name']){	
							
							$ech .= '<p><b>Галузь знань:</b> '.$val_galuz['short_data'].' '.$val_galuz['data'].'</p>';	

							foreach ($kaf_rel as $key_spec => $val_spec) {								
								if($val_spec['type_data'] == 'spec')
									if ($val_galuz['path'].'/'.$val_galuz['mu_table_translate'] == $val_spec['path'] && array_search($val_spec['mu_table_translate'],$last_osp) ) {
										$ech .= '<p><b>Спеціальність:</b> '.$val_spec['short_data'].' '.$val_spec['data'].'</p>';									
										foreach ($kaf_rel as $key => $val_specz){
											if($val_specz['type_data'] == 'specz')
												if ($val_spec['path'].'/'.$val_spec['mu_table_translate'] == $val_specz['path']) {
													$ech .= '<p><b>Спеціалізація:</b> '.$val_specz['data'].'</p>';	
													foreach ($kaf_rel as $key_osp => $val_osp){				
														if($val_osp['type_data'] == 'osp')
															if ($val_specz['path'].'/'.$val_specz['mu_table_translate'] == $val_osp['path']) {
																$url_info_osp = '';
																$cnt_url = 0;
																$url_path = $GetContent->getMrdMttUrl($val_osp['path'].'/'.$val_osp['mu_table_translate']);
																$path_url = explode('/', $val_osp['path'].'/'.$val_osp['mu_table_translate']) ;
								

																$sh_specz = $val_spec['short_data'];
																
						




															}
													}	

												}							

										}

										
								}
							}		

						}

					}

				//if($sh_specz != '')
			//if($_SESSION['storageUser']['role'] == 'budda'){
			//	print_r($mfr_kaf);
			//}






				if($mfr_kaf) {
					foreach ($mfr_kaf as $key_mfr_kaf => $value_mfr_kaf){					
						//$url_kaf = '';	
						$MrdMttUrl = $GetContent->getMrdMttUrl($value_mfr_kaf['id_mtt'].'/'.$value_mfr_kaf['path']);						
						foreach ($MrdMttUrl as $key_url_kaf => $value_url_kaf) {
							$url_kaf .= '/'.$value_url_kaf['url'];							
						}	
						if($_SESSION['storageUser']['role'] == 'budda'){
							print_r($value_mfr_kaf['id_fak_mrd'].'/'.$value_mfr_kaf['id_mtt'].'/'.$value_mfr_kaf['path']);
						}							
					}
					$napr_kaf = '<b>Випускова кафедра:</b> <a href="'.$url_kaf.'">'.$value_mfr_kaf['otdel'].'</a>';		
				}









				$ech .= $napr_kaf;
				$ech .= '<p>Підготовка фахівців здійснюється за ступенем <b>бакалавра</b>, освітньо-кваліфікаційним рівнем <b>спеціаліста</b> та ступенем <b>магістра</b></p>';
				$content['fak_ns'] 	=	$ech.'</div></div><hr>';
			}












				//----------------------------
			$conten = $GetContent->getPageParams($center_punct_data['url']);	

			$content['text'] =$menu_center.$content['fak_ns'].'<div id="page_text">'.$conten[0]['content'].'</div>';
			//$content['name_fak'] 	=	'<center>Кафедра '.mb_strtolower($center_punct_data['name'], 'UTF-8').'</center>';
			//var_dump($content[0]['content']);	
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
							$center_punct_data['porydok'] 			= $value1['porydok'];
							$center_punct_data['url'] 			= $value1['url'];
							$center_punct_data['type_position'] = $value1['type_position'];
							$center_punct_data['path_full']		= $value1['path'].'/'.$value1['id_mtt']; // путь центр пункта дерева, но уже с добавленной к нему страницей(полный текуший путь)
							$center_punct_data['path_tree']		= $value1['path']; //путь центр пункта дерева, по нему получаем корневую папку и все что вней лежит с позицией центр							
							
							//echo  $path_d;
						}
						if($value1['url_title'] == $value && $value !=  'endo' && $value1['path'] == $center_punct_data['path_full']  ){
							$center_punct_data['name'] 			= $value1['name'];
							$center_punct_data['porydok'] 			= $value1['porydok'];
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
							$menu_center =  $menu_center.'<div  class="punct_menu_lvl_1 "><a style="width:'.$width_c_p.'px" href="'.$center_punct_data['href_tree'].'/'.$value['url_title'].'">'.$value['name'].'<img class="pulse" ></a></div>';
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


				$json_data = array ('menu_center'=>$menu_center,'content'=>$content,'cpd'=>$center_punct_data);		
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