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
             'user' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/user[/:id]',
                     'constraints' => array(
                         'id'     => '[a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Friend\Controller\Friend',
                         'action'     => 'wall',
                     ),
                 ),
             ),
             'invitations' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/invitations',
                     'constraints' => array(
                     ),
                     'defaults' => array(
                         'controller' => 'Friend\Controller\Friend',
                         'action'     => 'invitations',
                     ),
                 ),
             ),
             'search' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/search',
                     'constraints' => array(
                     ),
                     'defaults' => array(
                         'controller' => 'Friend\Controller\Friend',
                         'action'     => 'search',
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