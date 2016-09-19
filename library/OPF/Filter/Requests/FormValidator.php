<?php
namespace OPF\Filter\Requests;
//use PDO;
use Exception;
use Mychem\Model\SqlContent;
use OPF\Plugin\GetId3\GetId3Core as GetId3;
use OPF\Filter\Requests\Filter_error;
//use OPF\Plugin\Imagework\Upload; 
class FormValidator{

	public $regData = array();
	public $error = 0;
	private $conn = null;
	public $salt = null;
	private static $SqlContent;
	
	public function __construct(array $regData, array $files = null){			
	/*		foreach($regData as $kay => $value){				
				$this->$kay	= (!empty($regData[$key])) ? $regData[$key] : null;							
			}
	*/
		
		$this->fio		=			(!empty($regData['mu_fio'])) ? $regData['mu_fio'] : null;		
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
		$this->buy_book 			=	(!empty($regData['mu_buy_book'])) ? $regData['mu_buy_book'] : null;
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
//----------------------------------------------------------------------------------------------------------------- проверка на загрузку изображения выявления формата размера и прочих нужных даных и возврат в контроллер
		$this->upload_file		=	is_uploaded_file($files["filename"]["tmp_name"]) ? $files : null;
		$this->ints				=	(!empty($regData['mu_ints'])) ? $regData['mu_ints'] : null;
		$this->status_chb_rb 	=	(!empty($regData['mu_status_chb_rb'])) ? $regData['mu_status_chb_rb'] : null;
		$this->url_title 		=	(!empty($regData['mu_url_title'])) ? $regData['mu_url_title'] : null;
		$this->url 		=	(!empty($regData['mu_url'])) ? $regData['mu_url'] : null;
		$this->language 		=	(!empty($_SESSION['lang'])) ?  $_SESSION['lang'] : null;
		$this->language_lk 		=	(!empty($_SESSION['lang_lk'])) ?  $_SESSION['lang_lk'] : null;
		$this->position 		=	(!empty($regData['position'])) ? $regData['position'] : null;

	}	
	
	private function db($query,$params = NULL)
	{		
		//return	$this->conn = new PDO('mysql:host=localhost;dbname=udhtu_conference;charset=UTF-8', 'root', '');	 
		//return	$this->conn = new PDO('mysql:host=127.0.0.1;dbname=udhtu_conference;charset=utf8', 'udhtu_conference', 'ByageejUc3');
		if(!($SqlContent)){	
			$SqlContent = new SqlContent();
		}		
		return ($params == NULL) ? $SqlContent->goSelect($query) : $SqlContent->checkDate($query,$params);
			
		
	}

	
	private static function SqlContent()
	{		
		
		if(!(self::$SqlContent)){	
		
			self::$SqlContent = new SqlContent();
		}		
		return self::$SqlContent;
			
		
	}



	private static function getError($error){// В случаи ошибки занести ее код или абривиатуру сходную с use OPF\Filter\Requests\Filter_error; для обработки и вівода пользователю
		$Filter_error = new Filter_error();
		$error_files = $Filter_error->isError($error); // Должен заходить массив
		///var_dump($error_files);
		 $response = array(
			"status" => 'error',
			"message" => $error_files[key($error)],
			"error_message" => key($error),
		);	
		unset($Filter_error)		;
		return $response;	
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
			//return $this->error = "error_mail";
			$errors = self::getError(array('error_mail' => 'сбой'));		
			 return 	$errors['error_message'];

		}
		
