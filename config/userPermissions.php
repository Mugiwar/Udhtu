<?php

return array(
    'guest' => array( 
					'Front' => array('controller'=>	array(	        	
	        									'Index' 	=>  array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Fakultet' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Kafedra' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Napryam' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
    											'Opros' 	=> array('action'=> array(	        	
			        														'index' =>  'allowAll',													        						
																			),
    																),
	        									'Accession' => array('action'=>	array(	        	
					        														'index' =>  'allowAll',
													        						'logout' =>  'allowAll',
																					'reset' =>  'allowAll',
																					'registration'   =>  'allowAll',
																					'activation'	 =>  'allowAll',
        																			),
	        														),
        										),

							 ),

    ),
    //),

     'user' => array( 
				'Front' => array('controller'=>	array(	        	
	        									'Index' 	=>  array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Fakultet' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Kafedra' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Napryam' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Accession' => array('action'=>	array(	        	
					        														'index' =>  'allowAll',
													        						'logout' =>  'allowAll',
																					'reset' =>  'allowAll',																						
																					'registration'   =>  'allowAll',
																					'activation'	 =>  'allowAll',
        																			),
	        														),
        										),

							 ),


			'Mychem' => array('controller'=>	array(	        	
	        									'Index' 	=> array('action'=> array(	        	
					        													//	'index' =>  'allowAll',													        						
        																			),
	        														),	
	        									'Cpanel' 	=> array('action'=> array(

					        														//'udhtu_folder' =>  'allowAll',
					        														//'udhtu_block' =>  'allowAll',													        						
        																			),
	        														),	         									
	        									'Conference' => array('action'=>	array(	        	
					        													//	'index' =>  'allowAll',													        						
        																			),
	        														),
        										),

							 ),




	
        'controller'	=>	array(
			'Index' =>  'allowAll',
			'Fakultet' =>  'allowAll',
			'Kafedra' =>  'allowAll',
			'Accession' =>  'allowAll',
			'Conference' =>  'allowAll',
            ),  
        'action'	=>	array(
			'index' =>  'denyAll',
			'conference' =>  'allowAll',
			'logout' =>  'allowAll',
			'reset' =>  'allowAll',

            ),   
        'privilege'	=>	array(
			'read' =>  'allow',
			'write' =>  'allow',
			'update' =>  'allow',
			'delete' =>  'allow',
            ),
        'params'	=>	array(
			'index' =>  'allowAll',
			'accession' =>  'allowAll',
			'conference' =>  'allowAll',			
            ),  
    ),

    'test' => array( 		
								'Front' => array('controller'=>	array(	        	
	        									'Index' 	=>  array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Fakultet' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Kafedra' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Napryam' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Accession' => array('action'=>	array(	        	
					        														'index' 		 =>  'allowAll',
													        						'logout'		 =>  'allowAll',
																					'reset' 		 =>  'allowAll',
																					'registration'   =>  'allowAll',
																					'activation'	 =>  'allowAll',
        																			),
	        														),
        										),

							 ),
			'Mychem' => array('controller'=>	array(	        	
	        									'Index' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),	
	        									'Cpanel' 	=> array('action'=> array(
	        																		'index'		=>  'allowAll',	
					        														'udhtu_folder' =>  'allowAll',
					        														'udhtu_block' =>  'allowAll',													        						
        																			),
	        														),	         									
	        									'Conference' => array('action'=>	array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
        										),

							 ),
			'privilege'	=>	array(
				'read' =>  'allow',
				'write' =>  'deny',
				'update' =>  'allow',
				'delete' =>  'deny',
            ),


    ),



    'moderator' => array( 		
								'Front' => array('controller'=>	array(	        	
	        									'Index' 	=>  array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Fakultet' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Kafedra' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Napryam' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Accession' => array('action'=>	array(	        	
					        														'index' =>  'allowAll',
													        						'logout' =>  'allowAll',
																					'reset' =>  'allowAll',
																					'registration'   =>  'allowAll',
																					'activation'	 =>  'allowAll',
        																			),
	        														),
        										),

							 ),
			'Mychem' => array('controller'=>	array(	        	
	        									'Index' 	=> array('action'=> array(	        	
					        													//	'index' =>  'allowAll',													        						
        																			),
	        														),	
	        									'Cpanel' 	=> array('action'=> array(
	        																		//'index'		=>  'allowAll',	
					        														'udhtu_folder' =>  'allowAll',					        																							        						
        																			),
	        														),	         									
	        									'Conference' => array('action'=>	array(	        	
					        														//'index' =>  'allowAll',													        						
        																			),
	        														),
        										),

							 ),
			'privilege'	=>	array(
				'read' =>  'allow',
				'write' =>  'deny',
				'update' =>  'allow',
				'delete' =>  'deny',
            ),


    ),




    'budda' => array( 




			'Front' => array('controller'=>	array(	        	
	        									'Index' 	=>  array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Fakultet' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Kafedra' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Opros' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Napryam' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Accession' => array('action'=>	array(	        	
					        														'index' =>  'allowAll',
													        						'logout' =>  'allowAll',
																					'reset' =>  'allowAll',
																					'registration'   =>  'allowAll',
																					'activation'	 =>  'allowAll',
        																			),
	        														),
        										),

							 ),
			'Mychem' => array('controller'=>	array(	        	
	        									'Index' 	=> array('action'=> array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),	
	        									'Cpanel' 	=> array('action'=> array(
	        																		'index'		=>  'allowAll',	
					        														'udhtu_folder' =>  'allowAll',
					        														'udhtu_block' =>  'allowAll',
					        														'conf'		=>  'allowAll',														        						
        																			),
	        														),	         									
	        									'Conference' => array('action'=>	array(	        	
					        														'index' =>  'allowAll',													        						
        																			),
	        														),
	        									'Profile' => array('action'=>	array(	        	
					        														'index' =>  'allowAll',	
					        														'profile' =>  'allowAll',														        						
        																			),
	        														),
        										),

							 ),


















		'module'	=>	array(
			'Front' =>  'allowAll',
			'Mychem' =>  'allowAll',
            ),   
        'controller'	=>	array(
			'Index' =>  'allowAll',
			'Fakultet' =>  'allowAll',
			'Kafedra' =>  'allowAll',
			'Accession' =>  'allowAll',
			'Conference' =>  'allowAll',
			'Profile' =>  'allowAll',
			'Myactiv' =>  'allowAll',
			'Cpanel' =>  'allowAll',
            ),  
        'action'	=>	array(
			'index' =>  'allowAll',
			'udhtu_folder' =>  'allowAll',
			'udhtu_block' =>  'allowAll',
			'accession' =>  'allowAll',
			'logout' =>  'allowAll',
			'reset' =>  'allowAll',
            ),   
        'privilege'	=>	array(
			'read' =>  'allow',
			'write' =>  'allow',
			'update' =>  'allow',
			'delete' =>  'allow',
            ),
        'params'	=>	array(
			'index' =>  'allowAll',
			'accession' =>  'allowAll',
					
			'see' =>  'allowAll',
            ), 
            
    ),








);
