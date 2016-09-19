<?php
namespace Mychem\Model;
use OPF\Mvc\Model\AbstractModel;
//use PDO;
class SqlContent extends AbstractModel
{

	private $__eee;




	public function goTrans(){		
		return $this->db->beginTransaction();
	}

	public function goCommit(){		
		return $this->db->commit();
	}

	public function goRoll(){		
		return $this->db->rollBack();
	}


	public function goInsert($table,$data,$where = null){		
		return $this->insert->inserts($table,$data,$where = null);
	}


	public function goSelect($query,$data = null){		
		return $this->select->selects($query,$data);
	}

	public function goDelete($query,$data = null){		
		return $this->delete->deletes($query,$data);
	}

	public function goUpdate($query,$data = null){		
		return $this->update->updates($query,$data);
	}



	public function last_call_url_value($ids_punct = null){
		$query = "MAX(call_url_value)
					FROM  mu_content_info 
					WHERE  mu_block_punct =?
					";
		$data_select 	= array($ids_punct);

					$result =		$this->select->selects($query,$data_select);
		foreach($result as $key => $value)
					foreach ($value as $key => $value1) 
						foreach ($value as $key => $value2) 
						$result = $value2;
						
					
		
		return $result;

		
	}





	public function getPunctForFolder($ids_punct = null,$lang=null){
		$query = "mu_block,punct,level_deep FROM mu_block_punct WHERE id = ? and mu_language = ?";
		$data_select 	= array($ids_punct,$lang);

					$result =		$this->select->selects($query,$data_select);
		foreach($result as $key => $value)
					foreach ($value as $key1 => $value1)						
						$result[$key1] = $value1;
						
					
		//var_dump($result);
		return $result;

		
	}


		public function getFolder($ids_punct = null, $lang = null,$userFolder = null ){

					$query = "url_title, punct, porydok, level_deep, id
					FROM  mu_block_punct
					WHERE 
						 type_face =  'back'
					AND  url =  'folder'
					AND  id  IN (".$userFolder.")
					AND  permission =2
					AND  mu_language = ?
					ORDER BY mu_block_punct.porydok";
					$data_select 	= array($lang);


			if ($userFolder == 'all') {
						$query = "url_title, punct, porydok, level_deep, id
					FROM  mu_block_punct
					WHERE 
						 type_face =  'back'
					AND  url =  'folder'
					AND  parents_punct =?
					AND  permission =2
					AND  mu_language = ?
					ORDER BY mu_block_punct.porydok";
					$data_select 	= array($ids_punct,$lang);
			}




		

				return	$this->select->selects($query,$data_select);
		

		
	}



		public function getPage($params){	

			$keys = key($params);
			$values 	= $params[$keys];
			$data_select 	= array($keys,$values);
			$query	= "id,content,assoc_language FROM mu_textpage WHERE call_url_key=? AND call_url_value=? AND mu_status = 1";
			return $this->select->selects($query,$data_select);

		}


		public function getPageData($id){				
				$data_select 	= array($id);
				$query	= "mu_page.id,mu_page.title,mu_page.preview,mu_page.content,mu_page.status_published
							FROM mu_page
							WHERE id = ?";
				return $this->select->selects($query,$data_select);

		}





		public function getDegree(){	

		//Данній с таблиці mu_type_presentation  типы доповидей
		$query	= "t_val.degree as value, t_val.id as id FROM mu_conf_info as t_id INNER JOIN mu_degree as t_val ON t_id.id_degree = t_val.id";
		return $this->select->selects($query);		

}



		public function getMRD($mrb = null,$mrp = null,$mrc = null){	

			$data_select = array($mrb,$mrp,$mrc);
			$query	= 
					" mrd.id, mrd.data
						FROM mu_reference_book as mrb
                        	LEFT JOIN  mu_reference_position as mrp ON mrb.id= mrp.mu_reference_book
							LEFT JOIN  mu_reference_catalog as mrc ON mrp.id= mrc.mu_reference_position
							LEFT JOIN  mu_reference_data as mrd ON mrc.id = mrd.mu_reference_catalog
						where
							mrb.id = ? and
							mrp.id = ? and 
                            mrc.id = ?
						";
			return $this->select->selects($query,$data_select);		

		}




