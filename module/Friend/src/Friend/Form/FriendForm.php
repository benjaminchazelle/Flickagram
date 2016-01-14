<?php 

 namespace Friend\Form;

 use Zend\Form\Form;

 class FriendForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('friend');

         $this->add(array(
             'name' => 'name',
             'type' => 'Text',
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