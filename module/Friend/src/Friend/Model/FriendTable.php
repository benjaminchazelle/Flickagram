<?php 

 namespace Friend\Model;

 use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Where;
// use Zend\Db\Sql;
// use Zend\Db\Sql\Join;

 class FriendTable
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
	 var_dump($id);
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
	 
	 public function searchByNickname($name) {
		 /*
SELECT id, nickname, MAX(state) 'friendship' FROM fg_users u
LEFT JOIN fg_friends f ON u.id = f.user_one OR u.id = f.user_two
WHERE UCASE(nickname) LIKE "%LI%"
GROUP BY u.id*/

		$select = new Select;

// $subSelect = new Select();
		$select->from(array('u' => 'fg_users'))->columns(array('id', 'nickname'));

		// $select->from(array('u' => 'fg_users'), array('MAX(state)', 'UCASE(nickname)') );
		// $select->columns(array('id' => 'id', 'nickname' => 'nickname', 'friendship' => 'friendship'));
		
		// $select->join(array('f' => 'fg_friends'),	'u.id = f.user_one OR u.id = f.user_two', array(), 'inner');   


		$where = new Where;
		$where->like( new Expression('UCASE(nickname)'), '%'.strtoupper($name).'%' );
		$where->AND->notEqualTo('id', $this->user_id);
		
		$select->where($where);
		
		// $select->group('id');
		 
		$statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
		$resultSet = $statement->execute();	
		
		return $resultSet;
		 
	 }
	 
	 public function setRequest($id) {
		 
			if($id == $this->user_id)
				return true;
		 
			 $user = $this->getUserById($id);
		 
			if(is_array($user)) {
				 
				 if($user["friendship"] == -1) {
					 
					 //insert
				
					$insert = new Insert('fg_friends');
					$newData = array(
					'user_one'=> $this->user_id,
					'user_two'=> $id,
					'state'=> '0'
					);
					$insert->values($newData);
						
					$statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($insert);
					$resultSet = $statement->execute();	
					 
				 }
				 else if(!$user["i_am_adder"] && $user["friendship"] == 0) {
					 
					 //update
				
					$update = new Update('fg_friends');
					$newData = array(
					'state'=> '1'
					);
					$update->set($newData);
					$update->where(array('user_one' => $id, 'user_two' => $this->user_id));
						
					$statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($update);
					$resultSet = $statement->execute();	
					 
				 }
			 
				return true;
				
			}
		 
		 return false;
	 }
	 
     public function getUserById($id)
     {
		 
		$select = new Select;
		$select->from(array('u' => 'fg_users'));

		$select->columns(array('id', 'nickname', 'email'));
		
		$where = new Where;
		$where->equalTo( 'id', $id);

		$select->where($where);

		
		$statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
		$resultSet = $statement->execute()->current();	
		
		if(is_array($resultSet)) {
			
			$select = new Select;
			$select->from(array('f' => 'fg_friends'));
			
			$select->columns(array('*'));
			
			$where = new Where;
			$or = $where->nest();
			$or->equalTo( 'user_one', $this->user_id);
			$or->AND->equalTo( 'user_two', $id);
			$or->unnest();
			
			$_or = $where->OR->nest();
			$_or->equalTo( 'user_one', $id);
			$_or->AND->equalTo( 'user_two', $this->user_id);
			$_or->unnest();
			
			$select->where($where);
			
			$statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
			$resultSet2 = $statement->execute()->current();	
			
			if(is_array($resultSet2)) {
					$resultSet["i_am_adder"] = $this->user_id == $resultSet2["user_one"];
					$resultSet["friendship"] = $resultSet2["state"];
			}
			else {
				$resultSet["friendship"] = -1;				
			}

			
			return $resultSet;
			
		}
		else {
			return null;
		}
		$friends = array();

		foreach ($resultSet as $result) {

			$friend = new \stdClass();
			
			if($result["u1_id"] != $this->user_id) {
				
				$friend->{"id"} = $result["u1_id"];
				$friend->{"nickname"} = $result["u1_nickname"];
				
			}
			else {
				
				$friend->{"id"} = $result["u2_id"];
				$friend->{"nickname"} = $result["u2_nickname"];
				
			}
			
			return $friend;
			
		}

     }
     public function getUserByNickname($nickname)
     {
		 
		$select = new Select;
		$select->from(array('u' => 'fg_users'));

		$select->columns(array('id', 'nickname', 'email'));
		
		$where = new Where;
		$where->equalTo( 'nickname', $nickname);

		$select->where($where);

		
		$statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
		$resultSet = $statement->execute()->current();	
		
		$id = $resultSet["id"];
		
		if(is_array($resultSet)) {
			
			$select = new Select;
			$select->from(array('f' => 'fg_friends'));
			
			$select->columns(array('*'));
			
			$where = new Where;
			$or = $where->nest();
			$or->equalTo( 'user_one', $this->user_id);
			$or->AND->equalTo( 'user_two', $id);
			$or->unnest();
			
			$_or = $where->OR->nest();
			$_or->equalTo( 'user_one', $id);
			$_or->AND->equalTo( 'user_two', $this->user_id);
			$_or->unnest();
			
			$select->where($where);
			
			$statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
			$resultSet2 = $statement->execute()->current();	
			
			if(is_array($resultSet2)) {
					$resultSet["i_am_adder"] = $this->user_id == $resultSet2["user_one"];
					$resultSet["friendship"] = $resultSet2["state"];
			}
			else {
				$resultSet["friendship"] = -1;				
			}

			
			return $resultSet;
			
		}
		else {
			return null;
		}
		$friends = array();

		foreach ($resultSet as $result) {

			$friend = new \stdClass();
			
			if($result["u1_id"] != $this->user_id) {
				
				$friend->{"id"} = $result["u1_id"];
				$friend->{"nickname"} = $result["u1_nickname"];
				
			}
			else {
				
				$friend->{"id"} = $result["u2_id"];
				$friend->{"nickname"} = $result["u2_nickname"];
				
			}
			
			return $friend;
			
		}

     }
	 
     public function getInvitations()
     {
		 
		$select = new Select;
		$select->from(array('f' => 'fg_friends'));

		$select->columns(array('*'));
		
		$where = new Where;
		$or = $where->nest();
		$or->equalTo( 'user_two', $this->user_id );
		$or->unnest();
		$where->AND->equalTo( 'state', 0);
		
		$select->where($where);

		$select->join(array('u1' => 'fg_users'),	'f.user_one = u1.id', array('u1_nickname' => 'nickname', 'u1_id' => 'id'));     
		$select->join(array('u2' => 'fg_users'),	'f.user_two = u2.id', array('u2_nickname' => 'nickname', 'u2_id' => 'id'));     
		
		$statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
		$resultSet = $statement->execute();	
		
		$friends = array();

		foreach ($resultSet as $result) {

			$friend = new \stdClass();
			
			if($result["u1_id"] != $this->user_id) {
				
				$friend->{"id"} = $result["u1_id"];
				$friend->{"nickname"} = $result["u1_nickname"];
				
			}
			else {
				
				$friend->{"id"} = $result["u2_id"];
				$friend->{"nickname"} = $result["u2_nickname"];
				
			}
			
			$friends[] = $friend;
			
		}

         return $friends;
     }

     public function getFriends()
     {
		 
		$select = new Select;
		$select->from(array('f' => 'fg_friends'));

		$select->columns(array('*'));
		
		$where = new Where;
		$or = $where->nest();
		$or->equalTo( 'user_one', $this->user_id);
		$or->OR->equalTo( 'user_two', $this->user_id );
		$or->unnest();
		$where->AND->equalTo( 'state', 1);
		
		$select->where($where);

		$select->join(array('u1' => 'fg_users'),	'f.user_one = u1.id', array('u1_nickname' => 'nickname', 'u1_id' => 'id'));     
		$select->join(array('u2' => 'fg_users'),	'f.user_two = u2.id', array('u2_nickname' => 'nickname', 'u2_id' => 'id'));   

		
		
		$statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
		$resultSet = $statement->execute();	
		
		$friends = array();

		foreach ($resultSet as $result) {

			$friend = new \stdClass();
			
			if($result["u1_id"] != $this->user_id) {
				
				$friend->{"id"} = $result["u1_id"];
				$friend->{"nickname"} = $result["u1_nickname"];
				
			}
			else {
				
				$friend->{"id"} = $result["u2_id"];
				$friend->{"nickname"} = $result["u2_nickname"];
				
			}
			
			$friends[] = $friend;
			
		}

         return $friends;
     }

     public function saveFriend(Friend $friend)
     {
         $data = array(
             'user_one' => $friend->user_one,
             'user_two'  => $friend->user_two,
             'state'  => $friend->state,
         );

		 /*
         $id = (int) $friend->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getFriend($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Friend id does not exist');
             }
         }*/
     }

     public function deleteFriend($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
 
 ?>