<?php 

 namespace Restaurant\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Restaurant\Model\Restaurant;          // <-- Add this import
 use Restaurant\Form\RestaurantForm;       // <-- Add this import
use Zend\Validator\File\Size;


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
		 $view = new ViewModel();
		 
		 $view->setVariable("title", "Éditer un restaurant");
		 
		 $view->setTemplate('restaurant/restaurant/edit');
		 
         $form = new RestaurantForm();
         $form->get('submit')->setValue('Ajouter');

         $request = $this->getRequest();
         if ($request->isPost()) { 
             $restaurant = new Restaurant();

             $form->setInputFilter($restaurant->getInputFilter());
            
				
			 
				$File    = $this->params()->fromFiles('fileupload');
				$nonFile = $request->getPost()->toArray();
				$data    = array_merge_recursive(
					$this->getRequest()->getPost()->toArray(),           
					$this->getRequest()->getFiles()->toArray()
					);

				$form->setData($data);
			  
             if ($form->isValid()) {
				 
				$adapter = new \Zend\File\Transfer\Adapter\Http(); 
				
			
				$path = pathinfo($File['name']);
				$ext = $path['extension'];
				$filename = md5($File['name']) . "-" . time() . "." . $ext;
				
				$adapter->addFilter('Rename', $filename);
				
                if (!$adapter->isValid()){
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach($dataError as $key=>$row)
                    {
                        $error[] = $row;
                    }
                    $form->setMessages(array('fileupload'=>$error ));
                } else {
                    $adapter->setDestination(dirname(__DIR__).'/../../../../public/assets');
                    // $adapter->setDestination('.');
                    if ($adapter->receive($File['name'])) {
						
						$d = $form->getData();
						$d["fileupload"] = $filename;
						// var_dump($d);
						// exit;
                        $restaurant->exchangeArray($d);
						$this->getRestaurantTable()->saveRestaurant($restaurant);

                    }
                }  
                 // $restaurant->exchangeArray($form->getData());
                 

                 // Redirect to list of restaurants
                 return $this->redirect()->toRoute('restaurant');
             }
         }
		 
		 $view->setVariable("id", "");
		 $view->setVariable("form", $form);
		 
		 return $view;
     }


     public function editAction()
     {
		 $view = new ViewModel();
		 
		 $view->setVariable("title", "Éditer un restaurant");
		 
		 $view->setTemplate('restaurant/restaurant/edit');
		 
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
         $form->get('submit')->setAttribute('value', 'Éditer');

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
		 
		 $view->setVariable("id", $id);
		 $view->setVariable("form", $form);
		 
		 return $view;
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
             $del = $request->getPost('del', 'Non');

             if ($del == 'Oui') {
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