		if (($this->mail != null) &&  (preg_match("|^([a-z0-9_\.\-]{1,30})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|isu", trim($this->mail))) && (strtolower($this->mail) != strtolower($result['mail']))){				
			return  trim( (htmlspecialchars(strip_tags(strtolower($this->mail)))));		
		}else{
			//return $this->error = "error_mail";		
			$errors = self::getError(array('error_mail' => 'сбой'));		
			 return 	$errors['error_message'];

		}		
	}

	public function check_mail()
	{		
		if((preg_match("|^([a-z0-9_\.\-]{1,30})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|isu", trim($this->mail)))){
			//$query	= "mail,name,id,password,login FROM `mu_users` WHERE mail=? LIMIT 1";
			//$result =$this->db($query,$this->mail);	
			return  trim($this->mail);
		}else{
		//	return $this->error = "error_mail";
			$errors = self::getError(array('error_mail' => 'сбой'));		
			 return 	$errors['error_message'];

		}		
	//	if (($this->mail != null) &&  (preg_match("|^([a-z0-9_\.\-]{1,30})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|isu", trim($this->mail))) && (strtolower($this->mail) == strtolower($result['mail']))){				
	//		return  $result;		
	//	}else{
	//		return $this->error = "error_mail";		
	//	}		
	}
	
	public function login()
	{	
		//$conn = $this->db();	
		//$row = $conn->query("login FROM mu_users WHERE login=? LIMIT 1"); 		
		//$result = $row->fetch(PDO::FETCH_ASSOC);
		if((preg_match("/^[a-z][a-zA-Z0-9_]{4,16}$/iu",trim($this->login)))){
			$query	= "login FROM mu_users WHERE login=? LIMIT 1";
			$result =$this->db($query,$this->login);	
		}else{
			//return $this->error = "error_login";
			$errors = self::getError(array('error_login' => 'сбой'));		
			 return 	$errors['error_message'];
		}
		if (($this->login != null) &&
			(preg_match("/^[a-z][a-zA-Z0-9_]{4,16}$/iu",trim($this->login))) && 
			((strtolower(trim(htmlspecialchars(strip_tags($this->login)))) != strtolower($result['login'])))){
			return  trim( (htmlspecialchars(strip_tags(($this->login)))));		
		}else{
			//return $this->error = "error_login";		
			$errors = self::getError(array('error_login' => 'сбой'));		
			 return 	$errors['error_message'];

		}
		//$conn = null;
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
		//	return $this->error = "error_password";		
			$errors = self::getError(array('error_password' => 'сбой'));		
			 return 	$errors['error_message'];
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
			//return $this->error = "error_password";		
			$errors = self::getError(array('error_password' => 'сбой'));		
			 return 	$errors['error_message'];
		}		
	}
	
	
	public function name()
	{		
		if (($this->name != null) &&((preg_match("/^([a-zA-Zа-яіїєґА-ЯІЇЄҐ])([a-zа-яіїєґ’-])*([a-zA-Zа-яіїєґА-ЯІЇЄҐ])$/iu", trim($this->name))))) {	
			return  trim((htmlspecialchars(strip_tags($this->name))));		
		}else{	
			$errors = self::getError(array('error_name' => 'сбой'));		
			 return 	$errors['error_message'];
		}		
	}

		public function fio()
	{		
		if (($this->fio != null) &&((preg_match("/^[a-zA-Zа-яіїєґА-ЯІЇЄҐ\s]+$/iu", trim($this->fio))))) {	
			return  trim((htmlspecialchars(strip_tags($this->fio))));		
		}else{
			//return $this->error = "error_fio";		
			$errors = self::getError(array('error_fio' => 'сбой'));		
			 return 	$errors['error_message'];
		}		
	}

		public function position()
	{		
		$arr_position = array(	'top' 	=>	'top-menu',
								'right' =>	'right-menu',
								'bottom'=>	'bottom-menu',
								'left' 	=>	'left-menu',
								'center'=>	'center-menu');
		$this->position = array_search($this->position, $arr_position);
		
		if ($this->position != null) {	
			return  trim($this->position);		
		}else{
			//return $this->error = "error_position";		
			$errors = self::getError(array('error_position' => 'сбой'));		
			 return 	$errors['error_message'];
		}		
	}

	public function town_home()
	{		
		if (($this->town_home != null) &&((preg_match("/^([a-zA-Zа-яіїєґА-ЯІЇЄҐ])([a-zа-яіїєґ’-])*([a-zA-Zа-яіїєґА-ЯІЇЄҐ])$/iu", trim($this->town_home))))) {	
			return  trim((htmlspecialchars(strip_tags($this->town_home))));		
		}else{
			//return $this->error = "error_town_home";	
			$errors = self::getError(array('error_town_home' => 'сбой'));		
			 return 	$errors['error_message'];	
		}		
	}

	public function fak()
	{		
		if (($this->fak != null) &&((preg_match("/^([a-zA-Zа-яіїєґА-ЯІЇЄҐ])([a-zа-яіїєґ’-])*([a-zA-Zа-яіїєґА-ЯІЇЄҐ])$/iu", trim($this->fak))))) {	
			return  trim((htmlspecialchars(strip_tags($this->fak))));		
		}else{
			//return $this->error = "error_fak";		
			$errors = self::getError(array('error_fak' => 'сбой'));		
			 return 	$errors['error_message'];
		}		
	}
	
	public function last_name()
	{	
		if (($this->last_name != null) &&((preg_match("/^([a-zA-Zа-яіїєґА-ЯІЇЄҐ])([a-zа-яіїєґ’-])*([a-zA-Zа-яіїєґА-ЯІЇЄҐ])$/iu", trim($this->last_name))))) {	
			return  trim((htmlspecialchars(strip_tags($this->last_name))));		
		}else{
			//return $this->error = "error_last_name";		
			$errors = self::getError(array('error_last_name' => 'сбой'));		
			 return 	$errors['error_message'];
		}		
	}

	public function last_name_girl()
	{	
		if (($this->last_name_girl != null) &&((preg_match("/^([a-zA-Zа-яіїєґА-ЯІЇЄҐ])([a-zа-яіїєґ’-])*([a-zA-Zа-яіїєґА-ЯІЇЄҐ])$/iu", trim($this->last_name_girl))))) {	
			return  trim((htmlspecialchars(strip_tags($this->last_name_girl))));		
		}else{
			//return $this->error = "error_last_name_girl";		
			$errors = self::getError(array('error_last_name_girl' => 'сбой'));		
			 return 	$errors['error_message'];
		}		
	}
	
	public function middle_name()
	{	
		if (($this->middle_name != null) &&((preg_match("/^([a-zA-Zа-яіїєґА-ЯІЇЄҐ])([a-zа-яіїєґ’-])*([a-zA-Zа-яіїєґА-ЯІЇЄҐ])$/iu", trim($this->middle_name))))) {	
			return  trim( (htmlspecialchars(strip_tags($this->middle_name))));		
		}else{
			//return $this->error = "error_middle_name";		
			$errors = self::getError(array('error_middle_name' => 'сбой'));		
			 return 	$errors['error_message'];
		}		
	}
	
	public function topic_conf()
	{	
		if ($this->topic_conf != null) {	
			return (int)trim((htmlspecialchars(strip_tags($this->topic_conf))));			
		}else{
			//return $this->error = "error_topic_conf";		
				$errors = self::getError(array('error_topic_conf' => 'сбой'));		
			 return 	$errors['error_message'];
		}		
	}

	public function type_presentation()
	{	
		if ($this->type_presentation != null) {	
			return (int)trim((htmlspecialchars(strip_tags($this->type_presentation))));			
		}else{
			//return $this->error = "error_type_presentation";	
			$errors = self::getError(array('error_type_presentation' => 'сбой'));		
			 return 	$errors['error_message'];	
		}		
	}
	
	
	public function degree()
	{	
		if ($this->degree != null)  {	
			return (int)trim((htmlspecialchars(strip_tags($this->degree))));			
		}else{
			//return $this->error = "error_degree";		
				$errors = self::getError(array('error_degree' => 'сбой'));		
			 return 	$errors['error_message'];	
		}		
	}
	
	
	
	public function uch_stepen()
	{	
		if (($this->uch_stepen != null )){	
			return (int)trim((htmlspecialchars(strip_tags($this->uch_stepen))));			
		}else{
			//return $this->error = "error_uch_stepen";		
				$errors = self::getError(array('error_uch_stepen' => 'сбой'));		
			 return 	$errors['error_message'];	
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

		public function status_chb_rb()
	{	
		if (($this->status_chb_rb != null) && ($this->status_chb_rb != 0) ) {	
			return (int)trim((htmlspecialchars(strip_tags($this->status_chb_rb = 1))));	
		}else{
			return (int)trim((htmlspecialchars(strip_tags($this->status_chb_rb = 2))));		
		}		
	}

	public function sex()
	{	
		if (($this->sex != null) && (($this->sex === "М") || ($this->sex === "Ж"))) {	
			return trim( (htmlspecialchars(strip_tags($this->sex))));	
		}else{
			//return $this->error = "error_sex";	
						$errors = self::getError(array('error_sex' => 'сбой'));		
			 return 	$errors['error_message'];	
		}		
	}

	public function language()
	{	
		if (($this->language != null) && (($this->language == "1") || ($this->language == "2") || ($this->language == "3"))) {	
			return trim((int)(htmlspecialchars(strip_tags($this->language))));	
		}else{
			//return $this->error = "error_language";	
						$errors = self::getError(array('error_language' => 'сбой'));		
			 return 	$errors['error_message'];	
		}		
	}

		public function language_lk()
	{	
		if (($this->language_lk != null) && (($this->language_lk == "1") || ($this->language_lk == "2") || ($this->language_lk == "3"))) {	
			return trim((int)(htmlspecialchars(strip_tags($this->language_lk))));	
		}else{
			//return $this->error = "error_language";	
				$errors = self::getError(array('error_language' => 'сбой'));		
			 return $errors['error_message'];	
		}		
	}

	public function forma_obuch()
	{	
		if (($this->forma_obuch != null) && (($this->forma_obuch === "D") || ($this->forma_obuch === "Z"))) {	
			return trim( (htmlspecialchars(strip_tags($this->forma_obuch))));	
		}else{
			//return $this->error = "error_forma_obuch";	
				$errors = self::getError(array('error_forma_obuch' => 'сбой'));		
			 return $errors['error_message'];	
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

	public function buy_book()
	{	
		if (($this->buy_book != null) && ($this->buy_book != 0) ) {	
			return trim((htmlspecialchars(strip_tags($this->buy_book = 1))));	
		}else{
			return trim((htmlspecialchars(strip_tags($this->buy_book = 0))));		
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
			//return $this->error = "error_mob_phone";		
			$errors = self::getError(array('error_mob_phone' => 'сбой'));		
			 return $errors['error_message'];
		}		
	}

	public function year_vipusk()
	{	
		if (($this->year_vipusk != null) && (preg_match("/^[0-9]$/", trim($this->year_vipusk)))) {	
			return  trim( (htmlspecialchars(strip_tags($this->year_vipusk))));		
		}else{
		//	return $this->error = "error_year_vipusk";	
				$errors = self::getError(array('error_year_vipusk' => 'сбой'));		
			 return $errors['error_message'];	
		}		
	}
	
		public function captcha()
	{	
		if ($this->captcha == $_SESSION['capch']) {	
			return trim((htmlspecialchars(strip_tags($this->captcha))));		
		}else{
			//return $this->error = "error_captcha";		
				$errors = self::getError(array('error_captcha' => 'сбой'));		
			 return $errors['error_message'];
		}		
	}
	
	public function skype()
	{	
		if (($this->skype == null) || 
			(preg_match("/^[a-z][a-zA-Z0-9_-]{6,32}$/i",trim($this->skype))) 
			){	
			return  trim((htmlspecialchars(strip_tags($this->skype))));		
		}else{
			//return $this->error = "error_skype";	//Если скаип обязателен тогда добавить без него записи не будет	"error_skype"
			$errors = self::getError(array('error_skype' => 'сбой'));		
			 return $errors['error_message'];
		}		
	}

	public function url_title()
	{	
		if (($this->url_title != null) && (preg_match("/^[a-zA-Z0-9_-]+$/iu", trim($this->url_title)))) {	
				
			return  trim((htmlspecialchars(strip_tags($this->url_title))));		
		}else{
			//return $this->error = "error_url_title";	//Если скаип обязателен тогда добавить без него записи не будет	"error_skype"
			$errors = self::getError(array('error_url_title' => 'сбой'));		
			 return $errors['error_message'];
		}		
	}

	public function url()
	{	
		if (($this->url != null)) {					
			return  trim(((strip_tags($this->url))));		
		}else{
			//return $this->error = "error_url";	//Если скаип обязателен тогда добавить без него записи не будет	"error_skype"
			$errors = self::getError(array('error_url' => 'сбой'));		
			 return $errors['error_message'];
		}		
	}

	public function group_stud()
	{	
		if (($this->group_stud == null) || 
			(preg_match("/^[a-zA-Zа-яіїєґА-ЯІЇЄҐ0-9]{6,32}$/i",trim($this->group_stud))) 
			){	
			return  trim((htmlspecialchars(strip_tags($this->group_stud))));		
		}else{
			//return $this->error = "error_group_stud";	//Если скаип обязателен тогда добавить без него записи не будет	"error_skype"
			$errors = self::getError(array('error_group_stud' => 'сбой'));		
			 return $errors['error_message'];
		}		
	}
	
	public function title_public()
	{	
		if (($this->title_public != null) &&
			(preg_match("/[^<>]{6,350}+$/iu", trim($this->title_public))) 
		){	
			return  (string)trim(htmlspecialchars(strip_tags($this->title_public)));		
		}else{
			//return $this->error = "error_title_public";		
			$errors = self::getError(array('error_title_public' => 'сбой'));		
			 return $errors['error_message'];
		}		
	}

	public function adress_home()
	{	
		if (($this->adress_home != null) &&
			(preg_match("/[^<>]{6,350}+$/iu", trim($this->adress_home))) 
		){	
			return  (string)trim(htmlspecialchars(strip_tags($this->adress_home)));		
		}else{
		//	return $this->error = "error_adress_home";		
			$errors = self::getError(array('error_adress_home' => 'сбой'));		
			 return $errors['error_message'];
		}		
	}	

	public function work()
	{	
		if (($this->work != null) &&
			(preg_match("/[^<>]{6,350}+$/iu", trim($this->work))) 
		){	
			return  (string)trim(htmlspecialchars(strip_tags($this->work)));		
		}else{
			//return $this->error = "error_work";		
				$errors = self::getError(array('error_work' => 'сбой'));		
			 return $errors['error_message'];
		}		
	}	
	
	public function abstracts()
	{	
		if (($this->abstracts != null) &&
			(preg_match("/[^<>]{6,2000}+$/iu",trim($this->abstracts))) 
		){	
			return   (string)trim((htmlspecialchars(strip_tags($this->abstracts))));		
		}else{
			//return $this->error = "error_abstracts";		
			$errors = self::getError(array('error_abstracts' => 'сбой'));		
			 return $errors['error_message'];
		}		
	}
	
	public function organization()
	{	
		if (($this->organization != null) && 
			(preg_match("/[^<>]{4,200}+$/iu",trim($this->organization)))
		){	
			return  (string)trim((htmlspecialchars(strip_tags($this->organization))));		
		}else{
			//return $this->error = "error_organization";		
			$errors = self::getError(array('error_organization' => 'сбой'));		
			 return $errors['error_message'];
		}		
	}



	//$this->upload_file		=	(is_uploaded_file($files["filename"]["tmp_name"]) ? $files["filename"]["tmp_name"] : null; // рисвоим номер при несанкционмированой загрузки в дополнение к остальным кодам ошибки функции $_FILES['userfile']['error'] 


	public function upload_file()
	{		
		if(	($this->upload_file != null)&&
			($this->upload_file["filename"]["error"] == 0)){

			$GetId = new GetId3(); 
   			$fileData = $GetId->analyze($this->upload_file["filename"]["tmp_name"]);
			//Проверяем есть ли такое разширение в базе и сколько оно должно весить
			$path_info = pathinfo($this->upload_file["filename"]["name"]);	// - получаем разобраный фал по имени раширению		
			$extension = (preg_match("/^[a-z][a-zA-Z0-9]{2,6}$/iu",trim($path_info['extension']))) ? strtolower(trim($path_info['extension'])) : null; // - отделяем раширение от названия
			switch ($extension){
				case "":
					 return self::getError(array('error_exe_2' => 'сбой'));		// В случаи ошибки занести ее код или абривиатуру сходную с use OPF\Filter\Requests\Filter_error; для обработки и вівода пользователю
					break;
				case null:
					 return self::getError(array('error_exe_1' => 'сбой'));
					break;					
				default:
					$query	= "	mtef.exe,mtef.mu_type_exe,mtef.id,mtef.weight,mte.mu_type_file,mte.id as mte_id
								FROM mu_type_exe_file as mtef
								LEFT JOIN mu_type_exe as mte ON mte.id = mtef.mu_type_exe
								WHERE 
								mtef.exe= ?	
								AND mtef.mu_status = 1 		
							  "; // - сверяем расширение с базой + забереам его размер


					$result_extension = $this->db($query,$extension);
					$result_getid3_extension = $this->db($query,$fileData['fileformat']);
					if(empty($result_extension) &&  empty($result_getid3_extension))
						 return self::getError(array('error_exe' => 'сбой'));						
					break;
		}



		
   		
   			echo "fileformat - ".$fileData['fileformat']."<br>";   			
   			echo "minutes:seconds - ".$fileData['playtime_string']."<br>";
   			echo $this->upload_file['filename']['type'];


   			switch ($fileData['fileformat']) {
   				case 'pdf':
							if (
								(!$fileData['audio']['bitrate'] && !$fileData['playtime_string']) &&
								($this->upload_file["filename"]["size"] < 1024*$result_extension['weight']*1024)				
							){	
							
						//	echo "------------------------- <br> ";



//создание папок из базы на сервере


				$query	= "id FROM mu_type_file";				
				$dok_in_db =  $this->db($query);
				$query	= "id,mu_type_file FROM mu_type_exe";				
				$type_in_db =  $this->db($query);
				



//1 папка доки
				$dir    = './public/usefiles/';				
				$files2 = scandir($dir, SCANDIR_SORT_NONE);
				foreach($dok_in_db as $key1 => $value){
					foreach ($value as $key => $value) {						
						$result55[$key1] = $value;
					}
				}
					
					$result1 = array_diff($result55,$files2);
				if($result1){
					foreach($result1 as $key => $value){
						$dir = './public/usefiles/'.$value;
						if(!is_dir($dir)){
							if (!mkdir($dir, 0755, true)) {
								 return self::getError(array('error_cr_cat_pdf_1' => 'сбой'));
	 		 				}
	 		 			}
					}
				}
			





//2 lvl



				foreach($result55 as $key => $value){
					foreach($type_in_db as $key11 => $value11){							
						if ($value11['mu_type_file'] == $value ) {
							$dir = './public/usefiles/'.$value11['mu_type_file'].DIRECTORY_SEPARATOR.$value11['id'];												
							if(!is_dir($dir)){
								if (!mkdir($dir, 0755, true)) { 		 							
 		 							 return self::getError(array('error_cr_cat_pdf_2' => 'сбой'));
 		 						}
							}
						}
						
					}
				}


				$file_name = explode('.'.$fileData['fileformat'],$this->upload_file["filename"]["name"]);
				$file_name = trim((htmlspecialchars(strip_tags($file_name[0]))));
				$file_hash = md5($this->upload_file["filename"]["tmp_name"].date("Y-m-d H:i:s"));	
				$file_type = $result_extension['mu_type_file'];
				$file_extension = $result_extension['mte_id'];

				$path_file    = './public/usefiles';
				$url = '#';
				$title = $file_name;

				
				$catalog = 1;
				


				$dir = $path_file.DIRECTORY_SEPARATOR.$file_type.DIRECTORY_SEPARATOR.$file_extension;
				//echo "Путь сохранения картинки ".$dir;
			//	var_dump($file_hash);


				if(!is_dir($dir.DIRECTORY_SEPARATOR.$catalog)){	
						if (!mkdir($dir.DIRECTORY_SEPARATOR.$catalog, 0755, true)) {
	 							 return self::getError(array('error_cr_cat_pdf' => 'сбой')); // проверяеться полній путь по котору будет сохраняться файл		 														 
	 						}	 						
					}


				for ($catalog = 1; $catalog <= count(scandir($dir, SCANDIR_SORT_NONE))-2; $catalog++) {
					if(count(scandir($dir.DIRECTORY_SEPARATOR.$catalog, SCANDIR_SORT_NONE)) < 1000){
						if(move_uploaded_file($this->upload_file["filename"]["tmp_name"],$dir.DIRECTORY_SEPARATOR.$catalog.DIRECTORY_SEPARATOR.$file_hash.".".$result_extension['exe'])){
						$SqlContent = new SqlContent();
						$data_insert = array(
						'catalog'				=> $catalog,
						'mu_type_file'			=> $file_type,
						'title' 				=> $title,
					 	'mu_type_exe'			=> $file_extension,
					 	'mu_users' 				=> $_SESSION['storageUser']['id'],
					 	'mu_group_access' 		=> $_SESSION['storageUser']['mga_rg'],					 
						'name_hash' 			=> $file_hash,
						'name' 					=> $file_name,
						'url' 					=> $url,
						'type_shared' 					=> 'group',	
						'mu_type_resolution' 	=> 777,
						'mu_file_status' 		=> 1,										
						);
					//	var_dump($data_insert);
						$done = $SqlContent->goInsert('mu_file',$data_insert);
						if($done){
							$last_Insert_id		= $SqlContent->lastInsertsId();
							$data_insert_log_imtt = array(
												
												"mu_table_using"	=> '11',
												"id_data_using"		=> $last_Insert_id,														
												"mu_users" 			=> $_SESSION['storageUser']['id'],
												"date" 				=> date("Y-m-d H:i:s"),
												"action"			=> 'create',
												
											);
							$mu_block = $SqlContent->goInsert('mu_log_imtt',$data_insert_log_imtt);

						}



							unset($SqlContent);
							break;	
						}else{ 
							die('Не удалось сохранить фаил...');
						}				
					}
					if((count(scandir($dir, SCANDIR_SORT_NONE))-2) == $catalog){
						$catalog+=1;
						if(!is_dir($dir.DIRECTORY_SEPARATOR.$catalog)){	
							if (!mkdir($dir.DIRECTORY_SEPARATOR.$catalog, 0755, true)) {
		 							 die('Не удалось создать директории...'); 		 							 
		 						}	 						
						}
						move_uploaded_file($this->upload_file["filename"]["tmp_name"],$dir.DIRECTORY_SEPARATOR.$catalog.DIRECTORY_SEPARATOR.$file_hash.".".$result_extension['exe']);
						break;					
					}
					
				}

				
























							}



   					break;
   				
   				default:
   					# code...
   					break;
   			}


   			// Аудио
			if (($fileData['audio']['bitrate'] && $fileData['playtime_string'])&&
				($result_getid3_extension['mu_type_file'] == 3 || $result_extension['mu_type_file'] == 3 ) && 
				($this->upload_file["filename"]["size"] < 1024*$result_extension['weight']*1024)){
				echo $fileData['playtime_string'];
				echo "bitrate audio - ".$fileData['audio']['bitrate']."<br>";
				echo "+++++++++++++++++++++ ";
			}

			// Видео
			if (($fileData['video']['bitrate'] && $fileData['playtime_string'])&&
				($result_getid3_extension['mu_type_file'] == 4 || $result_extension['mu_type_file'] == 4 ) && 
				($this->upload_file["filename"]["size"] < 1024*$result_extension['weight']*1024)){
				echo $fileData['playtime_string'];
				echo "bitrate video - ".$fileData['video']['bitrate']."<br>";
				echo "+++++++++++++++++++++ ";
			}




			// Картинки
			if ((getimagesize($this->upload_file['filename']['tmp_name'])) &&
				(!$fileData['audio']['bitrate'] && !$fileData['playtime_string']) &&
				($result_extension['mu_type_exe'] == $result_getid3_extension['mu_type_exe']) && 
				($result_getid3_extension['mu_type_file'] == 1) && 
				($result_extension['mu_type_file'] == 1) && 
				($this->upload_file["filename"]["size"] < 1024*$result_extension['weight']*1024)				
			){	
				
			//	echo "------------------------- <br> ";






//создание папок из базы на сервере


				$query	= "id FROM mu_type_file";				
				$dok_in_db =  $this->db($query);
				$query	= "id,mu_type_file FROM mu_type_exe";				
				$type_in_db =  $this->db($query);
				$query	= "id,height FROM mu_type_resolution";				
				$resolution_in_db =  $this->db($query);
				//var_dump($type_in_db);	



//1 папка доки
				$dir    = './public/usefiles/';				
				$files2 = scandir($dir, SCANDIR_SORT_NONE);
				foreach($dok_in_db as $key1 => $value){
					foreach ($value as $key => $value) {						
						$result55[$key1] = $value;
					}
				}
					
					$result1 = array_diff($result55,$files2);
				if($result1){
					foreach($result1 as $key => $value){
						$dir = './public/usefiles/'.$value;
						if(!is_dir($dir)){
							if (!mkdir($dir, 0755, true)) {
	 		 					die('Не удалось создать директории...');
	 		 				}
	 		 			}
					}
				}
			





//2 lvl



				foreach($result55 as $key => $value){
					foreach($type_in_db as $key11 => $value11){							
						if ($value11['mu_type_file'] == $value ) {
							$dir = './public/usefiles/'.$value11['mu_type_file'].DIRECTORY_SEPARATOR.$value11['id'];												
							if(!is_dir($dir)){
								if (!mkdir($dir, 0755, true)) {
 		 							 die('Не удалось создать директории...');
 		 						}
							}
						}
						
					}
				}


// -------------3 lvl



								foreach($result55 as $key => $value){
					foreach($type_in_db as $key11 => $value11){		
						if ($value11['mu_type_file'] == 1 ) {
							foreach($resolution_in_db as $key22 => $value22){		
								$dir = './public/usefiles/1/'.$value11['id'].DIRECTORY_SEPARATOR.$value22['id'];						
								if(!is_dir($dir) && $value22['height'] != 0){	
									if (!mkdir($dir, 0755, true)) {
	 		 							 die('Не удалось создать директории...'); 		 							 
	 		 						}
								}
							}
						}
						
					}
				}


//$dir    = './public/usefiles/';				
				//$files42 = scandir($dir, SCANDIR_SORT_NONE); подсчет фаилов в папке

//var_dump(count($files42));
//var_dump($files2);
$reso = getimagesize($this->upload_file['filename']['tmp_name']);
//var_dump($reso[1]);
//$path_file    = './public/usefiles/';
//$files2 = scandir($dir, SCANDIR_SORT_NONE);

/*
switch ($reso[0]) { //width
	case 1200:
		$resolut = 1; // big
		break;
	case 500:
		$resolut = 2; // small
		break;	
	case 300:
		$resolut = 3; // small
		break;

	default:
		 return self::getError(array('error_resolution' => 'сбой'));	// В случаи ошибки занести ее код или абривиатуру сходную с use OPF\Filter\Requests\Filter_error; для обработки и вівода пользователю
		break;
}

*/
if ($reso[0] < 4000) {
	$resolut = 4; // оригинал
}else{
	 return self::getError(array('error_resolution' => 'сбой'));
}


				$file_name = explode('.'.$result_extension['exe'],$this->upload_file["filename"]["name"]);
				$file_name = trim((htmlspecialchars(strip_tags($file_name[0]))));
				$file_hash = md5($this->upload_file["filename"]["tmp_name"].date("Y-m-d H:i:s"));	
				$file_type = $result_extension['mu_type_file'];
				$file_extension = $result_extension['mte_id'];

				$path_file    = './public/usefiles';
				$url = '#';
				$title =  (string)trim(htmlspecialchars(strip_tags($_POST['upd_title'])));

				
				$catalog = 1;
				
				// Получение пути по которому будет сохранен файл
				$dir_without_dot ='/public/usefiles'.DIRECTORY_SEPARATOR.$file_type.DIRECTORY_SEPARATOR.$file_extension.DIRECTORY_SEPARATOR.$resolut;
				$dir = $path_file.DIRECTORY_SEPARATOR.$file_type.DIRECTORY_SEPARATOR.$file_extension.DIRECTORY_SEPARATOR.$resolut;					
				// Проверка пути по которому будет сохранен файл
				if(!is_dir($dir.DIRECTORY_SEPARATOR.$catalog)){	
					if (!mkdir($dir.DIRECTORY_SEPARATOR.$catalog, 0755, true)) {
 							 die('Не удалось создать директории...'); 		 							 
 						}	 						
				}

				//Проверка заполненности 1 каталога , в случаии наполнение 1000-2 файла то создается 2 каталог 
				for ($catalog = 1; $catalog <= count(scandir($dir, SCANDIR_SORT_NONE))-2; $catalog++) {
					if(count(scandir($dir.DIRECTORY_SEPARATOR.$catalog, SCANDIR_SORT_NONE)) < 1000){
						//Если файлов меньше 1000 - 2 то перемешаем сюда файл и делаем запись в базе
						if(move_uploaded_file($this->upload_file["filename"]["tmp_name"],$dir.DIRECTORY_SEPARATOR.$catalog.DIRECTORY_SEPARATOR.$file_hash.".".$result_extension['exe'])){
							//Запуск транзакции
							self::SqlContent()->goTrans();
							try { 
		  						
								$data_insert = array(
								'catalog'				=> $catalog,
								'mu_type_file'			=> $file_type,
								'title' 				=> $title,
							 	'mu_type_exe'			=> $file_extension,
							 	'mu_users' 				=> $_SESSION['storageUser']['id'],
							 	'mu_group_access' 		=> $_SESSION['storageUser']['mga_rg'],							 
								'name_hash' 			=> $file_hash,
								'name' 					=> $file_name,
								'type_shared' 			=> 'group',
								'url' 					=> $url,	
								'mu_type_resolution' 	=> $resolut,
								'mu_file_status' 		=> 1,										
								);					
								if(!self::SqlContent()->goInsert('mu_file',$data_insert))
									throw new Exception();				
								$last_Insert_id		=  self::SqlContent()->lastInsertsId();
								$data_insert_log_imtt = array(
													
													"mu_table_using"	=> '11',
													"id_data_using"		=> $last_Insert_id,														
													"mu_users" 			=> $_SESSION['storageUser']['id'],
													"date" 				=> date("Y-m-d H:i:s"),
													"action"			=> 'create',
													
								);
								//Запись в таблицу логов
								if(!self::SqlContent()->goInsert('mu_log_imtt',$data_insert_log_imtt))									  
        							throw new Exception();

								 $response = array(
									"status" => 'success',
									"url" => $dir_without_dot.DIRECTORY_SEPARATOR.$catalog.DIRECTORY_SEPARATOR.$file_hash.".".$result_extension['exe'],
									"width" => $reso[0], // width
									"height" => $reso[1],//height
									"title" => $title,//title для обрезка
									"file_name" => $file_name,//перенемает имя родителя
									"file_hash" => $file_hash//перенемает хеш-имя родителя	
								 );
								 //Запись в случае отсутсвия ошибок
							    self::SqlContent()->goCommit();
							    //В случае ошибки откат и вывод ошибки
							} catch (Exception $e) {
								 self::SqlContent()->goRoll();								 
									unlink($dir.DIRECTORY_SEPARATOR.$catalog.DIRECTORY_SEPARATOR.$file_hash.".".$result_extension['exe']);								
								  return self::getError(array('error_trans' => $e->getMessage()));
							}							
							break;	
						}else{ 							
							  return self::getError(array('error_cant_save_file_img' => 'сбой'));						
						}				
					}
					if((count(scandir($dir, SCANDIR_SORT_NONE))-2) == $catalog){
						$catalog+=1;
						if(!is_dir($dir.DIRECTORY_SEPARATOR.$catalog)){	
							if (!mkdir($dir.DIRECTORY_SEPARATOR.$catalog, 0755, true)) {
		 							 die('Не удалось создать директории...'); 		 							 
		 						}	 						
						}
						move_uploaded_file($this->upload_file["filename"]["tmp_name"],$dir.DIRECTORY_SEPARATOR.$catalog.DIRECTORY_SEPARATOR.$file_hash.".".$result_extension['exe']);
						break;					
					}
					
				}

				














	 			//$path_directory = "./public/usefiles/";  // Если файл загружен успешно, перемещаем его из временной директории в конечную   
	     		//move_uploaded_file($this->upload_file["filename"]["tmp_name"],$path_directory.$_FILES["filename"]["name"]);
	      		//move_uploaded_file($this->upload_file["filename"]["tmp_name"],$path_directory.$file_name.'.jpg');







				return $this->upload_file =  $response;		
			}else{
				return $this->error = $this->upload_file["filename"]["error"];		
			}	







			}else{
				return $this->error = "error_upload_file";	
			}



	
	}










public function img_crop()
	{	



$imgUrl = $_POST['imgUrl'];
$imgUrl = '.'.$imgUrl;
// original sizes
$imgInitW = $_POST['imgInitW'];
$imgInitH = $_POST['imgInitH'];
// resized sizes
$imgW = $_POST['imgW'];
$imgH = $_POST['imgH'];
// offsets
$imgY1 = $_POST['imgY1'];
$imgX1 = $_POST['imgX1'];
// crop box
$cropW = $_POST['cropW'];
$cropH = $_POST['cropH'];
// rotation angle
$angle = $_POST['rotation'];

$jpeg_quality = 100;

//$output_filename = "/public/usefiles/croppedImg_".rand();

if(($cropW > 495) && ($cropW < 505)  ){
	$resolut = 2; // small
$cropW = 500;
$cropH = 375;
}


if(($cropW > 295) && ($cropW < 305)  ){
	$resolut = 3; // small
	$cropW = 300;
	$cropH = 400;

}


if(($cropW > 1195) && ($cropW < 1205)  ){
	$resolut = 3; // small
	$cropW = 1200;
	$cropH = 900;
}

if (empty($resolut)) {
	 return self::getError(array('error_resolution' => 'сбой'));
}


		if(	is_writable($imgUrl))
			{

			$GetId = new GetId3(); 
   			$fileData = $GetId->analyze($imgUrl);
			//Проверяем есть ли такое разширение в базе и сколько оно должно весить
			$path_info = pathinfo($imgUrl);	// - получаем разобраный фал по имени раширению		
			$extension = (preg_match("/^[a-z][a-zA-Z0-9]{2,6}$/iu",trim($path_info['extension']))) ? strtolower(trim($path_info['extension'])) : null; // - отделяем раширение от названия
			switch ($extension){
				case "":
					 return self::getError(array('error_exe_2' => 'сбой'));		// В случаи ошибки занести ее код или абривиатуру сходную с use OPF\Filter\Requests\Filter_error; для обработки и вівода пользователю
					break;
				case null:
					 return self::getError(array('error_exe_1' => 'сбой'));
					break;					
				default:
					$query	= "	mtef.exe,mtef.mu_type_exe,mtef.id,mtef.weight,mte.mu_type_file,mte.id as mte_id
								FROM mu_type_exe_file as mtef
								LEFT JOIN mu_type_exe as mte ON mte.id = mtef.mu_type_exe
								WHERE exe=?			
							  "; // - сверяем расширение с базой + забереам его размер


					$result_extension = $this->db($query,$extension);
					$result_getid3_extension = $this->db($query,$fileData['fileformat']);
					if(empty($result_extension) &&  empty($result_getid3_extension))
						 return self::getError(array('error_exe' => 'сбой'));						
					break;
		}







			// Картинки
			if (getimagesize($imgUrl) &&
				(!$fileData['audio']['bitrate'] && !$fileData['playtime_string']) &&
				($result_extension['mu_type_exe'] == $result_getid3_extension['mu_type_exe']) && 
				($result_getid3_extension['mu_type_file'] == 1) && 
				($result_extension['mu_type_file'] == 1) //&& 
				//( filesize($imgUrl) < 1024*$result_extension['weight']*1024)				
			){	
				
			//	echo "------------------------- <br> ";









//создание папок из базы на сервере


				$query	= "id FROM mu_type_file";				
				$dok_in_db =  $this->db($query);
				$query	= "id,mu_type_file FROM mu_type_exe";				
				$type_in_db =  $this->db($query);
				$query	= "id,height FROM mu_type_resolution";				
				$resolution_in_db =  $this->db($query);
				//var_dump($type_in_db);	



//1 папка доки
				$dir    = './public/usefiles/';				
				$files2 = scandir($dir, SCANDIR_SORT_NONE);
				foreach($dok_in_db as $key1 => $value){
					foreach ($value as $key => $value) {						
						$result55[$key1] = $value;
					}
				}
					
					$result1 = array_diff($result55,$files2);
				if($result1){
					foreach($result1 as $key => $value){
						$dir = './public/usefiles/'.$value;
						if(!is_dir($dir)){
							if (!mkdir($dir, 0755, true)) {
	 		 					die('Не удалось создать директории...');
	 		 				}
	 		 			}
					}
				}
			





//2 lvl



				foreach($result55 as $key => $value){
					foreach($type_in_db as $key11 => $value11){							
						if ($value11['mu_type_file'] == $value ) {
							$dir = './public/usefiles/'.$value11['mu_type_file'].DIRECTORY_SEPARATOR.$value11['id'];												
							if(!is_dir($dir)){
								if (!mkdir($dir, 0755, true)) {
 		 							 die('Не удалось создать директории...');
 		 						}
							}
						}
						
					}
				}


// -------------3 lvl



								foreach($result55 as $key => $value){
					foreach($type_in_db as $key11 => $value11){		
						if ($value11['mu_type_file'] == 1 ) {
							foreach($resolution_in_db as $key22 => $value22){		
								$dir = './public/usefiles/1/'.$value11['id'].DIRECTORY_SEPARATOR.$value22['id'];						
								if(!is_dir($dir) && $value22['height'] != 0){	
									if (!mkdir($dir, 0755, true)) {
	 		 							 die('Не удалось создать директории...'); 		 							 
	 		 						}
								}
							}
						}
						
					}
				}




switch($result_extension['exe'])
{
    case 'png':
        $img_r = imagecreatefrompng($imgUrl);
		$source_image = imagecreatefrompng($imgUrl);		
        break;
    case 'jpeg':
        $img_r = imagecreatefromjpeg($imgUrl);
		$source_image = imagecreatefromjpeg($imgUrl);	
        break;
    case 'jpg':
        $img_r = imagecreatefromjpeg($imgUrl);
		$source_image = imagecreatefromjpeg($imgUrl);	
        break;
    case 'gif':
        $img_r = imagecreatefromgif($imgUrl);
		$source_image = imagecreatefromgif($imgUrl);		
        break;    
}







    // resize the original image to size of editor
    $resizedImage = imagecreatetruecolor($imgW, $imgH);
	imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);	
    // rotate the rezized image
    $rotated_image = imagerotate($resizedImage, -$angle, 0);
    // find new width & height of rotated image
    $rotated_width = imagesx($rotated_image);
    $rotated_height = imagesy($rotated_image);
    // diff between rotated & original sizes
    $dx = $rotated_width - $imgW;
    $dy = $rotated_height - $imgH;
    // crop rotated image to fit into original rezized rectangle
	$cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
	imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
	imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
	// crop image into selected area
	$final_image = imagecreatetruecolor($cropW, $cropH);
	imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
	imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
	// finally output png image
	//imagepng($final_image, '.'.$output_filename.$type, $png_quality);
	















//$reso = getimagesize($final_image);
//$resolut = 2;
/*
switch (intval($cropW)) { //width
	case 1200:
		$resolut = 1; // big
		break;
	case 500:
		$resolut = 2; // small
		break;	
	case 300:
		$resolut = 3; // small
		break;

	default:
		 return self::getError(array('error_resolution' => 'сбой'));	// В случаи ошибки занести ее код или абривиатуру сходную с use OPF\Filter\Requests\Filter_error; для обработки и вівода пользователю
		break;
}


if ($reso[0] < 4000) {
	$resolut = 4; // оригинал
}else{
	 return self::getError(array('error_resolution' => 'сбой'));
}
*/








				$file_name  = $_POST['file_name'];
				$file_hash = $_POST['file_hash'];	
				$file_type = $result_extension['mu_type_file'];
				$file_extension = $result_extension['mte_id'];

				$path_file    = './public/usefiles';
				$url = '#';
				$title = $_POST['title'];

				
				$catalog = 1;
				
				// Получение пути по которому будет сохранен файл
				$dir_without_dot ='/public/usefiles'.DIRECTORY_SEPARATOR.$file_type.DIRECTORY_SEPARATOR.$file_extension.DIRECTORY_SEPARATOR.$resolut;
				$dir = $path_file.DIRECTORY_SEPARATOR.$file_type.DIRECTORY_SEPARATOR.$file_extension.DIRECTORY_SEPARATOR.$resolut;					
				// Проверка пути по которому будет сохранен файл
				if(!is_dir($dir.DIRECTORY_SEPARATOR.$catalog)){	
					if (!mkdir($dir.DIRECTORY_SEPARATOR.$catalog, 0755, true)) {
 							 die('Не удалось создать директории...'); 		 							 
 						}	 						
				}

				//Проверка заполненности 1 каталога , в случаии наполнение 1000-2 файла то создается 2 каталог 
				for ($catalog = 1; $catalog <= count(scandir($dir, SCANDIR_SORT_NONE))-2; $catalog++) {
					if(count(scandir($dir.DIRECTORY_SEPARATOR.$catalog, SCANDIR_SORT_NONE)) < 1000){
						//Если файлов меньше 1000 - 2 то перемешаем сюда файл и делаем запись в базе
						if(imagejpeg($final_image, $dir.DIRECTORY_SEPARATOR.$catalog.DIRECTORY_SEPARATOR.$file_hash.".".$result_extension['exe'], $jpeg_quality)){						
							//Запуск транзакции
							self::SqlContent()->goTrans();
							try { 
		  						
								$data_insert = array(
								'catalog'				=> $catalog,
								'mu_type_file'			=> $file_type,
								'title' 				=> $title,
							 	'mu_type_exe'			=> $file_extension,
							 	'mu_users' 				=> $_SESSION['storageUser']['id'],
							 	'mu_group_access' 		=> $_SESSION['storageUser']['mga_rg'],							 	
								'name_hash' 			=> $file_hash,
								'name' 					=> $file_name,
								'type_shared' 			=> 'group',
								'url' 					=> $url,	
								'mu_type_resolution' 	=> $resolut,
								'mu_file_status' 		=> 1,										
								);					
								if(!self::SqlContent()->goInsert('mu_file',$data_insert))
									throw new Exception();				
								$last_Insert_id		=  self::SqlContent()->lastInsertsId();
								$data_insert_log_imtt = array(
													
													"mu_table_using"	=> '11',
													"id_data_using"		=> $last_Insert_id,														
													"mu_users" 			=> $_SESSION['storageUser']['id'],
													"date" 				=> date("Y-m-d H:i:s"),
													"action"			=> 'create',
													
								);
								//Запись в таблицу логов
								if(!self::SqlContent()->goInsert('mu_log_imtt',$data_insert_log_imtt))									  
        							throw new Exception();;

								 $response = array(
									"status" => 'success',
									"url" => $dir_without_dot.DIRECTORY_SEPARATOR.$catalog.DIRECTORY_SEPARATOR.$file_hash.".".$result_extension['exe'],									
								 );
								 //Запись в случае отсутсвия ошибок
							    self::SqlContent()->goCommit();
							    //В случае ошибки откат и вывод ошибки
							} catch (Exception $e) {
								 self::SqlContent()->goRoll();								 
									unlink($dir.DIRECTORY_SEPARATOR.$catalog.DIRECTORY_SEPARATOR.$file_hash.".".$result_extension['exe']);								
								  return self::getError(array('error_trans' => $e->getMessage()));
							}							
							break;	
						}else{ 							
							  return self::getError(array('error_cant_save_file_img' => 'сбой'));						
						}				
					}
					if((count(scandir($dir, SCANDIR_SORT_NONE))-2) == $catalog){
						$catalog+=1;
						if(!is_dir($dir.DIRECTORY_SEPARATOR.$catalog)){	
							if (!mkdir($dir.DIRECTORY_SEPARATOR.$catalog, 0755, true)) {
		 							 die('Не удалось создать директории...'); 		 							 
		 						}	 						
						}
						move_uploaded_file($this->upload_file["filename"]["tmp_name"],$dir.DIRECTORY_SEPARATOR.$catalog.DIRECTORY_SEPARATOR.$file_hash.".".$result_extension['exe']);
						break;					
					}
					
				}

				














	 			//$path_directory = "./public/usefiles/";  // Если файл загружен успешно, перемещаем его из временной директории в конечную   
	     		//move_uploaded_file($this->upload_file["filename"]["tmp_name"],$path_directory.$_FILES["filename"]["name"]);
	      		//move_uploaded_file($this->upload_file["filename"]["tmp_name"],$path_directory.$file_name.'.jpg');







				return $this->upload_file =  $response;		
			}else{
				return $this->error = $this->upload_file["filename"]["error"];		
			}	







			}else{
				return $this->error = "error_upload_file";	
			}



	
	}






















	
	public function ints()
	{	
		if ($this->ints != null)  {	
			return (int)trim((htmlspecialchars(strip_tags($this->ints))));			
		}else{
			//return $this->error = "error_ints";		
			$errors = self::getError(array('error_ints' => 'сбой'));		
			 return $errors['error_message'];
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