<?php
namespace Mychem\Controller;

use OPF\Mvc\Controller\AbstractController;
use OPF\Filter\Requests\FormValidator;
use Mychem\Model\SqlContent;
use Mychem\Filter\Filter_error;
class IndexController extends AbstractController
{
	
	
	public function indexAction(){		
		$action = $this->getAction();
		$method = $this->request->getMethod();
		$contr  = $this->request->getPost();				
			
		$this->view->render('index', array( 'action' => $action,
											'method' => $method,
											'post' 	 => $contr,
										));
	}



	public function sectionAction(){
		$SqlContent = new SqlContent();
		$method = $this->request->getMethod();
		$params = $this->getParams();					
		$arrStatus = $SqlContent->getStatus();
		$arrSection = $SqlContent->getSection();

		if ($method == "GET") {
			if ((!empty($params))) {				
				if (key($params) === 'edit') {
					$pageAction = "edit_";
				}elseif (key($params) === 'new') {
					$pageAction = "new_";
				}else{
					$this->goToUrl('http://galtex.ua/admin/section');
				}								
			}
		}

		if($method == 'POST' && ($this->getAction() == 'section')){
				$pageAction = $this->request->getPost('pageAction');
				$section = $this->request->getPost($pageAction.'section');
				$status  = $this->request->getPost($pageAction.'status');
				$date 	 = date("Y-m-d H:i:s"); 
				if ($pageAction === "new_") {
					$data_insert = array(
									'section'	=> $section,
									'gx_status' => $status,
									'date_create' 	=> $date,
								 	'date_update'	=> $date,
								 	'gx_author_update' 	=> $this->storageUser['id'],
									'gx_author_create'  => $this->storageUser['id'],									
									);
					$done = $SqlContent->goInsert('gx_section',$data_insert);
				}elseif ($pageAction === "edit_") {
					$id  = $params['edit'];					
					$query = "gx_section SET section=? , gx_status=?,date_update=?,gx_author_update=? WHERE id=?";
					$data_update = array($section,$status,$date,$this->storageUser['id'],$id);						
					$done = $SqlContent->goUpdate($query,$data_update);
				}							
				if ($done) {
					$this->goToUrl('http://galtex.ua/admin/section');
				}else{
					echo "Ne 4ego  s bazoy ne viwlo";
				}				
			}
	
			$this->view->render('section', array( 
											'status'	 => $arrStatus,
											'arrSection' => $arrSection,
											'params' 	 => $this->getParams(),
											'method' 	 => $method,
											'pageAction' => $pageAction,
											'id'		 =>	$params['edit'],
										));
		
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