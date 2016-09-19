<?php
namespace Front\Model;
use OPF\Mvc\Model\AbstractModel;
use PDO;
class GetContent extends AbstractModel
{

	private $__eee;



	public function goSelect($query,$data = null){		
		return $this->select->selects($query,$data);
	}

	public function goInsert($table,$data,$where = null){		
		return $this->insert->inserts($table,$data,$where = null);
	}

	public function goInsertArr($table,$field,$data,$where = null){		
	return $this->insert->insertsArr($table,$field,$data,$where = null);
	}

	public function goUpdate($query,$data = null){		
		return $this->update->updates($query,$data);
	}

	public function getIdentity($mail,$password,$salt = null){			
		$data_select 	= array(trim($mail));
		$query 			= "id,name,salt,password,send_mail FROM mu_users WHERE mail=?";
		$storageUser 	= $this->select->selects($query,$data_select);		
		if ($storageUser != null) {			
			foreach ($storageUser as $key => $value) 
				foreach ($value as $key => $value) {				
					$storageUser1[$key] = $value;
				}		
				//echo $storageUser1['password'];substr("пример", 0, 4)
				$password = trim(htmlspecialchars(strip_tags($password)));
				//echo 		md5(md5($password.$storageUser1['salt']));	
				//echo md5(md5($password.$storageUser1['salt']));
				//echo '<br>';	
				//echo md5(md5('demy6@ukr.net').md5(md5('Імя')).'demy6');
				//echo md5(md5(trim( (htmlspecialchars(strip_tags(($password)))))).$storageUser1['salt']);
			if ($storageUser1['password'] === substr(md5(md5($password.$storageUser1['salt'])),0,-2)||
				($storageUser1['password'] === md5(md5($password.$storageUser1['salt']))) ||
				($storageUser1['password'] ===  md5(md5(trim( (htmlspecialchars(strip_tags(($password)))))).$storageUser1['salt']))){					
				$data_select = array($storageUser1['id']);
				$query = "mutr.role,mu_rg.id as id_rg,mu_rg.mu_group_access as mga_rg
										FROM mu_rgu 
										RIGHT JOIN mu_rg ON mu_rg.id = mu_rgu.mu_rg
										left JOIN mu_type_role as mutr ON mutr.id = mu_rg.mu_type_role
										WHERE mu_rgu.mu_users = ?

						";			
				$role  = $this->select->selects($query,$data_select);

				$query = "mu_rg as id_rg
								FROM mu_rgu 			
								WHERE mu_users = ?

						";
				$id_rg  = $this->select->selects($query,$data_select);
				foreach ($id_rg as $key => $value) {
					$rg[] = $value['id_rg'];
				}
				$storageUser1['id_rg'] = $rg;

				foreach ($role as $key => $value) 
					foreach ($value as $key => $value) {
						$role1[$key] = $value;
					}			
				$storageUser1['role'] 	 = $role1['role'];
				$storageUser1['mga_rg'] 	 = $role1['mga_rg'];
				//$storageUser1['id_rg'] 	 = $id_rg;
				$storageUser1['active']  = true;			
				return $storageUser1;
			}else{
				return false;
			}
		}else{
			return false;

		}
	}


	public function checkDate($query,$params){		// вроде бі проверка данніх в валидаторе.	
		$data_select 	= array($params);				
		$result = $this->select->selects($query,$data_select);
		foreach($result as $key => $value){
					foreach ($value as $key => $value) {
						$result[$key] = $value;
					}
		}
		return $result;
	}


		public function lastInsertsId(){

				return $this->insert->lastInsertsId();
		}



public function getPage($params,$lang){			
		$keys = key($params);
		$values 	= $params[$keys];
		
		$data_select 	= array($lang,$keys,$values);
		//var_dump($data_select);
		$query	= "
				id,content FROM `mu_textpage`
			
			WHERE 	
               mu_language=? and
					call_url_key=? and 
					call_url_value=?";
		return $this->select->selects($query,$data_select);

	}


