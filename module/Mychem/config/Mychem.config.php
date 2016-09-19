<?php
return array(
	'controllers' => array(
		'invokables' => array(			
			'Mychem\Controller\Index'		=> 'Mychem\Controller\IndexController',
			'Mychem\Controller\Conference'	=> 'Mychem\Controller\ConferenceController',
			'Mychem\Controller\Profile'		=> 'Mychem\Controller\ProfileController',
			'Mychem\Controller\Myactiv' 	=> 'Mychem\Controller\MyactivController',
			'Mychem\Controller\Cpanel' 		=> 'Mychem\Controller\CpanelController',
		),
	),
	
	'router' => array(

		'index'  => array(
			
			'index' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/index',					
					'defaults' => array(						
						'controller' => 'Mychem\Controller\Index',
						'action'	 => 'index',
					),
				),
			),

			'section' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/section',				
					'defaults' => array(
						'controller' => 'Mychem\Controller\Index',
						'action'	 => 'section',
					),
				),
			),
			
			
			'subSection' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/subSection',					
					'defaults' => array(						
						'controller' => 'Mychem\Controller\Index',
						'action'	 => 'subSection',
					),
				),
			),
			
	
			
			'content' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/content',					
					'defaults' => array(						
						'controller' => 'Mychem\Controller\Index',
						'action'	 => 'content',
					),
				),
			),

		),

		'profile'  => array(

			'profile' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/profile',					
					'defaults' => array(						
						'controller' => 'Mychem\Controller\Profile',
						'action'	 => 'index',
					),
				),
			),

		),  



		'conference'  => array(

			'index' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/index',					
					'defaults' => array(						
						'controller' => 'Mychem\Controller\Conference',
						'action'	 => 'index',
					),
				),
			),


		),  



		'myactiv'  => array(

			'mylive' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/mylive',					
					'defaults' => array(						
						'controller' => 'Mychem\Controller\Myactiv',
						'action'	 => 'index',
					),
				),
			),



			'activconf' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => '/activconf',					
					'defaults' => array(						
						'controller' => 'Mychem\Controller\Myactiv',
						'action'	 => 'activconf',
					),
				),
			),



		),  



	

	//----
	'cpanel'  => array(

			'index' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => 'index',					
					'defaults' => array(						
						'controller' => 'Mychem\Controller\Cpanel',
						'action'	 => 'index',
					),
				),
			),

			'conf' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => 'conf',					
					'defaults' => array(						
						'controller' => 'Mychem\Controller\Cpanel',
						'action'	 => 'conf',
					),
				),
			),


			'udhtu-block' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => 'udhtu-block',					
					'defaults' => array(						
						'controller' => 'Mychem\Controller\Cpanel',
						'action'	 => 'udhtu_block',
					),
				),
			),


			'udhtu-folder' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => 'udhtu-folder',					
					'defaults' => array(						
						'controller' => 'Mychem\Controller\Cpanel',
						'action'	 => 'udhtu_folder',
					),
				),
			),

			'adminka-udhtu-check-in' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => 'adminka-udhtu-check-in',					
					'defaults' => array(						
						'controller' => 'Mychem\Controller\Cpanel',
						'action'	 => 'adminka_udhtu_check_in',
					),
				),
			),


			'users-admin' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route' 	  => 'users-admin',					
					'defaults' => array(						
						'controller' => 'Mychem\Controller\Cpanel',
						'action'	 => 'users_admin',
					),
				),
			),

		),  


	//---
	
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
			'Mychem/index/index' => __DIR__ . '/../view/Mychem/index/index.phtml',			
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => __DIR__.'/../view',
		
	),
);
	
	
	
	
	
	
	
	
