<?php
namespace Front\Form;
use PDO;
use Front\Model\GetContent;
class FormValidator{

	public $regData = array();
	public $error = 0;
	private $conn = null;
	public $salt = null;

	
	public function __construct(array $regData){			
	/*		foreach($regData as $kay => $value){				
				$this->$kay	= (!empty($regData[$key])) ? $regData[$key] : null;							
			}
	*/
	
		$this->last_name	=		(!empty($regData['mu_last_name'])) ? $regData['mu_last_name'] : null;
		$this->name			=		(!empty($regData['mu_name'])) ? $regData['mu_name'] : null;		
		$this->middle_name	=		(!empty($regData['mu_middle_name'])) ? $regData['mu_middle_name'] : null;
		$this->sex 			=		(!empty($regData['mu_sex'])) ? $regData['mu_sex'] : null;
		$this->tel 			=		(!empty($regData['mu_tel'])) ? $regData['mu_tel'] : null;
		$this->skype 		=		(!empty($regData['mu_skype'])) ? $regData['mu_skype'] : null;
		$this->mail			=		(!empty($regData['mu_mail'])) ? $regData['mu_mail'] : null;
		$this->login		=		(!empty($regData['mu_login'])) ? $regData['mu_login'] : null;
		$this->password		=		(!empty($regData['mu_password'])) ? $regData['mu_password'] : null;
		$this->password2	=		(!empty($regData['mu_password2'])) ? $regData['mu_password2'] : null;
		$this->captcha		=		(!empty($regData['mu_captcha'])) ? $regData['mu_captcha'] : null;
//----------------------------------------------------------------------------------------------------------------
		$this->organization	=		(!empty($regData['mu_organization'])) ? $regData['mu_organization'] : null;
		$this->degree		=		(!empty($regData['mu_degree'])) ? $regData['mu_degree'] : null;
		$this->uch_stepen	=		(!empty($regData['mu_uch_stepen'])) ? $regData['mu_uch_stepen'] : null;		
		$this->topic_conf	=		(!empty($regData['mu_topic_conf'])) ? $regData['mu_topic_conf'] : null;
		$this->type_presentation =	(!empty($regData['mu_type_presentation'])) ? $regData['mu_type_presentation'] : null;
		$this->title_public 	=	(!empty($regData['mu_title_public'])) ? $regData['mu_title_public'] : null;
		$this->abstracts		=	(!empty($regData['mu_abstracts'])) ? $regData['mu_abstracts'] : null;
//-----------------------------------------------------------------------------------------------------------------		
		$this->party 			=	(!empty($regData['mu_party'])) ? $regData['mu_party'] : null;
		$this->training_courses	=	(!empty($regData['mu_training_courses'])) ? $regData['mu_training_courses'] : null;	
		$this->hotel 			=	(!empty($regData['mu_hotel'])) ? $regData['mu_hotel'] : null;
//----------------------------------------------------------------------------------------------------------------- доп. поля для реги выпускников
		$this->last_name_girl	=	(!empty($regData['mu_last_name_girl'])) ? $regData['mu_last_name_girl'] : null;		
		$this->year_vipusk 		=	(!empty($regData['mu_year_vipusk'])) ? $regData['mu_year_vipusk'] : null;
		$this->fak				=	(!empty($regData['mu_fak'])) ? $regData['mu_fak'] : null;	
		$this->group_stud 		=	(!empty($regData['mu_group_stud'])) ? $regData['mu_group_stud'] : null;	
		$this->forma_obuch 		=	(!empty($regData['mu_forma_obuch'])) ? $regData['mu_forma_obuch'] : null;
//----------------------------------------------------------------------------------------------------------------- доп. поля для доп. данных как - адрес,работа, и.т.п.
		$this->town_home		=	(!empty($regData['mu_town_home'])) ? $regData['mu_town_home'] : null;
		$this->adress_home		=	(!empty($regData['mu_adress_home'])) ? $regData['mu_adress_home'] : null;
		$this->work				=	(!empty($regData['mu_work'])) ? $regData['mu_work'] : null;
	}	
	