	public function getPageParams($id_page){
		$data_select 	= array($id_page);
		$query	=	"	
						title,preview,content,status_published
				 		FROM mu_page			
						WHERE 	
						id=?
					";
		return $this->select->selects($query,$data_select);

	}

		public function getContact($id_mtt_fak = null,$id_use_table = null, $language = null){
		$data_select 	= array($id_mtt_fak,$id_use_table,$language);
		$query	=	"	
						mcd.data,mtt.short_data as label,mcd.porydok
				 		FROM mu_contact_data as mcd
				 		LEFT JOIN  mu_type_contact as mtc ON mtc.id= mcd.mu_type_contact
							LEFT JOIN  mu_table_translate as mtt ON mtt.id_data_using= mtc.id
										
						WHERE 	
						mcd.id_use_table=?
						AND mtt.mu_table_using		=	?
						AND mtt.mu_language			=	?
						ORDER BY mcd.porydok
					";
		return $this->select->selects($query,$data_select);

	}


		public function getStaff($id_mrd_otdel = null,$id_use_table = null, $language = null){
		$data_select 	= array($id_mrd_otdel,$id_use_table,$language);
		$query	=	"	
						msp.name,msp.last_name,msp.middle_name,mspi.porydok_view,mtt.data,mspi.porydok_slide,mtt.short_data,msp.img,msp.about
						FROM mu_staff_personal as msp
							LEFT JOIN  mu_staff_pi as mspi ON mspi.mu_staff_personal= msp.id
							LEFT JOIN  mu_table_translate as mtt ON mtt.id_data_using= mspi.mu_staff
						WHERE
							mspi.id_data_using		= ?
							AND mtt.mu_table_using	= ?
							AND mtt.mu_language		= ?
							AND mspi.porydok_view <> 0
							AND mspi.porydok_slide <> 0
						ORDER BY mspi.porydok_slide,mspi.porydok_view	
					";
		return $this->select->selects($query,$data_select);

	}



public function getOprosq($opros = null ){
		$placeholders = rtrim(str_repeat('?, ', count($opros)), ', ') ;
		$data_select 	= $opros;
		$query	=	"	
						moa.mu_opros_q, moa.mu_opros_a, moa.mu_type_html_q, moa.mu_type_html_a, moqa.data,mthq.open,mthq.close,mthq.middle,mthq.label,moa.mu_opros_name,moa.porydok,mon.priview,mthq.middle2
						FROM mu_opros_a AS moa
						LEFT JOIN mu_opros_qa AS moqa ON moqa.id = moa.mu_opros_q
						LEFT JOIN mu_type_html AS mthq ON mthq.id = moa.mu_type_html_q
						LEFT JOIN mu_opros_name AS mon ON mon.id = moa.mu_opros_name
						WHERE moa.mu_opros_name IN (".$placeholders.")
						GROUP BY moa.mu_opros_q
						order by moa.mu_opros_name, moa.porydok
					";					
		return $this->select->selects($query,$data_select);

	}


	public function getOprosa($opros = null ){
		$placeholders = rtrim(str_repeat('?, ', count($opros)), ', ') ;
		$data_select 	= $opros;
		$query	=	"	
						moa.mu_opros_q, moa.mu_opros_a, moa.mu_type_html_q, moa.mu_type_html_a, moqa.data,mthq.open,mthq.close,mthq.middle,mthq.label,moa.mu_opros_name,moa.porydok,mthq.middle2
						FROM mu_opros_a AS moa
						LEFT JOIN mu_opros_qa AS moqa ON moqa.id = moa.mu_opros_a
						LEFT JOIN mu_type_html AS mthq ON mthq.id = moa.mu_type_html_a
						WHERE moa.mu_opros_name IN (".$placeholders.")
						order by moa.mu_opros_name,moa.mu_opros_q, moa.porydok
					";
		return $this->select->selects($query,$data_select);

	}




