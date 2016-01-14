<?php 

 namespace Friend\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Friend\Model\Friend;          // <-- Add this import
 use Friend\Model\Search;          // <-- Add this import
 use Friend\Form\FriendForm;       // <-- Add this import
 use Restaurant\Model\Restaurant;          // <-- Add this import
 use Restaurant\Form\RestaurantForm;       // <-- Add this import

 class FriendController extends AbstractActionController
 {
     public function indexAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
		 
		 if($id == $this->getServiceLocator()->get('AuthService')->getStorage()->read()->id)
			 return $this->redirect()->toRoute('home');
		 
		     $view = new ViewModel();
			 
			 // $restaurants = $this->getRestaurantTable()->fetchAll($this->getServiceLocator()->get('AuthService')->getStorage()->read()->id);
			 
			 // foreach ($restaurants as $restaurant) {
				 
				 // var_dump($restaurant);
				 
			 // }
			 
			 // var_dump(scandir('module/Friend/view/friend/friend/allFriends.phtml'));
		 // var_dump($this->getServiceLocator()->get('AuthService')->getStorage()->read());
		 if($id == 0) {
			 
			$view->setVariable("friends", $this->getFriendTable()->getFriends());
			$view->setVariable("requests", $this->getFriendTable()->getRequests());
			
			
			 
			$view->setTemplate('friend/friend/allFriends');

			 
			 
		 }
		 else {
			 
			$friend = $this->getFriendTable()->getUser($id);
			
			$exists = is_array($friend);
			 
			$view->setVariable("exists", $exists);
			
			if($exists) {
				$view->setVariable("friend", $friend);
				$view->setVariable("restaurants", $this->getRestaurantTable()->fetchAll($id));
			}
			 
			$view->setTemplate('friend/friend/friend');
			 
		 }
		 
		return $view;
		//$this->layout()->setVariable('hasIdentity', $this->getServiceLocator()->get('AuthService')->hasIdentity());
/*
        if (! $this->getServiceLocator()
                 ->get('AuthService')->hasIdentity()){
            return $this->redirect()->toRoute('login');
        }
*/

		// print_r( $this->getServiceLocator()->get('AuthService'));
		//exit;


		/*
         return new ViewModel(array(
			 'data' => $this->getServiceLocator()->get('AuthService'),
             'friends' => $this->getFriendTable()->fetchAll($this->getServiceLocator()->get('AuthService')->getStorage()->read()->id),
         ));*/
     }
	 
	 
     public function addAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);

		 if($id == 0) {
			 $this->redirect()->toRoute('friend');
		 }
		 else {
			 
			 
			 if($this->getFriendTable()->setRequest($id))
				return $this->redirect()->toRoute('friend', array('id'=>$id));

			 
		 }
		 
	 }
	 
	 public function searchAction() {
		 
		 
        $form = new FriendForm();
         $form->get('submit')->setValue('Rechercher');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $search = new Search();
             $form->setInputFilter($search->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
				 
					$users = $this->getFriendTable()->searchByName($form->getData()["name"]);
					
					 return array(
						 'form' => $form,
						 'users' => $users,
					 );

			 }

		 }
		 
         return array(
             'form' => $form,
			 'users' => array()
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
	 
	  protected $restaurantTable;
	 
     public function getRestaurantTable()
     {
         if (!$this->restaurantTable) {
             $sm = $this->getServiceLocator();
             $this->restaurantTable = $sm->get('Restaurant\Model\RestaurantTable');
			 $this->restaurantTable->__setUser($this->getServiceLocator()->get('AuthService')->getStorage()->read()->id);
         }
         return $this->restaurantTable;
     }
 }
 
 ?>