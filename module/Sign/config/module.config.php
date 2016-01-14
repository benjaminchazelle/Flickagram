<?php 

 return array(
     'controllers' => array(
         'invokables' => array(
             'Sign\Controller\Sign' => 'Sign\Controller\SignController',
         ),
     ),
	 
     'router' => array(
         'routes' => array(
             'sign' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/sign[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Sign\Controller\Sign',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

	 
     'view_manager' => array(
         'template_path_stack' => array(
             'sign' => __DIR__ . '/../view',
         ),
     ),
 );
 
 ?>