		public function getFakKaf($id_mtt_fak = null,$id_use_table = null, $kaf_spec = null, $language = null){
			if ($kaf_spec == 'all') {
				$data_select 	= array($id_mtt_fak,$id_use_table,$language);
				$query	=	"	
								mfr.type_data,mfr.note,mtt.data,imtt.path,imtt.mu_table_translate,mtt.short_data as short_data
								FROM mu_fak_relation as mfr				 	
													LEFT JOIN  mu_table_translate as mtt ON mtt.id_data_using= mfr.id_data	
													LEFT JOIN  mu_info_mtt as imtt ON imtt.mu_table_translate = mtt.id										
													WHERE 	
													mfr.id_fak_mrd			= ?
													AND mfr.mu_table_using	= ?																
													AND mtt.mu_language		= ?
													
							";
				
			}else {

						$data_select 	= array($id_mtt_fak,$id_use_table,$kaf_spec,$language);
						$query	=	"	
							mfr.note,mtt.data as $kaf_spec,imtt.path,imtt.mu_table_translate,mtt.short_data as short_data
							FROM mu_fak_relation as mfr				 	
												LEFT JOIN  mu_table_translate as mtt ON mtt.id_data_using= mfr.id_data	
												LEFT JOIN  mu_info_mtt as imtt ON imtt.mu_table_translate = mtt.id										
												WHERE 	
												mfr.id_fak_mrd			= ?
												AND mfr.mu_table_using	= ?
												AND	mfr.type_data		= ?						
												AND mtt.mu_language		= ?
												ORDER BY $kaf_spec
						";




			}

			if ($kaf_spec == 'osp_spec') {

						$data_select 	= array($id_mtt_fak,$id_use_table,$language);
						$query	=	"	
								mfr.type_data,mfr.note,mtt.data,imtt.path,imtt.mu_table_translate,mtt.short_data as short_data
								FROM mu_fak_relation as mfr				 	
													LEFT JOIN  mu_table_translate as mtt ON mtt.id_data_using= mfr.id_data	
													LEFT JOIN  mu_info_mtt as imtt ON imtt.mu_table_translate = mtt.id										
													WHERE 	
													mfr.id_fak_mrd			= (SELECT mfr.id_fak_mrd as otdel
								FROM mu_fak_relation as mfr				 	
													LEFT JOIN  mu_table_translate as mtt ON mtt.id_data_using= mfr.id_data	
									
													WHERE 	
													mtt.id		= ?
													AND mfr.type_mrd		= 'kaf'
													AND mfr.mu_table_using	= 4																
													AND mtt.mu_language		= 1
														)
													AND mfr.mu_table_using	= ?															
													AND mtt.mu_language		= ?
						";




						}

			if ($kaf_spec == 'opros_p') {

			$data_select 	= array($id_mtt_fak,$kaf_spec,$id_use_table);
			$query	=	"	
					mfr.id_data as opros
					FROM mu_fak_relation as mfr	 					
										WHERE 	
										mfr.id_fak_mrd			= ?
										AND mfr.type_mrd		= ?
										AND mfr.mu_table_using	= ?															
																
										
			";

			}

			if ($kaf_spec == 'opros_cat' ) {

			$data_select 	= array($id_mtt_fak,$kaf_spec,$id_use_table);
			$query	=	"	
					mfr.id_fak_mrd as otdel
					FROM mu_fak_relation as mfr	 					
										WHERE 	
										mfr.id_data			= ?
										AND mfr.type_data		= ?
										AND mfr.mu_table_using	= ?															
																
										
			";




			}

		return $this->select->selects($query,$data_select);

	}

