<?php 

 namespace Album\Model;

 use Zend\Db\TableGateway\TableGateway;

 class AlbumTable
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
	 public function isMine($user_id, $album_id) {
         $resultSet = $this->tableGateway->select("owner = ".$user_id);
		var_dump($resultSet);
	 }*/

     public function getAlbum($id)
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

     public function saveAlbum(Album $album)
     {
         $data = array(
             'artist' => $album->artist,
             'title'  => $album->title,
             'owner'  => $this->user_id,
         );

         $id = (int) $album->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getAlbum($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Album id does not exist');
             }
         }
     }

     public function deleteAlbum($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
 
 ?>