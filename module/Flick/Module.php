<?php 

namespace Flick;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;
 
use Flick\Model\Flick;
use Flick\Model\FlickTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


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
                 'Flick\Model\FlickTable' =>  function($sm) {
                     $tableGateway = $sm->get('FlickTableGateway');
                     $table = new FlickTable($tableGateway);
                     return $table;
                 },
                 'FlickTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Flick());
                     return new TableGateway('fg_flicks', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Friend\Model\FriendTable' =>  function($sm) {
                     $tableGateway = $sm->get('FriendTableGateway');
                     $table = new FriendTable($tableGateway);
                     return $table;
                 },
                 'FriendTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Friend());
                     return new TableGateway('fg_friends', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }

 }
 
 ?>