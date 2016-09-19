<?php 
namespace OPF\Mvc\Controller;
use OPF\Loader\Config;
use OPF\Mvc\Router\Router;
use OPF\Http\Request;
use OPF\Mvc\View\View;

abstract class AbstractController
{

	protected $view; 
	protected $request;
	protected $storageUser = array();


	public function __construct(){
		session_start();
		$this->storageUser = (!empty( $_SESSION['storageUser'])) ? $_SESSION['storageUser'] : false ;
		$this->view = new View();
		$this->request = new Request();
	 }  

	protected function getModule(){
		return  Router::getModule();
		
	 }

	 protected function getUserPermission(){
		return  Config::getUserPermission();
		
	 }

	protected function getAction(){
		return  Router::getAction();
		
	 }

	protected function getController(){
		return  Router::getController();
		
	 }

	protected function getParams(){
		return  Router::getParams();
		
	 }

	protected function goToDir($dir){
		header("Location: ".$_SERVER['SERVER_NAME'].'/'.$dir);
		exit();		
	 }

	protected function goToUrl($url){
		header("Location: ".$url);
		exit();		
		
	 }	 	 

}