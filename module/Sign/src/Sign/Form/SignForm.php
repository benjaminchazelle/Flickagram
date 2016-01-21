<?php 

 namespace Sign\Form;

 use Zend\Form\Form;

 class SignForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('sign');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'email',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             ),
			'attributes' => array(
				'id'  => 'exampleInputEmail1',
				'class'  => 'form-control',
				'placeholder'  => 'E-Mail',
			),
         ));
         $this->add(array(
             'name' => 'password',
             'type' => 'password',
             'options' => array(
                 'label' => '',
             ),
			'attributes' => array(
				'id'  => 'exampleInputPassword1',
				'class'  => 'form-control',
				'placeholder'  => 'Mot de passe',
			),
         ));
          $this->add(array(
             'name' => 'repassword',
             'type' => 'password',
             'options' => array(
                 'label' => '',
			),
			'attributes' => array(
				'id'  => 'exampleInputPassword2',
				'class'  => 'form-control',
				'placeholder'  => 'Retaper-le',
			),
         ));
           $this->add(array(
             'name' => 'nickname',
             'type' => 'Text',
             'options' => array(
                 'label' => '',
             ),
			'attributes' => array(
				'id'  => 'exampleInputNom',
				'class'  => 'form-control',
				'placeholder'  => 'Nom',
			),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
			'attributes' => array(
				'class'  => 'btn btn-primary',
				'value'  => 'S\'inscrire',
			),
         ));
     }
 }
 
 ?>