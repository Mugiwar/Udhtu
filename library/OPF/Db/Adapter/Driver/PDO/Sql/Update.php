<?php
namespace OPF\Db\Adapter\Driver\PDO\Sql;
use OPF\Db\Adapter\Driver\PDO\PdoDbConnection;
use PDO;
/* 	ALTER TABLE mu_conf ADD 
     CONSTRAINT  fk_mu_conf_mu_status1
      FOREIGN KEY (status)
      REFERENCES  mu_status(id)
       ON DELETE NO ACTION ON UPDATE NO ACTION */
	   
	   
class Update{

	private $db ;
	public $data ;
	public $count_data;	
	public $user_id = null;
		
	public function __construct($db)
	{
		if($db != null){
			$this->db = $db;
		}else{
			echo "error connect Sql";
		}
	} 
	
	public function updates($query,$data = null){		
		$stmt  = $this->db->prepare('UPDATE '.$query);		
		$done =  $stmt->execute($data); 		
		return $done;
	}

	
}	
	
	
?>