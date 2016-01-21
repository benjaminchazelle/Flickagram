<?php 

 return array(
     'controllers' => array(
         'invokables' => array(
             'Flick\Controller\Flick' => 'Flick\Controller\FlickController',
         ),
     ),
	 
     'router' => array(
         'routes' => array(
             'flick' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/flick[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Flick\Controller\Flick',
                         'action'     => 'index',
                     ),
                 ),
             ),
             'me' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/me',
                     'constraints' => array(
                     ),
                     'defaults' => array(
                         'controller' => 'Flick\Controller\Flick',
                         'action'     => 'me',
                     ),
                 ),
             ),			 
         ),
     ),

	 
     'view_manager' => array(
         'template_path_stack' => array(
             'flick' => __DIR__ . '/../view',
         ),
     ),
 );
 
 ?>