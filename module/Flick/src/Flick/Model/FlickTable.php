<?php 

 namespace Flick\Model;

 use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Where;
 class FlickTable
 {
     protected $tableGateway;
	 
	 protected $user_id;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
         $this->user_id = -1;
     }
	 
     public function getFlicksByOwnerId($ownerId)
     {
		$select = new Select;
		$select->from(array('fl' => 'gm_flicks'));

		$select->columns(array('*'));


		$select->join(array('u' => 'gm_users'),	'fl.owner = u.id', array("real_name"));      
		
		$select->where(array("owner" => $ownerId));
		
		$select->group("id");
		
		$select->order(array('id DESC'));
		
		$statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
		
		$resultSet = $statement->execute();

		return $resultSet;	
     }
	 
     public function getFlicksByOwnerNickname($ownerNickname)
     {
		$select = new Select;
		$select->from(array('fl' => 'gm_flicks'));

		$select->columns(array('*'));


		$select->join(array('u' => 'gm_users'),	'fl.owner = u.id', array("real_name"));      
		
		$select->where(array("real_name" => $ownerNickname));
		
		$select->group("id");
		
		$select->order(array('id DESC'));
		
		$statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
		
		$resultSet = $statement->execute();

		return $resultSet;	
     }

     public function getMyFlicks()
     {
		 return $this->getFlicksByOwnerId($this->user_id);

     }
	 
	 public  function getTimeline() {
		 
		$select = new Select;
		$select->from(array('fl' => 'gm_flicks'));

		$select->columns(array('*'));

		$select->join(array('fr' => 'gm_friends'),	'fl.owner = fr.user_one OR fl.owner = fr.user_two', array());      
		$select->join(array('u' => 'gm_users'),	'fl.owner = u.id', array("real_name"));      
		
		$where = new Where;
		$or = $where->nest();
		$or->equalTo( 'fr.user_one', $this->user_id);
		$or->OR->equalTo( 'fr.user_two', $this->user_id );
		$or->unnest();
		$where->AND->equalTo( 'state', 1);
		
		$select->where($where);
		
		$select->order(array('id DESC'));
		
		$select->group("id");
		
		$statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
		
		$resultSet = $statement->execute();
		// var_dump($resultSet->current());
		// exit;
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

     public function getFlick($id)
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

     public function saveFlick(Flick $flick)
     {
         $data = array(
             'address' => $flick->address,
             'name'  => $flick->name,
             'fileupload'  => $flick->fileupload,
             'comment'  => $flick->comment,
             'mark'  => $flick->mark,
             'owner'  => $this->user_id,
         );

         $id = (int) $flick->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getFlick($id)) {
				 unset($data["fileupload"]);
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Flick id does not exist');
             }
         }
     }

     public function deleteFlick($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
 
 ?>