		public function getUchStepen(){	

		//Данній с таблиці mu_type_presentation  типы доповидей
		$query	= "t_val.stepen as value, t_val.id as id FROM mu_conf_info as t_id INNER JOIN mu_uch_stepen as t_val ON t_id.id_uch_stepen = t_val.id";
		return $this->select->selects($query);		

}


		public function getTypePresent(){	

		//Данній с таблиці mu_type_presentation  типы доповидей
		$query	= "t_val.type as value, t_val.id as id FROM mu_conf_info as t_id INNER JOIN mu_type_presentation as t_val ON t_id.id_type_presentation = t_val.id";
		return $this->select->selects($query);		

}


		public function getTopicConf($mu_conf_type){	
		$data_select = array($mu_conf_type);
		//Данній с таблиці mu_type_presentation  типы доповидей
		$query	= "id, name as value FROM mu_topic_conf WHERE mu_conf_type = ? ";
		return $this->select->selects($query,$data_select);		

}

		public function getConfInfo($mu_conf_type){
			$data_select 	= array($mu_conf_type);
			$query = "  distinct(mu_work_info),conf.title_public,users.name,users.last_name,users.middle_name,conf.mu_status_view,conf.mu_status_oplata,conf.id,conf.mu_status,users.mail,work.organization,info.mob_phone FROM mu_conf as conf 
 LEFT JOIN  mu_work_info as work ON conf.mu_work_info= work.id
 LEFT JOIN  mu_users as users ON conf.mu_user = users.id
 LEFT JOIN  mu_contact_info as info ON conf.mu_user = info.id



where conf.mu_conf_type = ?
	 ORDER BY conf.id DESC";
			return $this->select->selects($query,$data_select);
		}


				public function getConfInfoSort(array $mu_conf_type){
			$data_select 	= $mu_conf_type;
			$query = "  distinct(mu_work_info),conf.title_public,users.name,users.last_name,users.middle_name,conf.mu_status_view,conf.mu_status_oplata,conf.id,conf.mu_status,conf.mu_user,users.mail FROM mu_conf as conf 
 LEFT JOIN  mu_work_info as work ON conf.mu_work_info= work.id
 LEFT JOIN  mu_users as users ON conf.mu_user = users.id



where conf.mu_conf_type = ? and conf.mu_topic_conf = ? and conf.mu_status_view = 1 
	ORDER BY users.last_name";
			return $this->select->selects($query,$data_select);
		}





		public function getConfPartaker($mu_conf_type){
			$data_select 	= array($mu_conf_type);
			$query = "  distinct(mu_work_info),conf.title_public,users.name,users.last_name,users.middle_name,conf.mu_status_view,conf.mu_status_oplata,conf.id,conf.mu_status FROM mu_conf as conf 
 LEFT JOIN  mu_work_info as work ON conf.mu_work_info= work.id
 LEFT JOIN  mu_users as users ON conf.mu_user = users.id



where conf.mu_conf_type = ? and conf.mu_status_view = 1 
	ORDER BY users.last_name";
			return $this->select->selects($query,$data_select);
		}


		public function lastInsertsId(){

				return $this->insert->lastInsertsId();
		}




				public function getUserTitlePublic($title_public){	
		$data_select 	= $title_public;
		//Данній с таблиці mu_type_presentation  типы доповидей
		$query	= "title_public,id FROM `mu_conf` WHERE mu_user = ? and mu_conf_type = ? ";
		return $this->select->selects($query,$data_select);	

	}


