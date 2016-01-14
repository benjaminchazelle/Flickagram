<?php 

namespace Friend;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;
 
use Friend\Model\Friend;
use Friend\Model\FriendTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Restaurant\Model\Restaurant;
use Restaurant\Model\RestaurantTable;


 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
     public function getAutoloaderConfig()
     {
         return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }
	 
     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Friend\Model\FriendTable' =>  function($sm) {
                     $tableGateway = $sm->get('FriendTableGateway');
                     $table = new FriendTable($tableGateway);
                     return $table;
                 },
                 'FriendTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Friend());
                     return new TableGateway('gm_friends', $dbAdapter, null, $resultSetPrototype);
                 },
				 
                 'Restaurant\Model\RestaurantTable' =>  function($sm) {
                     $tableGateway = $sm->get('RestaurantTableGateway');
                     $table = new RestaurantTable($tableGateway);
                     return $table;
                 },
                 'RestaurantTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Restaurant());
                     return new TableGateway('gm_restaurants', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }

 }
 
 ?>