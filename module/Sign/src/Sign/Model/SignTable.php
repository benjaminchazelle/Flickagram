<?php 

 namespace Sign\Model;

 use Zend\Db\TableGateway\TableGateway;

 class SignTable
 {
     protected $tableGateway;
	 
	 protected $user_id;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
         $this->user_id = -1;
     }

     public function fetchAll($user_id)
     {
         $resultSet = $this->tableGateway->select("owner = ".$this->user_id);
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

     public function getSign($id)
     {
		// $this->isMine();
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
        /* if (!$row) {
             throw new \Exception("Could not find row $id");
         }*/
         return $row;
     }
	 
     public function getSignByEmail($email)
     {

         $rowset = $this->tableGateway->select(array('email' => $email));
         $row = $rowset->current();
        /* if (!$row) {
             throw new \Exception("Could not find row $id");
         }*/
         return $row;
     }
	 
    public function getSignByNickname($nickname)
     {

         $rowset = $this->tableGateway->select(array('real_name' => $nickname));
         $row = $rowset->current();

         return $row;
     }

     public function saveSign(Sign $sign)
     {
         $data = array(
             'id' => 0,
             'email' => $sign->email,
             'password'  => md5($sign->password),
             'real_name'  => $sign->real_name,
         );

         $id = (int) $sign->id;
         
		 $this->tableGateway->insert($data);
		 

     }


 }
 
 ?>