<?php 

 namespace Restaurant\Form;

 use Zend\Form\Form;

 class RestaurantForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('restaurant');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Name',
             ),
         ));
         $this->add(array(
             'name' => 'address',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Address',
             ),
         ));
          $this->add(array(
             'name' => 'comment',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Comment',
             ),
         ));
          $this->add(array(
             'name' => 'mark',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Mark',
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