	public function db($query,$params)
	{		
		//return	$this->conn = new PDO('mysql:host=localhost;dbname=udhtu_conference;charset=UTF-8', 'root', '');	 
		//return	$this->conn = new PDO('mysql:host=127.0.0.1;dbname=udhtu_conference;charset=utf8', 'udhtu_conference', 'ByageejUc3');
		if(!($GetContent)){	
			$GetContent = new GetContent();
		}
		return $GetContent->checkDate($query,$params);
			
		
	}
	

	public function mail()
	{
		//$conn = $this->db();	
		//$row = $conn->query("SELECT mail FROM mu_users WHERE mail='".$this->mail."' LIMIT 1"); 		
		//$result = $row->fetch(PDO::FETCH_ASSOC);
		if((preg_match("|^([a-z0-9_\.\-]{1,30})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|isu", trim($this->mail)))){
			$query	= "mail FROM `mu_users` WHERE mail=? LIMIT 1";
			$result =$this->db($query,$this->mail);	
		}else{
			return $this->error = "error_mail";
		}
		
		if (($this->mail != null) &&  (preg_match("|^([a-z0-9_\.\-]{1,30})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|isu", trim($this->mail))) && (strtolower($this->mail) != strtolower($result['mail']))){				
			return  trim( (htmlspecialchars(strip_tags(strtolower($this->mail)))));		
		}else{
			return $this->error = "error_mail";		
		}		
	}

	public function check_mail()
	{		
		if((preg_match("|^([a-z0-9_\.\-]{1,30})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|isu", trim($this->mail)))){
			$query	= "mail,name,id,password,login FROM `mu_users` WHERE mail=? LIMIT 1";
			$result =$this->db($query,$this->mail);	
		}else{
			return $this->error = "error_mail";
		}		
		if (($this->mail != null) &&  (preg_match("|^([a-z0-9_\.\-]{1,30})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|isu", trim($this->mail))) && (strtolower($this->mail) == strtolower($result['mail']))){				
			return  $result;		
		}else{
			return $this->error = "error_mail";		
		}		
	}
	
	public function login()
	{	
		$conn = $this->db();	
		$row = $conn->query("SELECT login FROM mu_users WHERE login='".$this->login."' LIMIT 1"); 		
		$result = $row->fetch(PDO::FETCH_ASSOC);
		if (($this->login != null) &&
			(preg_match("/^[a-z][a-zA-Z0-9_]{4,16}$/iu",trim($this->login))) && 
			((strtolower(trim(htmlspecialchars(strip_tags($this->login)))) != strtolower($result['login'])))){
			return  trim( (htmlspecialchars(strip_tags(($this->login)))));		
		}else{
			return $this->error = "error_login";		
		}
		$conn = null;
	}
	
	public function password()
	{	
		$this->salt = md5(md5($this->mail).md5(md5($this->name)).$this->login);
		if (($this->password != null) &&
			($this->password2 != null) &&
			($this->password === $this->password2) &&
			//(strlen($this->password)>= 6) && 
			(preg_match("/^[a-zA-Z][a-zA-Z0-9_]{5,16}$/iu",trim($this->password)))){
			return md5(md5(trim( (htmlspecialchars(strip_tags(($this->password)))))).$this->salt);		
		}else{
			return $this->error = "error_password";		
		}		
	}

	public function new_password($id)
	{			
		$query	= "salt FROM `mu_users` WHERE id=? LIMIT 1";		
		$result = $this->db($query,$id);		
		$this->salt = $result['salt'];
		if (($this->password != null) &&
			($this->password2 != null) &&
			($this->password === $this->password2) &&			
			(preg_match("/^[a-zA-Z][a-zA-Z0-9_]{5,16}$/iu",trim($this->password)))){
			return md5(md5(trim( (htmlspecialchars(strip_tags(($this->password)))))).$this->salt);		
		}else{
			return $this->error = "error_password";		
		}		
	}
	
	
	public function name()
	{		
		if (($this->name != null) &&((preg_match("/^([a-zA-Zа-яіїєґА-ЯІЇЄҐ])([a-zа-яіїєґ’-])*([a-zA-Zа-яіїєґА-ЯІЇЄҐ])$/iu", trim($this->name))))) {	
			return  trim((htmlspecialchars(strip_tags($this->name))));		
		}else{
			return $this->error = "error_name";		
		}		
	}

