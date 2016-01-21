<?php 

 namespace Restaurant\Model;

 use Zend\Db\TableGateway\TableGateway;

 class RestaurantTable
 {
     protected $tableGateway;
	 
	 protected $user_id;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
         $this->user_id = -1;
     }

     public function fetchAll($id)
     {
         $resultSet = $this->tableGateway->select("owner = ".$id);
         return $resultSet;
     }
	 
	 public function __setUser($uid) {
		 $this->user_id = $uid;
	 }
	 /*
	 public function isMine($user_id, $resaurant_id) {
         $resultSet = $this->tableGateway->select("owner = ".$user_id);
		var_dump($resultSet);
	 }*/

     public function getRestaurant($id)
     {
		// $this->isMine();
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id, 'owner' => $this->user_id));
         $row = $rowset->current();
        /* if (!$row) {
             throw new \Exception("Could not find row $id");
         }*/
         return $row;
     }

     public function saveRestaurant(Restaurant $restaurant)
     {
         $data = array(
             'address' => $restaurant->address,
             'name'  => $restaurant->name,
             'fileupload'  => $restaurant->fileupload,
             'comment'  => $restaurant->comment,
             'mark'  => $restaurant->mark,
             'owner'  => $this->user_id,
         );

         $id = (int) $restaurant->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getRestaurant($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Restaurant id does not exist');
             }
         }
     }

     public function deleteRestaurant($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
 
 ?>