					public function getConfData(array $id_conf){	
		$data_select 	= $id_conf;
		//Данній с таблиці mu_type_presentation  типы доповидей
		$query	= "conf.title_public,users.name,users.last_name,users.middle_name,conf.mu_status_view,conf.mu_status_oplata,conf.id,conf.mu_status,work.organization,work.mu_uch_stepen,work.mu_conf_type,conf.abstracts,conf.party,conf.advanced_training_courses, conf.mu_type_presentation, conf.mu_topic_conf, work.mu_uch_stepen, work.mu_degree, conf.hotel, work.id FROM mu_conf as conf 
 LEFT JOIN  mu_work_info as work ON conf.mu_work_info= work.id
 LEFT JOIN  mu_users as users ON conf.mu_user = users.id



where conf.id =? and  work.mu_user = ?
	";
		return $this->select->selects($query,$data_select);	

	}




						public function getConfMailData(array $id_user_conf){	
		$data_select 	= $id_user_conf;
		//Данній с таблиці mu_type_presentation  типы доповидей
		$query	= "conf.title_public,users.name,users.last_name,users.middle_name,users.mail,conf.mu_status,section.name as sectionName FROM mu_conf as conf 
 LEFT JOIN  mu_users as users ON conf.mu_user = users.id
 LEFT JOIN  mu_topic_conf as section ON conf.mu_topic_conf = section.id


where conf.id =? and  conf.mu_user = ?
	";
		return $this->select->selects($query,$data_select);	

	}









			public function getGenInfo($query,array $mu_gen_data,$qwery_where){
			$data_select 	= $mu_gen_data;



			if ($qwery_where == 5) {
				$query1 = $query." FROM mu_conf as conf 
 LEFT JOIN  mu_work_info as work ON conf.mu_work_info= work.id
 LEFT JOIN  mu_users as users ON conf.mu_user = users.id
 LEFT JOIN  mu_contact_info as info ON conf.mu_user = info.id  
  LEFT JOIN  mu_status as status ON conf.mu_status = status.id
 LEFT JOIN  mu_topic_conf as topic ON conf.mu_topic_conf = topic.id
  LEFT JOIN  mu_type_presentation as type_presentation ON conf.mu_type_presentation = type_presentation.id
 where users.send_mail = 1
	 ORDER BY conf.id DESC";
			}else{
				$query1 = $query." FROM mu_conf as conf 
 LEFT JOIN  mu_work_info as work ON conf.mu_work_info= work.id
 LEFT JOIN  mu_users as users ON conf.mu_user = users.id
 LEFT JOIN  mu_contact_info as info ON conf.mu_user = info.mu_user
 LEFT JOIN  mu_topic_conf as topic ON conf.mu_topic_conf = topic.id
  
  LEFT JOIN  mu_status as status ON conf.mu_status = status.id
 LEFT JOIN  mu_type_presentation as type_presentation ON conf.mu_type_presentation = type_presentation.id



where users.send_mail = 1 ".$qwery_where." ORDER BY conf.id DESC";

			}



			return $this->select->selects($query1,$data_select);
		}





		//SELECT id FROM `mu_file_type`


//SELECT distinct(mu_file_extension.same) FROM `mu_file_type`,`mu_file_extension` WHERE mu_file_type.id = mu_file_extension.mu_file_type

//SELECT id FROM `mu_file_resolution`











	public function checkDate($query,$params = null){	
	$data_select = (is_array( $params )) ? $params : array($params);		
		//$data_select 	= array($params);				
		$result = $this->select->selects($query,$data_select);
		foreach($result as $key => $value){
					foreach ($value as $key => $value) {
						$result[$key] = $value;
					}
		}
		return $result;
	}

	


	public function getAllCallUrl($query,$params = null){	
	$data_select = (is_array( $params )) ? $params : array($params);		
		//$data_select 	= array($params);				
		$result = $this->select->selects($query,$data_select);
				foreach($result as $key => $value){
					foreach ($value as $key => $value) {

						if ($result_back)
							$result_back = $result_back.',' ;
						$result_back =$result_back.$value;
					}
		}
		return $result_back;
	}






//левое меню 


