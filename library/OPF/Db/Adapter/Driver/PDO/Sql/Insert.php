<?php
namespace OPF\Db\Adapter\Driver\PDO\Sql;

/* 	ALTER TABLE mu_conf ADD 
     CONSTRAINT  fk_mu_conf_mu_status1
      FOREIGN KEY (status)
      REFERENCES  mu_status(id)
       ON DELETE NO ACTION ON UPDATE NO ACTION */
	   
	   
class Insert{

	private  $db ;
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
	
	
	public function inserts($table,array $data, $where = null)
	{		
		$this->table = $table;
		$this->count_data = count($data)-1;
		foreach($data as $kay => $value){
			$value_data.= $kay.",";
			$value_prepare.="?,";				
		}
		$value_data		= "(".substr($value_data,0,-1).")";
		$value_prepare	= "(".substr($value_prepare,0,-1).")";
		if($where === null){			
			($conn = $this->db->prepare("INSERT INTO ".$this->table." ".$value_data." values ".$value_prepare.""));
			$i = 0;
			foreach($data as $kay => $value){				
				$data_back[$i] =$data[$kay];
				$i++;			
			}				
			return  $conn->execute($data_back);	//dannie ne vstavilis esle folse										
	 	}else{
			return false; //where null
		}
	} 	




	private function placeholders($text, $count=0, $separator=",")
	{
	    $result = array();
	    if($count > 0){
	        for($x=0; $x<$count; $x++){
	            $result[] = $text;
	        }
	    }
	    return implode($separator, $result);
	}




	public function insertsArr($table,array $datafields,array $data, $where = null)
	{	
		$this->table = $table;
		$this->db->beginTransaction(); // also helps speed up your inserts.
		$insert_values = array();
		foreach($data as $d){
		    $question_marks[] = '('  . $this->placeholders('?', sizeof($d)) . ')';
		    $insert_values = array_merge($insert_values, array_values($d));
		}

		$sql = "INSERT INTO ".$this->table." (" . implode(",", $datafields ) . ") VALUES " . implode(',', $question_marks);		
		$stmt = $this->db->prepare ($sql);
		try {
		    $stmt->execute($insert_values);
		} catch (PDOException $e){
		    echo $e->getMessage();
		}
		$this->db->commit();
		return 0;
	} 

	
	public function lastInsertsId()
	{	
		return $this->db->lastInsertId();
	
	}
	
}	
	
	
?>