	public function town_home()
	{		
		if (($this->town_home != null) &&((preg_match("/^([a-zA-Zа-яіїєґА-ЯІЇЄҐ])([a-zа-яіїєґ’-])*([a-zA-Zа-яіїєґА-ЯІЇЄҐ])$/iu", trim($this->town_home))))) {	
			return  trim((htmlspecialchars(strip_tags($this->town_home))));		
		}else{
			return $this->error = "error_town_home";		
		}		
	}

	public function fak()
	{		
		if (($this->fak != null) &&((preg_match("/^([a-zA-Zа-яіїєґА-ЯІЇЄҐ])([a-zа-яіїєґ’-])*([a-zA-Zа-яіїєґА-ЯІЇЄҐ])$/iu", trim($this->fak))))) {	
			return  trim((htmlspecialchars(strip_tags($this->fak))));		
		}else{
			return $this->error = "error_fak";		
		}		
	}
	
	public function last_name()
	{	
		if (($this->last_name != null) &&((preg_match("/^([a-zA-Zа-яіїєґА-ЯІЇЄҐ])([a-zа-яіїєґ’-])*([a-zA-Zа-яіїєґА-ЯІЇЄҐ])$/iu", trim($this->last_name))))) {	
			return  trim((htmlspecialchars(strip_tags($this->last_name))));		
		}else{
			return $this->error = "error_last_name";		
		}		
	}

	public function last_name_girl()
	{	
		if (($this->last_name_girl != null) &&((preg_match("/^([a-zA-Zа-яіїєґА-ЯІЇЄҐ])([a-zа-яіїєґ’-])*([a-zA-Zа-яіїєґА-ЯІЇЄҐ])$/iu", trim($this->last_name_girl))))) {	
			return  trim((htmlspecialchars(strip_tags($this->last_name_girl))));		
		}else{
			return $this->error = "error_last_name_girl";		
		}		
	}
	
	public function middle_name()
	{	
		if (($this->middle_name != null) &&((preg_match("/^([a-zA-Zа-яіїєґА-ЯІЇЄҐ])([a-zа-яіїєґ’-])*([a-zA-Zа-яіїєґА-ЯІЇЄҐ])$/iu", trim($this->middle_name))))) {	
			return  trim( (htmlspecialchars(strip_tags($this->middle_name))));		
		}else{
			return $this->error = "error_middle_name";		
		}		
	}
	
	public function topic_conf()
	{	
		if ($this->topic_conf != null) {	
			return (int)trim((htmlspecialchars(strip_tags($this->topic_conf))));			
		}else{
			return $this->error = "error_topic_conf";		
		}		
	}

	public function type_presentation()
	{	
		if ($this->type_presentation != null) {	
			return (int)trim((htmlspecialchars(strip_tags($this->type_presentation))));			
		}else{
			return $this->error = "error_type_presentation";		
		}		
	}
	
	
	public function degree()
	{	
		if ($this->degree != null)  {	
			return (int)trim((htmlspecialchars(strip_tags($this->degree))));			
		}else{
			return $this->error = "error_degree";		
		}		
	}
	
	
	
	public function uch_stepen()
	{	
		if (($this->uch_stepen != null )){	
			return (int)trim((htmlspecialchars(strip_tags($this->uch_stepen))));			
		}else{
			return $this->error = "error_uch_stepen";		
		}		
	}
	

	public function party()
	{	
		if (($this->party != null) && ($this->party != 0) ) {	
			return (int)trim((htmlspecialchars(strip_tags($this->party = 1))));	
		}else{
			return (int)trim((htmlspecialchars(strip_tags($this->party = 0))));		
		}		
	}

	public function sex()
	{	
		if (($this->sex != null) && (($this->sex === "М") || ($this->sex === "Ж"))) {	
			return trim( (htmlspecialchars(strip_tags($this->sex))));	
		}else{
			return $this->error = "error_sex";	
		}		
	}

	public function forma_obuch()
	{	
		if (($this->forma_obuch != null) && (($this->forma_obuch === "D") || ($this->forma_obuch === "Z"))) {	
			return trim( (htmlspecialchars(strip_tags($this->forma_obuch))));	
		}else{
			return $this->error = "error_forma_obuch";	
		}		
	}		