	public function getContentAccess($murg = null){	
			$placeholders = rtrim(str_repeat('?, ', count($murg)), ', ') ;
		$data_select 	= $murg;
		$query	=	"	
					distinct(mu_info_mtt)
						FROM mu_rg_access
					WHERE
						mu_rg IN (".$placeholders.")	
				
					";
		return $this->select->selects($query,$data_select);
	}





	public function getBFMenu($lang = null,$type_content = null,$content_access = null){	
		$type_content = explode('/', $type_content) ;
		$placeholders = rtrim(str_repeat('?, ', count($type_content)), ', ');		
		$type_content[] = $lang;
		$data_select 	= $type_content;	

		if($content_access != 'budda'){
			$placeholders1 = rtrim(str_repeat('?, ', count($content_access)), ', ') ;
			foreach ($content_access as $key => $value) {
				$data_select[]  =  $value['mu_info_mtt'];
			}

			$query	=	"imtt.type_position,imtt.type_content,imtt.type_face,imtt.porydok,imtt.path,imtt.url,mtt.id_data_using as id_mrd,mtt.data,
				imtt.mu_table_translate as id_mtt,mtt.short_data,mrd.data as url_title, imtt.type_position as position
				FROM mu_reference_data  as mrd
				LEFT JOIN mu_table_translate as mtt ON mtt.id_data_using = mrd.id
				LEFT JOIN mu_info_mtt as imtt ON imtt.mu_table_translate = mtt.id
				WHERE mrd.mu_reference_catalog = 1 
				AND mtt.mu_table_using = 4 
				AND imtt.type_content IN (".$placeholders.")
				AND mtt.mu_language = ? 
				AND imtt.id IN (".$placeholders1.")
				
				
				";




		}else{

			$query	=	"imtt.type_position,imtt.type_content,imtt.type_face,imtt.porydok,imtt.path,imtt.url,mtt.id_data_using as id_mrd,mtt.data,
				imtt.mu_table_translate as id_mtt,mtt.short_data,mrd.data as url_title, imtt.type_position as position
				FROM mu_reference_data  as mrd
				LEFT JOIN mu_table_translate as mtt ON mtt.id_data_using = mrd.id
				LEFT JOIN mu_info_mtt as imtt ON imtt.mu_table_translate = mtt.id
				WHERE mrd.mu_reference_catalog = 1 
				AND mtt.mu_table_using = 4 
				AND imtt.type_content IN (".$placeholders.")
				AND mtt.mu_language = ? 			
				
				
				";



		}	
			

		return $this->select->selects($query,$data_select);
	}





			public function getSubBlockMenu($subblock_path,$language){
		$data_select 	= array($subblock_path,$language);		
		$query	=	" 
						mu_reference_data.data as url_title,mu_table_translate.data as name,mu_info_mtt.type_content,mu_info_mtt.path,
						mu_info_mtt.type_position,mu_info_mtt.porydok
						FROM `mu_reference_data` 
							LEFT JOIN mu_table_translate ON mu_table_translate.id_data_using = mu_reference_data.id
							LEFT JOIN mu_info_mtt ON mu_info_mtt.mu_table_translate = mu_table_translate.id
						WHERE mu_reference_data.mu_reference_catalog = 1 AND
							mu_table_translate.mu_table_using = 4 AND
							mu_info_mtt.path = ? AND
							mu_table_translate.mu_language = ? AND						
							mu_info_mtt.mu_status = 1 AND
                     		mu_info_mtt.type_position = 'center'



					";
		return $this->select->selects($query,$data_select);
	}









public function getPathUrl($mrd = null,$language = null ){
		$data_select 	= array($mrd,$language);		
		$query	=	" 
						  mtt.id AS id_mtt,imtt.path as path
								FROM  mu_table_translate as mtt 								
									LEFT JOIN mu_info_mtt as imtt ON imtt.mu_table_translate = mtt.id
								WHERE 								
									mtt.mu_table_using			=	4	
									AND imtt.mu_status 			=	1
 									AND mtt.id_data_using		=	?
 									AND mtt.mu_language 		<>	?
					";
		return $this->select->selects($query,$data_select);
	}












