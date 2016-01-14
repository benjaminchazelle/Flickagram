<?php 

 return array(
     'controllers' => array(
         'invokables' => array(
             'Friend\Controller\Friend' => 'Friend\Controller\FriendController',
         ),
     ),
	 
     'router' => array(
         'routes' => array(
             'friend' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/friend[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Friend\Controller\Friend',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

	 
     'view_manager' => array(
         'template_path_stack' => array(
             'friend' => __DIR__ . '/../view',
         ),
     ),
 );
 
 ?>