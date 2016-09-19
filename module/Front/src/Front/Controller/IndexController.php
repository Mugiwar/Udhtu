<?php
namespace Front\Controller;
use OPF\Loader\PHPMailer;
use OPF\Mvc\Controller\AbstractController;
use Front\Model\GetContent;
use OPF\Filter\Requests\FormValidator;

class IndexController extends AbstractController
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


			//print_r($url_part);

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

					//print_r($params_all);
					$center_punct_data['path_full'] = $block_path[0]['path'];
					//echo $center_punct_data['path_full'];
					$firs_key = each($params_all);
					$end_key = end($params_all);
					//print_r($params_all[$firs_key['key']]);
					//print_r($tree_path);
					// Пишем в сессию переменніе для разкрітия активного пункта меню при переходе на него по ссілке
					$_SESSION['active_block'] = $firs_key['key'];
					$_SESSION['active_subblock'] = $params_all[$firs_key['key']];
				//Перебор и сверка текушего урл с имеюшимися в базе урл_титлами и поиска страниці по принціпу  зная первородца (єто первый параметр урл) 
				//потом проверяем второй параметр на наличия родителя котором должен быть первый и так далее
				foreach ($params_all as $key => $value) {
					$center_punct_data['href'] = ($value !=  'endo') ? $center_punct_data['href'].'/'.$key.'/'.$value : $center_punct_data['href'].'/'.$key ;
					$center_punct_data['href_tree'] = ($value !=  'endo') ? $center_punct_data['href_tree'].'/'.$key.'/'.$value : $center_punct_data['href_tree'];
					foreach ($tree_path as $key1 => $value1) {	
						//print_r($value1['url_title']."<br>");	
					//	print_r($center_punct_data['path_full'].'----'.$value1['path'].'<br>');							
						if($value1['url_title'] == $key && $value1['path'] != $value1['id_mtt'] && $center_punct_data['path_full'] == $value1['path'] ){
							$center_punct_data['name'] 			= $value1['name'];
							$center_punct_data['url'] 			= $value1['url'];
							$center_punct_data['type_position'] = $value1['type_position'];
							$center_punct_data['path_full']		= $value1['path'].'/'.$value1['id_mtt']; // путь центр пункта дерева, но уже с добавленной к нему страницей(полный текуший путь)
							$center_punct_data['path_tree']		= $value1['path']; //путь центр пункта дерева, по нему получаем корневую папку и все что вней лежит с позицией центр							
							
							//echo  $path_d;
						}
						//echo  $center_punct_data['path_full'].'</br>';
						if($value1['url_title'] == $value && $value !=  'endo' && $value1['path'] != $value1['id_mtt'] && $value1['path'] == $center_punct_data['path_full']  ){
							//print_r($value1['id_mtt']);
							$center_punct_data['name'] 			= $value1['name'];
							$center_punct_data['url'] 			= $value1['url'];
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
						$menu_center =  '<div id="center-punct" class="pullDown active_c" style="min-height: 0px; display: block;"><div class="punct_menu_lvl_1 slideUp once_c_p active_c_p"><a class="active_c" href="'.$center_punct_data['href'].'">'.$center_punct_data['name'].'</a></div></div>';
					}
					if($center_punct_data['type_position'] == 'center' ){						
						$find_path_tree = $center_punct_data['path_tree'];
						$check_news =	$GetContent->getCheckNews($center_punct_data['url']);
						//echo $check_news[0]['mu_page'];
						//Если єто новость то картинка новостой показуется с верху с права 
						if($check_news[0]['mu_page']){
							$news_arh_img = "<a href='/Novini/2015_/arhiv_novin'><img style='float:right;width:100px;' src='/public/userfiles/image/news_arh.jpg'></a>";
						}else{
							$news_arh_img = '';
						}
						$center_punct =	$GetContent->getCenterPunct($find_path_tree,$_SESSION['lang'],$check_news[0]['mu_page']);
						//$center_punct =	$GetContent->getCenterPunct($find_path_tree,$_SESSION['lang']);
						$width_c_p = (950 - ((count($center_punct))*10))/count($center_punct); // Расчет ширини центральніх пунктов  делением ширині контейнера на колво ячеек
						$menu_center =  '<div id="center-punct" class="pullDown" style="min-height: 0px; display: block;">';
						foreach ($center_punct as $key => $value) {
							$active_c = ($value['url'] == $center_punct_data['url'] ) ? 'class="active_c"' : '';
							$menu_center =  $menu_center.'<div  class="punct_menu_lvl_1 slideUp "><a '.$active_c.' style="width:'.$width_c_p.'px" href="'.$center_punct_data['href_tree'].'/'.$value['url_title'].'">'.$value['name'].'</a></div>';
						}
						$menu_center = $menu_center.'</div>'.$news_arh_img;
						
					}
				}else{
					//при переходе по ссілке котороя ведет на  каталог со значение урл # перебрасуем его на 1 пункт находяшийся в самом коталоге
					$find_path_tree = $center_punct_data['path_full'];
					$center_punct =	$GetContent->getCenterPunct($find_path_tree,$_SESSION['lang']);
					$this->goToUrl($center_punct_data['href_tree'].'/'.$center_punct[0]['url_title']);
					exit;
				}
				
				//print_r($center_punct_data['url']);



			$content = $GetContent->getPageParams($center_punct_data['url']);	
			if(!$content)	{
				$this->goToUrl('/');
				exit();	
			}
			$content[0]['content'] = $menu_center.'<div id="page_text">'.$content[0]['content'].'</div>';
		//	var_dump($content[0]['content']);	
					$this->view->render('index', array(
											'content' => $content,
											'contr' => $contr,
											'action' => $action,
											'method' => $method,
											)
							);
			}else{

						$_SESSION['active_block'] = '';
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



		if ($method == "POST" ){

if ($this->request->getPost('fsm_type')) {

	switch ($this->request->getPost('fsm_type')) {
				case 'pidgotovchi_kursi':

					$subject = 'Заявка підготовчі курси';
					$email = 'cdp_udhtu@ukr.net';


					if($FormValidator->fio() == 'error_fio'){
						$note = array('textNote' => 'Некоректно вказано ПІБ', 'color' => 'green', 'fontSize' => '16');
						echo json_encode($note);						
							exit();
					}
					if($FormValidator->tel() == 'error_mob_phone'){						
						$note = array('textNote' => 'Некоректно вказано телефон', 'color' => 'green', 'fontSize' => '16');
						echo json_encode($note);
							exit();
					}

					foreach ($this->request->getPost() as $key => $value) {							

						if ($value != 1 && $key != 'fsm_type') 
							$message.=$key.': '.$value.'<br>';

						if ($value == 1) {
							$message.=$key.': + <br>';
							$chek_activ = 1;
						}
					}	
					if ($chek_activ != 1) {							
						$note = array('textNote' => 'Не обрані курси', 'color' => 'green', 'fontSize' => '16');
						echo json_encode($note);
						exit();
					}
					$noteSend = 'Дякуємо!';
				break;

				case 'zadati_pitannya':

					$subject = 'Вопросы зрителей';
					$email = 'prk_udxtu@ukr.net';


					if($FormValidator->fio() == 'error_fio'){					
						$note = array('textNote' => 'Некоректно вказано ПІБ', 'color' => 'green', 'fontSize' => '16');
						echo json_encode($note);
						exit();
					}
					if($FormValidator->tel() == 'error_mob_phone'){						
						$note = array('textNote' => 'Некоректно вказано телефон', 'color' => 'green', 'fontSize' => '16');
						echo json_encode($note);
							exit();
					}
					if($FormValidator->check_mail() == 'error_mail'){						
						$note = array('textNote' => 'Некоректно вказан e-mail', 'color' => 'red', 'fontSize' => '16');
						echo json_encode($note);
							exit();
					}

					if($FormValidator->abstracts() == 'error_abstracts'){						
						$note = array('textNote' => 'Некоректне запитання', 'color' => 'red', 'fontSize' => '16');
						echo json_encode($note);
							exit();
					}

					foreach ($this->request->getPost() as $key => $value) {							

						if ( $key != 'fsm_type') 
							$message.=$key.': '.$value.'<br>';

						
					}	
					$noteSend = 'Дякуємо!';
				break;


				case 'urss':

					if($FormValidator->name() == 'error_name'){						
						$note = array('textNote' => 'Некоректно вказано Ім\'я', 'color' => 'red', 'fontSize' => '16');
						echo json_encode($note);
						exit();
					}
					if($FormValidator->check_mail() == 'error_mail'){						
						$note = array('textNote' => 'Некоректно вказан e-mail', 'color' => 'red', 'fontSize' => '16');
						echo json_encode($note);
							exit();
					}

					$file = "maillurss.txt";
					
function copy_mail($char) // проверяем, есть ли такой адрес в базе
{
$searchthis = $char;
  $matches = array();
  $handle = @fopen("maillurss.txt", "r");
    if ($handle)
        { 
         while (!feof($handle))
            {
            $buffer = fgets($handle);
            if(strpos($buffer, $searchthis) !== FALSE)
            $matches[] = $buffer;
            }
        fclose($handle);
        }
   //вывод результата
  return ($matches);
}


if(copy_mail($FormValidator->check_mail())){
$note = array('textNote' => 'Ви вже підписались', 'color' => 'red', 'fontSize' => '16');
						echo json_encode($note);
							exit();
	
}

// Новый человек, которого нужно добавить в файл
$person = $FormValidator->check_mail()."\t".$FormValidator->name()."\t".$_SESSION['lang']."\n";
// Пишем содержимое в файл,
// используя флаг FILE_APPEND flag для дописывания содержимого в конец файла
// и флаг LOCK_EX для предотвращения записи данного файла кем-нибудь другим в данное время




if(file_put_contents($file, $person, FILE_APPEND | LOCK_EX)){
$note = array('textNote' => 'Дякуємо за підписку', 'color' => 'green', 'fontSize' => '16');
						echo json_encode($note);
							exit();
}else{


$note = array('textNote' => 'Спробуйте ще пізніше', 'color' => 'red', 'fontSize' => '16');
						echo json_encode($note);
							exit();

}
		
					
				break;



				case 'tarifi_navchannya':

					$subject = 'Профориентационная анкета тестування';
					$email = 'prk_udxtu@ukr.net';



					if($FormValidator->last_name() == 'error_last_name'){						
						$note = array('textNote' => 'Некоректно вказано Прізвище', 'color' => 'red', 'fontSize' => '16');
						echo json_encode($note);
						exit();
					}

					if($FormValidator->name() == 'error_name'){						
						$note = array('textNote' => 'Некоректно вказано Ім\'я', 'color' => 'red', 'fontSize' => '16');
						echo json_encode($note);
						exit();
					}

					if($FormValidator->middle_name() == 'error_middle_name'){						
						$note = array('textNote' => 'Некоректно вказано По батькові', 'color' => 'red', 'fontSize' => '16');
						echo json_encode($note);
						exit();
					}

					

					if($FormValidator->tel() == 'error_mob_phone'){
						$note = array('textNote' => 'Некоректно вказано телефон', 'color' => 'red', 'fontSize' => '16');
						echo json_encode($note);						
						exit();
					}
					if($FormValidator->check_mail() == 'error_mail'){					
						$note = array('textNote' => 'Некоректно вказано e-mail', 'color' => 'red', 'fontSize' => '16');
						echo json_encode($note);		
						exit();
					}

	

					foreach ($this->request->getPost() as $key => $value) {							

						if ( $key != 'fsm_type') 
							$message.=$key.': '.trim((htmlspecialchars(strip_tags($value)))).'<br>';
							if($key[0] === 'v')
								$v +=1; 

						
					}	
					if($v <> 30){
						$note = array('textNote' => 'Не надоно відповіді на всі питання', 'color' => 'red', 'fontSize' => '16');
						echo json_encode($note);
						exit();
						
					}
					$noteSend = 'Дякуємо за відповіді! Результати тестування будуть відправлені Вам на е-mаіl';
				break;
				
				default:
					exit();
					break;
			}


			
			
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
			//$mail->From = $email;
			//$mail->FromName = $name;
			$mail->AddAddress($email);

			$mail->IsHTML(true);
			$mail->Subject = $subject;

			if(isset($_FILES['file_tezis'])){
				if($_FILES['file_tezis']['error'] == 0){
					$mail->AddAttachment($_FILES['file_tezis']['tmp_name'],$_FILES['file_tezis']['name']);
				}
			}
			$mail->Body = $message;
			if ($mail->Send()){
				$note = array('textNote' => $noteSend, 'color' => 'green', 'fontSize' => '16','sendStat' => '1');
					
			}else{				
				$note = array('textNote' => 'Спробуйте пізніше.', 'color' => 'green', 'fontSize' => '16');				
			}		
			echo json_encode($note);				
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
						if($value1['url_title'] == $key && $value1['path'] != $value1['id_mtt'] && $center_punct_data['path_full'] == $value1['path'] ){
							$center_punct_data['name'] 			= $value1['name'];
							$center_punct_data['url'] 			= $value1['url'];
							$center_punct_data['type_position'] = $value1['type_position'];
							$center_punct_data['path_full']		= $value1['path'].'/'.$value1['id_mtt']; // путь центр пункта дерева, но уже с добавленной к нему страницей(полный текуший путь)
							$center_punct_data['path_tree']		= $value1['path']; //путь центр пункта дерева, по нему получаем корневую папку и все что вней лежит с позицией центр							
							//echo  $path_d;
						}
						if($value1['url_title'] == $value && $value !=  'endo' && $value1['path'] != $value1['id_mtt']  && $value1['path'] == $center_punct_data['path_full']  ){
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
					$menu_center =  '<div id="center-punct" style="min-height: 0px; display: block;"><div class="punct_menu_lvl_1  once_c_p active_c_p"><a class="active_c"  href="'.$center_punct_data['href'].'">'.$center_punct_data['name'].'</a></div></div>';
				}
				if($center_punct_data['type_position'] == 'center'){						
					$find_path_tree = $center_punct_data['path_tree'];
					//$check_news =	$GetContent->getCheckNews($center_punct_data['url']);
					//echo $check_news[0]['mu_page'];
					//$center_punct =	$GetContent->getCenterPunct($find_path_tree,$_SESSION['lang'],$check_news[0]['mu_page']);
					$center_punct =	$GetContent->getCenterPunct($find_path_tree,$_SESSION['lang']);
					$width_c_p = (950 - ((count($center_punct))*10))/count($center_punct); // Расчет ширини центральніх пунктов  делением ширині контейнера на колво ячеек
					$menu_center =  '<div id="center-punct" class=" style="display: block;">';
					foreach ($center_punct as $key => $value) {
						//$active_c = ($key == 0) ? 'active_c' : '';
						$menu_center =  $menu_center.'<div  class="punct_menu_lvl_1 "><a style="width:'.$width_c_p.'px" href="'.$center_punct_data['href_tree'].'/'.$value['url_title'].'">'.$value['name'].'</a></div>';
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


			$json_data = array ('menu_center'=>$menu_center,'content'=>$content,'test_url'=>$center_punct_data['url']);		
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