		public function getUrlBF($language = null,$url_title = null){

					$data_select = array($language,$url_title);
					$query	= 
							"	mu_reference_data.data AS url_title, mu_info_mtt.path, mu_info_mtt.type_access,mu_reference_data.id AS mrd_id
								FROM  `mu_reference_data` 
									LEFT JOIN mu_table_translate ON mu_table_translate.id_data_using = mu_reference_data.id
									LEFT JOIN mu_info_mtt ON mu_info_mtt.mu_table_translate = mu_table_translate.id
								WHERE 
									mu_reference_data.mu_reference_catalog	 	=	1
									AND mu_table_translate.mu_table_using		=	4
									AND mu_table_translate.mu_language			=	?
								
									AND mu_info_mtt.mu_status 					=	1							
									AND (mu_info_mtt.type_content 				=  'block' OR mu_info_mtt.type_content='folder') 
									AND mu_reference_data.data 					=  ?
								";

			return $this->select->selects($query,$data_select);		

		}


		public function getUrlBFId($type = null,$url_title = null,$path = null){	


			switch ($type) {
				case 'BF':
					$data_select = array($url_title);
					$query	= 
							"	mu_reference_data.data AS url_title, mu_info_mtt.path, mu_info_mtt.type_access,mu_reference_data.id AS mrd_id
								FROM  `mu_reference_data` 
									LEFT JOIN mu_table_translate ON mu_table_translate.id_data_using = mu_reference_data.id
									LEFT JOIN mu_info_mtt ON mu_info_mtt.mu_table_translate = mu_table_translate.id
								WHERE 
									mu_reference_data.mu_reference_catalog	 	=	1
									AND mu_table_translate.mu_table_using		=	4	
									AND mu_info_mtt.mu_status 					=	1							
									AND (mu_info_mtt.type_content 				=  'block' OR mu_info_mtt.type_content='folder') 
									AND mu_reference_data.data 					=  ?
								";
					break;
				case 'subBF':
					if(count($path) > 1){
						$path = explode('|', $path) ;
						$placeholders = rtrim(str_repeat('?, ', count($path)), ', ') ;
					}else{
						$placeholders = "'".$path."'";
					}


					$data_select = array($url_title);
					$query	= 
							"	mu_reference_data.data AS url_title, mu_info_mtt.path, mu_info_mtt.type_access,mu_reference_data.id AS mrd_id
								FROM  `mu_reference_data` 
									LEFT JOIN mu_table_translate ON mu_table_translate.id_data_using = mu_reference_data.id
									LEFT JOIN mu_info_mtt ON mu_info_mtt.mu_table_translate = mu_table_translate.id
								WHERE 
									mu_reference_data.mu_reference_catalog	 	=	1
									AND mu_table_translate.mu_table_using		=	4	
									AND mu_info_mtt.mu_status 					=	1
									AND  mu_info_mtt.path 						IN (".$placeholders.")  									
									AND (mu_info_mtt.type_content 				=  'subblock' OR mu_info_mtt.type_content='subfolder') 
									AND mu_reference_data.data 					=	?
								";
					break;
				case 'page':
					if(count($path) > 1){
						$path = explode('|', $path) ;
						$placeholders = rtrim(str_repeat('?, ', count($path)), ', ') ;
					}else{
						$placeholders = "'".$path."'";
					}





					$data_select = array($url_title);
					$query	= 
							"	mu_reference_data.data AS url_title, mu_info_mtt.path, mu_info_mtt.type_access,mu_reference_data.id AS mrd_id
								FROM  `mu_reference_data` 
									LEFT JOIN mu_table_translate ON mu_table_translate.id_data_using = mu_reference_data.id
									LEFT JOIN mu_info_mtt ON mu_info_mtt.mu_table_translate = mu_table_translate.id
								WHERE 
									mu_reference_data.mu_reference_catalog	 	=	1
									AND mu_table_translate.mu_table_using		=	4	
									AND mu_info_mtt.mu_status 					=	1
									AND  mu_info_mtt.path 						IN (".$placeholders.")  								
									AND mu_info_mtt.type_content 				=  'page'
									AND mu_reference_data.data 					=	?
								";
					break;
				default:
					return 0;
					break;
			}

			return $this->select->selects($query,$data_select);		

		}



