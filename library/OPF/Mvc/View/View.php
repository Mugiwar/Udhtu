<?php
/*
View - вызывается в абстракт контроллере в последствии чего есть во всех контроллерах  наследующих
AbstractController. Сюда передается конфиг модуля в котором содержатся пути к Шаблонам данного модуля которому принадлежит
конфиг, а так же из контроллера передается массив который разбивается на Ключь-Переменная Значение - данные и передается 
нужному Виду



*/
namespace OPF\Mvc\View;
use OPF\Loader\Config;
use OPF\Mvc\Router\Router;
class View{
  
    // получить отренедеренный шаблон с параметрами $params
    function fetchPartial($layout,$template, $params = array()){     
        extract($params);
        ob_start();       
            if ($layout != null) {
                 include Router::$_template_map['layout/layout'].DIRECTORY_SEPARATOR.$layout.'.phtml';
            }else{ 
                 include Router::$_view_manager['template_path_stack'].DIRECTORY_SEPARATOR.Router::getModule().DIRECTORY_SEPARATOR.Router::getController().DIRECTORY_SEPARATOR.$template.'.phtml';
            }
        return ob_get_clean();
    }
 
    // вывести отренедеренный шаблон с параметрами $params
    function renderPartial($template, $params = array()){
            $this->fetchPartial($template, $params);
    }
 
    // получить отренедеренный в переменную $content layout-а
    // шаблон с параметрами $params
    function fetch($layout,$template, $params = array()){
        $content = $this->fetchPartial(NULL,$template, $params);
        return $this->fetchPartial($layout,NULL, array('content' => $content));
    }
 
    // вывести отренедеренный в переменную $content layout-а
    // шаблон с параметрами $params    
    function render($template, $params = array(),$layout = "layout"){
        echo $this->fetch($layout,$template, $params);
    }


        public function getLayout(){


        }

        public function getTemplate(){

            
        }

       









}