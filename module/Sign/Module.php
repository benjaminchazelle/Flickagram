<?php 

namespace Sign;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;
 
use Sign\Model\Sign;
use Sign\Model\SignTable;
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
                 'Sign\Model\SignTable' =>  function($sm) {
                     $tableGateway = $sm->get('SignTableGateway');
                     $table = new SignTable($tableGateway);
                     return $table;
                 },
                 'SignTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Sign());
                     return new TableGateway('gm_users', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }

 }
 
 ?>