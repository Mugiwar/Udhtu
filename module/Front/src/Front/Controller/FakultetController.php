<?php
namespace Front\Controller;

use OPF\Mvc\Controller\AbstractController;
use Front\Model\GetContent;
use OPF\Filter\Requests\FormValidator;

class FakultetController extends AbstractController
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
					$lang_label = '';
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


			switch ($_SESSION['lang'] ) {
				case 1:
					$lang_label = array(	
									'kv' 	=> '<b>Випускові кафедри:</b>' ,
									'k'		=>	'<b>Загальноосвітні кафедри:</b>',
									'pod_god'	=> '<p style="text-indent:20px">Факультет готує фахівців за ступенем <b>бакалавра</b>, освітньо-кваліфікаційним рівнем <b>спеціаліста</b> та ступенем <b>магістра</b> за&nbspнаступними галузями знань:</p>',
									'osp'	=>'Освітня програма:',
									'osps'	=>'Освітні програми:',
									'galuz_znan'	=>'<b>Галузь знань:</b>',
									'spec'	=>'<b>Спеціальність:</b> ',
									'specz'	=>'<b>Спеціалізація:</b> '
								 );
					break;
				case 2:
				$lang_label = '';
					break;
				case 3:
				$lang_label = array(	
									'kv' 	=> '<b>Выпускающие кафедры:</b>' ,
									'k'		=> '<b>Общеобразовательные кафедры:</b>',
									'pod_god'	=> '<p style="text-indent:20px">Факультет готовит <b>бакалавров</b>, <b>специалистов</b> и <b>магистров</b> по следующим отраслям знаний:</p>',
									'osp'	=> 'Образовательная программа:',
									'osps'	=> 'Образовательные программы:',
									'galuz_znan'	=>'<b>Отрасль знаний:</b>',
									'spec'	=>'<b>Специальность:</b> ',
									'specz'	=>'<b>Специализация:</b> '
								 );			
					break;
				
				default:
					$lang_label = array(	
									'kv' 	=> '<b>Випускові кафедри:</b>' ,
									'k'		=>	'<b>Загальноосвітні кафедри:</b>',
									'pod_god'	=> '<p style="text-indent:20px">Факультет готує фахівців за ступенем <b>бакалавра</b>, освітньо-кваліфікаційним рівнем <b>спеціаліста</b> та ступенем <b>магістра</b> за&nbspнаступними галузями знань:</p>',
									'osp'	=>'Освітня програма:',
									'osps'	=>'Освітні програми:',
									'galuz_znan'	=>'<b>Галузь знань:</b>',
									'spec'	=>'<b>Спеціальність:</b> ',
									'specz'	=>'<b>Спеціалізація:</b> '
								 );
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
				
				//print_r($center_punct_data['name'].'--'.$center_punct_data['id_mtt_fak'].'---'.$center_punct_data['url'].'++++++'.$center_punct_data['type_position']);
				
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

			//if($_SESSION['storageUser']['role'] == 'budda'){
			//	print_r($center_punct_data);
			//}
			$contact = $GetContent->getContact($center_punct_data['id_mtt_fak'],6,$_SESSION['lang']);
		//	$FakKaf = $GetContent->getFakKaf($center_punct_data['id_mtt_fak'],4,'kaf',$_SESSION['lang']);
		//	$Fakosp = $GetContent->getFakKaf($center_punct_data['id_mtt_fak'],4,'osp',$_SESSION['lang']);
		//	$Fakspec = $GetContent->getFakKaf($center_punct_data['id_mtt_fak'],4,'spec',$_SESSION['lang']);
			$fak_rel = $GetContent->getFakKaf($center_punct_data['id_mtt_fak'],4,'all',$_SESSION['lang']);
//print_r($center_punct_data['id_mtt_fak']);
//получение выпускаюших кафедр и формирование текста к выводу	
			//if($_SESSION['storageUser']['role'] == 'budda'){
			//	print_r($fak_rel);
			//}
			if($fak_rel) {
				foreach ($fak_rel as $key => $value){
					if($value['type_data'] == 'kaf'){
						$url_kaf = '';	
						$MrdMttUrl = $GetContent->getMrdMttUrl($value['path'].'/'.$value['mu_table_translate']);	
						//if($_SESSION['storageUser']['role'] == 'budda'){
						//	print_r($value['path'].'/'.$value['mu_table_translate']);
						//}	
						foreach ($MrdMttUrl as $key_url_kaf => $value_url_kaf) {
							$url_kaf .= '/'.$value_url_kaf['url'];
						}											
						if($value['note'] == 'v'){								
							$cv+= 1;// количество   віпуск каф
							//$kv=$kv."<p>– ".mb_strtolower($value['kaf'], 'UTF-8')."(".$value['short_data'].")</p>";
							$kv=$kv."<p>– <a href='".$url_kaf."'>".mb_strtolower($value['data'], 'UTF-8')."</a></p>";
						}else{
							$c+= 1;// количество  не віпуск каф
							$k=$k."<p>– <a href='".$url_kaf."'>".mb_strtolower($value['data'], 'UTF-8')."</a></p>";
						}						
					}					
				}


			$content['fak_kaf']	=	$lang_label['kv'].$kv;
			if($c)
			$content['fak_kaf']	.= $lang_label['k'].$k;
		}
// поиск по мтт ид 
//$MrdMttUrl = $GetContent->getMrdMttUrl('245');

//получение напряма и спец и формирование текста к выводу
			if($fak_rel){		
		/*		foreach($Fakosp as $key => $value) {
					 $url_osp = '/';
					 $cnt_url= 0; //надо на предпоследнем урл дописівать osp для парі ключ\значение а то не пашит
					 $id_mtt = explode('/', $value['path']) ;	
				 	$napr = $GetContent->getMrdMttUrl(end($id_mtt));

				 	$url_s = $GetContent->getMrdMttUrl($value['path'].'/'.$value['mu_table_translate']);
				 	foreach ($url_s as $key => $value1) {
				 		$cnt_url++;
				 		if($cnt_url != 2 )
				 			$url_osp .= $value1['url'].'/'; 					 	
				 		else	
				 			$url_osp .= $value1['url'].'/osp/'; 					 	
				 	}					
				 	$ns_value[$value['path']] = array('name_napr' => $napr[0]['name'],
					 									  'url_osp'  => $url_osp	);
				}	
					//print_r($Fakgaluz);
					
*/
		


			


			
			//	print_r($url_info_osp);				
					$cnt_galuz = 0;			
					$sh_specz = '';
					$ech =$lang_label['pod_god'];
					foreach ($fak_rel as $key_galuz => $val_galuz) {						
						if($val_galuz['type_data'] == 'galuz'){
							if($cnt_galuz != 0 ){
								
								$indent = 'style="margin-top:15px"';
							}
							$cnt_galuz++;
							$ech .= '<p '.$indent.'>'.$lang_label['galuz_znan'].$val_galuz['short_data'].' '.$val_galuz['data'].'</p>';	
							foreach ($fak_rel as $key_spec => $val_spec) {
								if($val_spec['type_data'] == 'spec')
									if ($val_galuz['path'].'/'.$val_galuz['mu_table_translate'] == $val_spec['path']) {
										$ech .= '<p>'.$lang_label['spec'].$val_spec['short_data'].' '.$val_spec['data'].'</p>';									
										foreach ($fak_rel as $key => $val_specz){
											if($val_specz['type_data'] == 'specz')
												if ($val_spec['path'].'/'.$val_spec['mu_table_translate'] == $val_specz['path']) {
													$ech .= '<p>'.$lang_label['specz'].$val_specz['data'].'</p>';	
													foreach ($fak_rel as $key_osp => $val_osp){				
														if($val_osp['type_data'] == 'osp')
															if ($val_specz['path'].'/'.$val_specz['mu_table_translate'] == $val_osp['path']) {
																$url_info_osp = '';
																$cnt_url = 0;
																$url_path = $GetContent->getMrdMttUrl($val_osp['path'].'/'.$val_osp['mu_table_translate']);
																$path_url = explode('/', $val_osp['path'].'/'.$val_osp['mu_table_translate']) ;
																foreach ($path_url as $key_path => $value_path) {
																	foreach ($url_path as $key_url => $val_url) {
																		if($value_path == $val_url['id']){
																			$cnt_url = $cnt_url + 1 ;
																		
																			switch ($cnt_url) {
															 								case 2:
															 									$url_info_osp .= '/'.$val_url['url'].'/spec'; 
															 									break;															 							
															 								
															 								default:
															 									$url_info_osp .= '/'.$val_url['url'];		
															 									break;
													 						}			


																		}





																	}	
																}
																
																if($sh_specz != $val_spec['short_data']){	
																$ech_no_url = $ech_i = $ech;																	
																	$ech .= '<b><p>'.$lang_label['osp'].'</p></b><ul><a href='.$url_info_osp.'>'.$val_osp['data'].' ('.$val_osp['short_data'].')</a></ul>';
																	$ech_no_url .= '<b><p>'.$lang_label['osps'].'</p></b><ul>'.$val_osp['data'].'</ul>';
																	$ech_i .= '<b><p>'.$lang_label['osps'].'</p></b><ul><a href='.$url_info_osp.'>'.$val_osp['data'].' ('.$val_osp['short_data'].')</a></ul>';
																}else{
																	$ech_no_url  = $ech_i;
																	$ech =	$ech_i  .=	'<ul><a href='.$url_info_osp.'>'.$val_osp['data'].' ('.$val_osp['short_data'].')</a></ul>';		
																	$ech_no_url 	.=	'<ul>'.$val_osp['data'].'</ul>';																	
																}

																$sh_specz = $val_spec['short_data'];
																
													foreach ($fak_rel as $key_atosp => $val_atosp){				
														if($val_atosp['type_data'] == 'atosp')
															if ($val_osp['path'].'/'.$val_osp['mu_table_translate'] == $val_atosp['path']) {
																$url_info_osp = '';
																$cnt_url = 0;
																$url_path = $GetContent->getMrdMttUrl($val_atosp['path'].'/'.$val_atosp['mu_table_translate']);
																$path_url = explode('/', $val_atosp['path'].'/'.$val_atosp['mu_table_translate']) ;
																foreach ($path_url as $key_path => $value_path) {
																	foreach ($url_path as $key_url => $val_url) {
																		if($value_path == $val_url['id']){
																			$cnt_url = $cnt_url + 1 ;
													 				switch ($cnt_url) {
													 								case 2:
													 									$url_info_osp .= '/'.$val_url['url'].'/spec'; 
													 									break;
													 								case 3:
													 									$url_info_osp .= '/'.$val_url['url'].'/specz'; 
													 									break;
													 								
													 								default:
													 									$url_info_osp .= '/'.$val_url['url'];		
													 									break;
													 							}			


																			
																		}
																	}	
																}

															
																	$ech_no_url .= '<li><a href='.$url_info_osp.'>'.$val_atosp['data'].' ('.$val_atosp['short_data'].')</a></li>';
																	$ech = $ech_no_url;
																
															} 
													}	




															}
													}	

												}							

										}

										
								}
							}		

						}

					}
//print_r($ech);
/*
				foreach ($ns_value as $key => $val_nap)
					foreach ($Fakosp as $key1 => &$val_osp){				
						if ($key == $val_osp['path']) {
							$val_osp['naprym'] = $val_nap['name_napr'] ;
							$s[$val_nap['name_napr']].= "<p>– <a href='".$val_nap['url_osp']."'>".$val_osp['osp']."</a></p>";
						}
					}
				$fak_ns .="<hr><b>Спеціальності та спеціалізації:</b>";
				foreach ($s as $key => $value) {
					$fak_ns .= "<b><p>".$key.":</p></b>";
					$fak_ns .= $value;				
				}
				*/
				if($sh_specz != '')
				$content['fak_ns'] 	=	$ech;
			}

//Получение картинок и описание используемых в сладере сотрудников факултета		
			$otdel_staff = $GetContent->getStaff($center_punct_data['otdel'],8,$_SESSION['lang']);
			if ($otdel_staff)
				$otdel_staff['short_name'] = $center_punct_data['short_name'];

		
			


			$conten = $GetContent->getPageParams($center_punct_data['url']);
			//var_dump($center_punct_data['url']);
			$content['text'] 		= 	$conten[0]['content'];
			//название факультета из шапки
			$content['name_fak'] 	=	'<center>ФАКУЛЬТЕТ '.mb_strtoupper($center_punct_data['name'], 'UTF-8').'</center>';
			
			
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