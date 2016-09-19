<?php
/*
Конфиг данного модуля с него все идет в роутер  вообшем это разруливатель данного модуля



*/
//Вызываемый контроллер по умолчанию
return array(
	'controllers' => array(
		'invokables' => array(			
			'Front\Controller\Index' => 'Front\Controller\IndexController',			
		),
	),
	
	'router' => array(
		'routes'  => array(

			'index' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/index',				
					'defaults' => array(
						'controller' => 'Front\Controller\Index',
						'action'	 => 'index',
					),
				),
			),

			'about' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/about',				
					'defaults' => array(
						'controller' => 'Front\Controller\Index',
						'action'	 => 'about',
					),
				),
			),			

			'products' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/products',					
					'defaults' => array(						
						'controller' => 'Front\Controller\Index',
						'action'	 => 'products',
					),
				),
			),
			
			'galvanotechnics' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/galvanotechnics',					
					'defaults' => array(						
						'controller' => 'Front\Controller\Index',
						'action'	 => 'galvanotechnics',
					),
				),
			),

			'contacts' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/contacts',					
					'defaults' => array(						
						'controller' => 'Front\Controller\Index',
						'action'	 => 'contacts',
					),
				),
			),



			'fakultet' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/fakultet',					
					'defaults' => array(						
						'controller' => 'Front\Controller\Fakultet',
						'action'	 => 'index',
					),
				),
			),



			'kafedra' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/kafedra',					
					'defaults' => array(						
						'controller' => 'Front\Controller\Kafedra',
						'action'	 => 'index',
					),
				),
			),

			'opros' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/opros',					
					'defaults' => array(						
						'controller' => 'Front\Controller\Opros',
						'action'	 => 'index',
					),
				),
			),

			'napryam' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/napryam',					
					'defaults' => array(						
						'controller' => 'Front\Controller\Napryam',
						'action'	 => 'index',
					),
				),
			),





// Access


			'registration' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/registration',					
					'defaults' => array(						
						'controller' => 'Front\Controller\Accession',
						'action'	 => 'registration',
					),
				),
			),




			'activation' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/activation',					
					'defaults' => array(						
						'controller' => 'Front\Controller\Accession',
						'action'	 => 'activation',
					),
				),
			),





			'login' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/login',					
					'defaults' => array(						
						'controller' => 'Front\Controller\Accession',
						'action'	 => 'index',
					),
				),
			),

			'reset' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/reset',					
					'defaults' => array(						
						'controller' => 'Front\Controller\Accession',
						'action'	 => 'reset',
					),
				),
			),

			'logout' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/logout',					
					'defaults' => array(						
						'controller' => 'Front\Controller\Accession',
						'action'	 => 'logout',
					),
				),
			),


			


		),  

	),
	
	

	
	'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
	
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index', 
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout',  
			'front/index/index' => __DIR__ . '/../view/front/index/index.phtml',		
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => __DIR__.'/../view',	
	),
);
	
	
	
	
	
	
	
	
