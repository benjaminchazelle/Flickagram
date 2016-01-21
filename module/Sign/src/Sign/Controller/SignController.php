<?php 

 namespace Sign\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Sign\Model\Sign;          // <-- Add this import
 use Sign\Form\SignForm;       // <-- Add this import


 class SignController extends AbstractActionController
 {


    public function indexAction()
     {

		 $success = -1;
		 
         $form = new SignForm();


         $request = $this->getRequest();
         if ($request->isPost()) {
			

			 /*
			 // $this->getSignTable()->
			$select = $db->select()
						 ->from(array('p' => 'produits'),
								array('produit_id', 'produit_nom'));
			 */
             $sign = new Sign();
             $form->setInputFilter($sign->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
				 
				$success = 0;
				
				$email_available = !is_object($this->getSignTable()->getSignByEmail($form->getData()["email"]));
				$nickname_available = !is_object($this->getSignTable()->getSignByNickname($form->getData()["real_name"]));

				 if($email_available && $nickname_available) {
				 
					 $sign->exchangeArray($form->getData());
					 $this->getSignTable()->saveSign($sign);

					 $success = 1;
					 // Redirect to list of signs
					 $this->redirect()->toRoute('signed');
				 }

             }
         }
         return array('email_available' => $email_available, 'nickname_available' => $nickname_available, 'success' => $success, 'form' => $form);
     }

    public function successAction() {
		
		return;
	}

	 
	 protected $signTable;
	 
     public function getSignTable()
     {
         if (!$this->signTable) {
             $sm = $this->getServiceLocator();
             $this->signTable = $sm->get('Sign\Model\SignTable');
			// $this->signTable->__setUser($this->getServiceLocator()->get('AuthService')->getStorage()->read()->id);
         }
         return $this->signTable;
     }
 }
 
 ?>