<?php 
namespace OPF\Plugin\Captcha;
Class Captcha{
	
	public $imgDir = '/public/img/global/icon/captcha'; // директория где хранятся изображения
	
	public $length = '4'; // количество цифр в капче
	

	
	public function __construct(){	
		$this->oper = array();
		$this->sum = 0;
		$this->keystring = array();
		for($i=0;$i < $this->length;$i++){
			$this->keystring[$i] = mt_rand(1,8);
					
		}



					switch($this->keystring[1]){
						case $this->keystring[1] >= 5:{
							$this->sum = $this->keystring[0] + $this->keystring[1] * $this->keystring[2] +$this->keystring[3] ;
							$this->oper[0] = "+";
							$this->oper[1] = "x";
							$this->oper[2] = "+";	
							break;							
						}
						case $this->keystring[1] <= 4:{
							$this->sum = $this->keystring[0] + $this->keystring[1] + $this->keystring[2] * $this->keystring[3] ;	
							$this->oper[0] = "+";
							$this->oper[1] = "+";
							$this->oper[2] = "x";							
							break;
						}			
					}			
	}
	
	
	public function draw(){
		$img = '';
		foreach($this->keystring as $key => $keystring){			
			$img .= '<img src="'.$this->imgDir.DIRECTORY_SEPARATOR.$keystring.'.gif">'.$this->oper[$key];
		}
	
		return $img;
	}
	
	
	public function sum(){
		return $this->sum;
	}
	
}

?>