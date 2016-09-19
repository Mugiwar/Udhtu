<?php
namespace OPF\Http;


class Request
{

	private $__method;
	private $__POST;
	private $__GET;

	public function __construct(){
		if (!empty($_SERVER['REQUEST_METHOD'])) {
			switch ($_SERVER['REQUEST_METHOD']) {
			case 'POST':
				$this->__method = "POST";
				$this->__POST = $_POST;
				break;
			case 'GET':
				$this->__method = "GET";
				break;			
			default:
				$this->__method = "WTF";
				break;
			}
		}
		



	}



	public function getMethod(){
		return $this->__method;

	}

		public function getPost($name = null){
			if($name !=  null)
				$this->__POST = (($name != null) && ($_POST[$name] != null)) ? $_POST[$name] : null;
			else
			$this->__POST =  $_POST;			
		return $this->__POST;

	}






}