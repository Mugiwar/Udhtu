<?php
namespace OPF\Mvc\Model;
use OPF\Db\Adapter\Driver\PDO\PdoDbConnection;
use OPF\Db\Adapter\Driver\PDO\Sql\Insert;
use OPF\Db\Adapter\Driver\PDO\Sql\Select;
use OPF\Db\Adapter\Driver\PDO\Sql\Update;
use OPF\Db\Adapter\Driver\PDO\Sql\Delete;

abstract class AbstractModel
{

	protected $db;
	protected $insert;
	protected $select;
	protected $update;
	protected $delete;

	public function __construct(){
		$this->db = PdoDbConnection::getInstance();
		$this->insert = new Insert($this->db);
		$this->select = new Select($this->db);
		$this->update = new Update($this->db);
		$this->delete = new Delete($this->db);
	}




}