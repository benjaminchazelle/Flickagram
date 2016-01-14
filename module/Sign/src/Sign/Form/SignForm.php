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
                 'label' => 'Email',
             ),
         ));
         $this->add(array(
             'name' => 'password',
             'type' => 'password',
             'options' => array(
                 'label' => 'Password',
             ),
         ));
           $this->add(array(
             'name' => 'real_name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Real name',
             ),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }
 
 ?>