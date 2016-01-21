<?php 

 namespace Flick\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Flick\Model\Flick;          // <-- Add this import
 use Flick\Form\FlickForm;       // <-- Add this import
 use Friend\Model\Friend;          // <-- Add this import
 use Friend\Form\FriendForm;       // <-- Add this import
use Zend\Validator\File\Size;


 class FlickController extends AbstractActionController
 {
     public function indexAction()
     {

         return new ViewModel(array(
			'searchterm' => "",
				'flicks' => $this->getFlickTable()->getTimeline(),
				'currentUserId' => $this->getServiceLocator()->get('AuthService')->getStorage()->read()->id,		
				'friends' => $this->getFriendTable()->getFriends(),				
         ));
     }
	 
     public function meAction()
     {

         return new ViewModel(array(
			'searchterm' => "",
				'flicks' => $this->getFlickTable()->getMyFlicks(),
				'currentUserId' => $this->getServiceLocator()->get('AuthService')->getStorage()->read()->id,
				'friends' => $this->getFriendTable()->getFriends(),
         ));
     }

    public function addAction()
     {
		 $view = new ViewModel();

		 $view->setVariable("id", "");
		 
         $form = new FlickForm();
         $form->get('submit')->setValue('Ajouter');

         $request = $this->getRequest();
         if ($request->isPost()) { 
             $flick = new Flick();

             $form->setInputFilter($flick->getInputFilter(true));
            
				
			 
				$File    = $this->params()->fromFiles('fileupload');
				$nonFile = $request->getPost()->toArray();
				$data    = array_merge_recursive(
					$this->getRequest()->getPost()->toArray(),           
					$this->getRequest()->getFiles()->toArray()
					);

				$form->setData($data);

             if ($form->isValid()) {
				 
				$adapter = new \Zend\File\Transfer\Adapter\Http(); 
				
				if(empty($File["name"])) {
					$view->setVariable("form", $form);
					return $view;
				}
			
				$path = pathinfo($File['name']);
				$ext = $path['extension'];
				$filename = md5($File['name']) . "-" . time() . "." . $ext;
				
				$adapter->addFilter('Rename', $filename);
				
                if (!$adapter->isValid()){echo 77;exit;
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
                        $flick->exchangeArray($d);
						$this->getFlickTable()->saveFlick($flick);

                    }
                }  
                 // $flick->exchangeArray($form->getData());
                 

                 // Redirect to list of flicks
                 return $this->redirect()->toRoute('me');
             }
         }
		 

		 $view->setVariable("form", $form);
		 
		 return $view;
     }


     public function editAction()
     {
		 $view = new ViewModel();
		 
		 
         $id = (int) $this->params()->fromRoute('id', 0);
		 // var_dump($id);exit;
         if (!$id) {
             return $this->redirect()->toRoute('me', array(
                 'action' => 'add'
             ));
         }

         // Get the Flick with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $flick = $this->getFlickTable()->getFlick($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('me');
         }

		 if(!$flick) {
             return $this->redirect()->toRoute('flick', array(
                 'action' => 'add'
             ));
		 }
		 // var_dump($flick);
		 
         $form  = new FlickForm();
         $form->bind($flick);
         $form->get('submit')->setAttribute('value', 'Éditer');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($flick->getInputFilter(false));
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getFlickTable()->saveFlick($flick);

                 // Redirect to list of flicks
                 return $this->redirect()->toRoute('me');
             }
         }
		 
		 $view->setVariable("id", $id);
		 $view->setVariable("form", $form);
		 
		 return $view;
     }

     public function deleteAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
		 $flick = $this->getFlickTable();

         if (!$id) {
             return $this->redirect()->toRoute('flick');
         }
		 
		 if(!$flick->getFlick($id))
             return $this->redirect()->toRoute('flick');


         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'Non');

             if ($del == 'Supprimer') {
                 $id = (int) $request->getPost('id');
                 $flick->deleteFlick($id);
             }

             // Redirect to list of flicks
             return $this->redirect()->toRoute('flick');
         }

         return array(
             'id'    => $id,
             'flick' => $flick->getFlick($id)
         );
     }
	 
	 protected $flickTable;
	 protected $friendTable;
	 
     public function getFlickTable()
     {
         if (!$this->flickTable) {
             $sm = $this->getServiceLocator();
             $this->flickTable = $sm->get('Flick\Model\FlickTable');
			 $this->flickTable->__setUser($this->getServiceLocator()->get('AuthService')->getStorage()->read()->id);
         }
         return $this->flickTable;
     }
	 
     public function getFriendTable()
     {
         if (!$this->friendTable) {
             $sm = $this->getServiceLocator();
             $this->friendTable = $sm->get('Friend\Model\FriendTable');
			 $this->friendTable->__setUser($this->getServiceLocator()->get('AuthService')->getStorage()->read()->id);
         }
         return $this->friendTable;
     }
 }
 
 ?>