		public function getTreeContent($language = null,$path = null,$content_access = null){			
		

			if ($content_access != 'budda') {
				$placeholders = rtrim(str_repeat('?, ', count($content_access)), ', ');
				$data_select = array($language,$path);
				foreach ($content_access as $key => $value) {
					$data_select[]  =  $value['mu_info_mtt'];
			}	

			$query	= 
					"	mu_reference_data.data AS url_title, mu_info_mtt.path, mu_info_mtt.type_access,mu_info_mtt.url,mu_reference_data.id as id_mrd,
							mu_info_mtt.mu_table_translate as id_mtt, mu_info_mtt.type_position,mu_table_translate.data as name,
							mu_table_translate.id_data_using as otdel,mu_table_translate.short_data as short_name,mu_info_mtt.type_content
						FROM  `mu_reference_data` 
							LEFT JOIN mu_table_translate ON mu_table_translate.id_data_using = mu_reference_data.id
							LEFT JOIN mu_info_mtt ON mu_info_mtt.mu_table_translate = mu_table_translate.id
						WHERE 
							mu_reference_data.mu_reference_catalog	 	=	1
							AND mu_table_translate.mu_table_using		=	4
							AND mu_table_translate.mu_language			=	?
							
							AND mu_info_mtt.mu_status 					=	1	
							AND mu_info_mtt.path 						= ?
							AND mu_info_mtt.id IN (".$placeholders.")

						";


				
			}else{
				$data_select = array($language,$path);
			$query	= 
					"	mu_reference_data.data AS url_title, mu_info_mtt.path, mu_info_mtt.type_access,mu_info_mtt.url,mu_reference_data.id as id_mrd,
							mu_info_mtt.mu_table_translate as id_mtt, mu_info_mtt.type_position,mu_table_translate.data as name,
							mu_table_translate.id_data_using as otdel,mu_table_translate.short_data as short_name,mu_info_mtt.type_content
						FROM  `mu_reference_data` 
							LEFT JOIN mu_table_translate ON mu_table_translate.id_data_using = mu_reference_data.id
							LEFT JOIN mu_info_mtt ON mu_info_mtt.mu_table_translate = mu_table_translate.id
						WHERE 
							mu_reference_data.mu_reference_catalog	 	=	1
							AND mu_table_translate.mu_table_using		=	4
							AND mu_table_translate.mu_language			=	?
							
							AND mu_info_mtt.mu_status 					=	1	
							AND mu_info_mtt.path 						= ?
							

						";
			}
					
			return $this->select->selects($query,$data_select);		

		}






	public function getLoginData($mus_login){	
		$data_select 	=  array($mus_login);
		$query	= "id, name,last_name,middle_name,mail FROM mu_users WHERE login = ?";
		return $this->select->selects($query,$data_select);	

	}



/*
Получение менюшек по типу левое меню правое итп

SELECT * 
FROM `mu_reference_data` 
LEFT JOIN mu_table_translate ON mu_table_translate.id_data_using = mu_reference_data.id
LEFT JOIN mu_info_mtt ON mu_info_mtt.mu_table_translate = mu_table_translate.id
WHERE mu_reference_data.mu_reference_catalog = 1 AND
mu_table_translate.mu_table_using = 4 AND
mu_table_translate.mu_language = 1






*/





}