			public function getMrdMttUrl($id_mtt = null){
			
				$id_mtt = explode('/', $id_mtt) ;
				$placeholders = rtrim(str_repeat('?, ', count($id_mtt)), ', ') ;					
				$data_select 	= $id_mtt;
				$query	=	"	
								mrd.data as url,mtt.data as name,mtt.id
								FROM mu_table_translate as mtt				 	
													
													LEFT JOIN  mu_reference_data as mrd ON mrd.id = mtt.id_data_using
													WHERE 	
													mtt.mu_table_using	= 4													
													AND mtt.id IN (".$placeholders.")
													
							";
					if($_SESSION['storageUser']['role'] == 'budda'){
							//print_r($query);
							//print_r($data_select);
						}
		return $this->select->selects($query,$data_select);

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







		public function getUrlBF($language = null,$url_title = null){	

			$data_select = array($language,$url_title);
			$query	= 
					"	mu_reference_data.data AS url_title, mu_info_mtt.path, mu_info_mtt.type_access
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



		public function getTreeContent($language = null,$path = null,$spec = null){	

			$data_select = array($language,$path.'%');
			$query	= 
				"	mu_reference_data.data AS url_title, mu_info_mtt.path,mu_info_mtt.porydok, mu_info_mtt.type_access,mu_info_mtt.url,mu_reference_data.id as id_mrd,
						mu_info_mtt.mu_table_translate as id_mtt, mu_info_mtt.type_position,mu_table_translate.data as name,
						mu_table_translate.id_data_using as otdel,mu_table_translate.short_data as short_name
					FROM  `mu_reference_data` 
						LEFT JOIN mu_table_translate ON mu_table_translate.id_data_using = mu_reference_data.id
						LEFT JOIN mu_info_mtt ON mu_info_mtt.mu_table_translate = mu_table_translate.id
					WHERE 
						mu_reference_data.mu_reference_catalog	 	=	1
						AND mu_table_translate.mu_table_using		=	4
						AND mu_table_translate.mu_language			=	?
						
						AND mu_info_mtt.mu_status 					=	1	
						AND mu_info_mtt.path 						like ?
					";

			switch ($spec) {
				case '#':
					$data_select = array($path,$language,$path.'%');
			$query	= "	mu_reference_data.data AS url_title, mu_info_mtt.path,mu_info_mtt.porydok, mu_info_mtt.type_access,mu_info_mtt.url,mu_reference_data.id as id_mrd,
							mu_info_mtt.mu_table_translate as id_mtt, mu_info_mtt.type_position,mu_table_translate.data as name,
							mu_table_translate.id_data_using as otdel,mu_table_translate.short_data as short_name
						FROM  `mu_reference_data` 
							LEFT JOIN mu_table_translate ON mu_table_translate.id_data_using = mu_reference_data.id
							LEFT JOIN mu_info_mtt ON mu_info_mtt.mu_table_translate = mu_table_translate.id
						WHERE 
							mu_reference_data.mu_reference_catalog	 	=	1
							AND mu_table_translate.mu_table_using		=	4
							AND mu_info_mtt.mu_table_translate 			<>	?
							AND mu_table_translate.mu_language			=	?
							AND mu_info_mtt.url 						=	'#'
							AND mu_info_mtt.mu_status 					=	1	
							AND mu_info_mtt.path 						like ?
						";
					break;
				case 'one':
					$data_select = array($language,$path);
					break;
				
				default:
					$data_select = array($language,$path.'%');
					break;
			}



			
			return $this->select->selects($query,$data_select);		

		}


	public function getTree($path = null){	

			$data_select = array($path.'%');
			$query	= 
					"	* 
						FROM  mu_info_mtt 
						WHERE  path LIKE  ?
						";
			return $this->select->selects($query,$data_select);		

		}






	public function getBlockMenu($lang = null){	
				$data_select 	= array($lang);
		$query	=	"mu_reference_data.data as url_title,mu_info_mtt.type_face,mu_table_translate.data as name,mu_info_mtt.type_content,mu_info_mtt.path,
						mu_info_mtt.type_position,mu_info_mtt.porydok,mu_info_mtt.mu_table_translate as id_mtt,mu_info_mtt.url
				FROM `mu_reference_data` 
				LEFT JOIN mu_table_translate ON mu_table_translate.id_data_using = mu_reference_data.id
				LEFT JOIN mu_info_mtt ON mu_info_mtt.mu_table_translate = mu_table_translate.id
				WHERE mu_reference_data.mu_reference_catalog = 1 AND
				mu_table_translate.mu_table_using = 4 AND
				mu_table_translate.mu_language = ? AND
				mu_info_mtt.type_face = 'front' AND
				mu_info_mtt.mu_status = 1
				ORDER BY mu_info_mtt.porydok";

		return $this->select->selects($query,$data_select);
	}


	


				public function getCheckNews($check_news = null){	

					$data_select = array($check_news);
					$query	= 
							"	mu_page 
								FROM  mu_page_news 
								WHERE  
									mu_page =  ?
								";
				return $this->select->selects($query,$data_select);		

		}






			public function getCenterPunct($subblock_path = null,$language = null,$check_news = null){
				if(isset($check_news)){
					$data_select 	= array($subblock_path,$language,$check_news);		
					$query	=	"mu_reference_data.data as url_title,mu_table_translate.data as name,mu_info_mtt.type_content,mu_info_mtt.path,
									mu_info_mtt.type_position,mu_info_mtt.porydok,mu_info_mtt.url
									FROM `mu_reference_data` 
										LEFT JOIN mu_table_translate ON mu_table_translate.id_data_using = mu_reference_data.id
										LEFT JOIN mu_info_mtt ON mu_info_mtt.mu_table_translate = mu_table_translate.id
									WHERE mu_reference_data.mu_reference_catalog = 1 AND
										mu_table_translate.mu_table_using = 4 AND
										mu_info_mtt.path = ? AND
										mu_table_translate.mu_language = ? AND						
										mu_info_mtt.mu_status = 1 AND
										mu_info_mtt.url = ?
										ORDER BY mu_info_mtt.porydok";


				}else{
					$data_select 	= array($subblock_path,$language);		
					$query	=	"mu_reference_data.data as url_title,mu_table_translate.data as name,mu_info_mtt.type_content,mu_info_mtt.path,
									mu_info_mtt.type_position,mu_info_mtt.porydok,mu_info_mtt.url
									FROM `mu_reference_data` 
										LEFT JOIN mu_table_translate ON mu_table_translate.id_data_using = mu_reference_data.id
										LEFT JOIN mu_info_mtt ON mu_info_mtt.mu_table_translate = mu_table_translate.id
									WHERE mu_reference_data.mu_reference_catalog = 1 AND
										mu_table_translate.mu_table_using = 4 AND
										mu_info_mtt.path = ? AND
										mu_table_translate.mu_language = ? AND						
										mu_info_mtt.mu_status = 1
										ORDER BY mu_info_mtt.porydok";



				}


		
		return $this->select->selects($query,$data_select);
	}







			public function getSubBlockMenu($subblock_path = null,$language = null){
		$data_select 	= array($subblock_path,$language);		
		$query	=	"mu_reference_data.data as url_title,mu_table_translate.data as name,mu_info_mtt.type_content,mu_info_mtt.path,
						mu_info_mtt.type_position,mu_info_mtt.porydok,mu_info_mtt.url
						FROM `mu_reference_data` 
							LEFT JOIN mu_table_translate ON mu_table_translate.id_data_using = mu_reference_data.id
							LEFT JOIN mu_info_mtt ON mu_info_mtt.mu_table_translate = mu_table_translate.id
						WHERE mu_reference_data.mu_reference_catalog = 1 AND
							mu_table_translate.mu_table_using = 4 AND
							mu_info_mtt.path = ? AND
							mu_table_translate.mu_language = ? AND						
							mu_info_mtt.mu_status = 1 AND
                     		mu_info_mtt.type_position = 'center'
                     		ORDER BY mu_info_mtt.porydok";
		return $this->select->selects($query,$data_select);
	}




}

/*
SELECT * FROM `mu_block_punct` WHERE `mu_block` = 1 and
`type_face` = 'front' and
`porydok` = 1 and
`permission` = 2 and
`level_deep` = 0 and
`mu_status` = 1




	public function getPunctMenu(){	
		$query	=	" * FROM mu_block_punct WHERE					
					type_face = 'front' and				
					permission = 2 and					
					mu_status = 1";
		return $this->select->selects($query);
	}
SELECT *, parents_punct * (SELECT id FROM `mu_block_punct` WHERE id  IN (SELECT `parents_punct` FROM `mu_block_punct`)) as test FROM `mu_block_punct` 
*/



