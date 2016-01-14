<?php 

 namespace Restaurant\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Restaurant\Model\Restaurant;          // <-- Add this import
 use Restaurant\Form\RestaurantForm;       // <-- Add this import


 class RestaurantController extends AbstractActionController
 {
     public function indexAction()
     {
		 
		//$this->layout()->setVariable('hasIdentity', $this->getServiceLocator()->get('AuthService')->hasIdentity());
/*
        if (! $this->getServiceLocator()
                 ->get('AuthService')->hasIdentity()){
            return $this->redirect()->toRoute('login');
        }
*/

		// print_r( $this->getServiceLocator()->get('AuthService'));
		//exit;


         return new ViewModel(array(
			  'data' => $this->getServiceLocator()->get('AuthService'),
             'restaurants' => $this->getRestaurantTable()->fetchAll($this->getServiceLocator()->get('AuthService')->getStorage()->read()->id),
         ));
     }

    public function addAction()
     {
         $form = new RestaurantForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $restaurant = new Restaurant();
             $form->setInputFilter($restaurant->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $restaurant->exchangeArray($form->getData());
                 $this->getRestaurantTable()->saveRestaurant($restaurant);

                 // Redirect to list of restaurants
                 return $this->redirect()->toRoute('restaurant');
             }
         }
         return array('form' => $form);
     }


     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('restaurant', array(
                 'action' => 'add'
             ));
         }

         // Get the Restaurant with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $restaurant = $this->getRestaurantTable()->getRestaurant($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('restaurant', array(
                 'action' => 'index'
             ));
         }

		 if(!$restaurant) {
             return $this->redirect()->toRoute('restaurant', array(
                 'action' => 'add'
             ));
		 }
		 // var_dump($restaurant);
		 
         $form  = new RestaurantForm();
         $form->bind($restaurant);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($restaurant->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getRestaurantTable()->saveRestaurant($restaurant);

                 // Redirect to list of restaurants
                 return $this->redirect()->toRoute('restaurant');
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
     }

     public function deleteAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
		 $restaurant = $this->getRestaurantTable();

         if (!$id) {
             return $this->redirect()->toRoute('restaurant');
         }
		 
		 if(!$restaurant->getRestaurant($id))
             return $this->redirect()->toRoute('restaurant');


         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $restaurant->deleteRestaurant($id);
             }

             // Redirect to list of restaurants
             return $this->redirect()->toRoute('restaurant');
         }

         return array(
             'id'    => $id,
             'restaurant' => $restaurant->getRestaurant($id)
         );
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