<?php 

 namespace Friend\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Friend\Model\Friend;          // <-- Add this import
 use Friend\Model\Search;          // <-- Add this import
 use Friend\Form\FriendForm;       // <-- Add this import
 use Flick\Model\Flick;          // <-- Add this import
 use Flick\Form\FlickForm;       // <-- Add this import

 class FriendController extends AbstractActionController
 {
	 public function wallAction( ) {
		 
		$input = $this->params()->fromRoute('id', 0);
		  
		 
		$userdata = is_numeric($input) ? $this->getFriendTable()->getUserById($input) : $this->getFriendTable()->getUserByNickname($input);
		
		
		$exists = is_array($userdata);
		
		$userflicks = array();
		
		if($exists) {
			
			if($userdata["friendship"] == 1) {
				
				$userflicks = $this->getFlickTable()->getFlicksByOwnerId($userdata["id"]);
			
			}
			
		}
		
		 
		 
		 
	

         return new ViewModel(array(
			'searchterm' => "",
				'exists' => $exists,
				'user' => $userdata,
				'flicks' => $userflicks,
				'currentUserId' => $this->getServiceLocator()->get('AuthService')->getStorage()->read()->id,
				'friends' => $this->getFriendTable()->getFriends(),
         ));		 
		 
	 }
	 
	 public function invitationsAction() {
			
         return new ViewModel(array(
			'searchterm' => "",
				'invitations' => $this->getFriendTable()->getInvitations(),
				'currentUserId' => $this->getServiceLocator()->get('AuthService')->getStorage()->read()->id,
				'friends' => $this->getFriendTable()->getFriends(),
         ));
		 
	 }
	 

	 
	 
     public function addAction() {
         $id = (int) $this->params()->fromRoute('id', 0);


			 
			if($this->getFriendTable()->setRequest($id))
				return $this->redirect()->toRoute('user', array('id'=>$id));

			 
		 //return $this->redirect()->toRoute('home');
		 
	 }
	 
	 public function searchAction() {
		 
		 $searchterm = "";
		 
		 $users = array();
		 
		$form = new FriendForm();
         $form->get('submit')->setValue('Rechercher');
         $request = $this->getRequest();
         if ($request->isPost()) {
             $search = new Search();
             $form->setInputFilter($search->getInputFilter());
             $form->setData($request->getPost());
             if ($form->isValid()) {
				 
					$searchterm = $form->getData()["name"];
					$users = $this->getFriendTable()->searchByNickname($form->getData()["name"]);
					

			 }
		 }
		 
         return array(
			 'form' => $form,
             'searchterm' => $searchterm,
			 'users' => $users,
				'friends' => $this->getFriendTable()->getFriends(),			 
         );
	 }

  
	 
	 protected $friendTable;
	 
     public function getFriendTable()
     {
         if (!$this->friendTable) {
             $sm = $this->getServiceLocator();
             $this->friendTable = $sm->get('Friend\Model\FriendTable');
			 $this->friendTable->__setUser($this->getServiceLocator()->get('AuthService')->getStorage()->read()->id);
         }
         return $this->friendTable;
     }
	 
	  protected $flickTable;
	 
     public function getFlickTable()
     {
         if (!$this->flickTable) {
             $sm = $this->getServiceLocator();
             $this->flickTable = $sm->get('Flick\Model\FlickTable');
			 $this->flickTable->__setUser($this->getServiceLocator()->get('AuthService')->getStorage()->read()->id);
         }
         return $this->flickTable;
     }
 }
 
 ?>