	public function hotel()
	{	
		if (($this->hotel != null) && ($this->hotel != 0) ) {	
			return trim((htmlspecialchars(strip_tags($this->hotel = 1))));	
		}else{
			return trim((htmlspecialchars(strip_tags($this->hotel = 0))));		
		}		
	}

	public function training_courses()
	{	
		if (($this->training_courses != null) && ($this->training_courses != 0) ) {	
			return (int)trim((htmlspecialchars(strip_tags($this->training_courses = 1))));	
		}else{
			return (int)trim((htmlspecialchars(strip_tags($this->training_courses = 0))));		
		}		
	}	


	public function tel()
	{	
		if (($this->tel != null) && (preg_match("/^\+?[0-9]{6,12}$/", trim($this->tel)))) {	
			return  trim( (htmlspecialchars(strip_tags($this->tel))));		
		}else{
			return $this->error = "error_mob_phone";		
		}		
	}

	public function year_vipusk()
	{	
		if (($this->year_vipusk != null) && (preg_match("/^[0-9]$/", trim($this->year_vipusk)))) {	
			return  trim( (htmlspecialchars(strip_tags($this->year_vipusk))));		
		}else{
			return $this->error = "error_year_vipusk";		
		}		
	}
	
		public function captcha()
	{	
		if ($this->captcha == $_SESSION['capch']) {	
			return trim((htmlspecialchars(strip_tags($this->captcha))));		
		}else{
			return $this->error = "error_captcha";		
		}		
	}
	
	public function skype()
	{	
		if (($this->skype == null) || 
			(preg_match("/^[a-z][a-zA-Z0-9]{6,32}$/i",trim($this->skype))) 
			){	
			return  trim((htmlspecialchars(strip_tags($this->skype))));		
		}else{
			return $this->error = "error_skype";	//Если скаип обязателен тогда добавить без него записи не будет	"error_skype"
		}		
	}

	public function group_stud()
	{	
		if (($this->group_stud == null) || 
			(preg_match("/^[a-zA-Zа-яіїєґА-ЯІЇЄҐ0-9]{6,32}$/i",trim($this->group_stud))) 
			){	
			return  trim((htmlspecialchars(strip_tags($this->group_stud))));		
		}else{
			return $this->error = "error_group_stud";	//Если скаип обязателен тогда добавить без него записи не будет	"error_skype"
		}		
	}
	
	public function title_public()
	{	
		if (($this->title_public != null) &&
			(preg_match("/[^<>]{6,350}+$/iu", trim($this->title_public))) 
		){	
			return  (string)trim(htmlspecialchars(strip_tags($this->title_public)));		
		}else{
			return $this->error = "error_title_public";		
		}		
	}

	public function adress_home()
	{	
		if (($this->adress_home != null) &&
			(preg_match("/[^<>]{6,350}+$/iu", trim($this->adress_home))) 
		){	
			return  (string)trim(htmlspecialchars(strip_tags($this->adress_home)));		
		}else{
			return $this->error = "error_adress_home";		
		}		
	}	

	public function work()
	{	
		if (($this->work != null) &&
			(preg_match("/[^<>]{6,350}+$/iu", trim($this->work))) 
		){	
			return  (string)trim(htmlspecialchars(strip_tags($this->work)));		
		}else{
			return $this->error = "error_work";		
		}		
	}	
	
	public function abstracts()
	{	
		if (($this->abstracts != null) &&
			(preg_match("/[^<>]{6,2000}+$/iu",trim($this->abstracts))) 
		){	
			return   (string)trim((htmlspecialchars(strip_tags($this->abstracts))));		
		}else{
			return $this->error = "error_abstracts";		
		}		
	}
	
		public function organization()
	{	
		if (($this->organization != null) && 
			(preg_match("/[^<>]{4,200}+$/iu",trim($this->organization)))
		){	
			return  (string)trim((htmlspecialchars(strip_tags($this->organization))));		
		}else{
			return $this->error = "error_organization";		
		}		
	}
	
	
	public function ip()
	{	
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip=$_SERVER['HTTP_CLIENT_IP'];			
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];			 
		}else{			 
			   $ip=$_SERVER['REMOTE_ADDR'];
		}
			 return $ip;
	}
	

}















?>