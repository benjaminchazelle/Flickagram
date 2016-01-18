<?php 

 namespace Restaurant\Form;

 use Zend\Form\Form;

 class RestaurantForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('restaurant');
		 

		$this->setAttribute('class', 'form-horizontal');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
		 
         $this->add(array(
             'name' => 'name',
             'type' => 'Text',
			'attributes' => array(
				'id'  => 'field_name',
				'class'  => 'form-control',
			),
             'options' => array(
                 'label' => 'Name',
				
             ),
         ));
		 
		 

         $this->add(array(
             'name' => 'address',
             'type' => 'Text',
			'attributes' => array(
				'id'  => 'field_address',
				'class'  => 'form-control',
				'placeholder'  => 'Utilisez la carte pour localiser le restaurant',
			),
             'options' => array(
                 'label' => 'address',
             ),
         ));
          $this->add(array(
             'name' => 'comment',
             'type' => 'Textarea',
			'attributes' => array(
				'id'  => 'field_comment',
				'class'  => 'form-control',
			),
             'options' => array(
                 'label' => 'Comment',
             ),
         ));
          $this->add(array(
             'name' => 'mark',
             'type' => 'Text',
			'attributes' => array(
				'id'  => 'field_mark',
			),
             'options' => array(
                 'label' => 'Mark',
             ),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Ajouter',
                 'id' => 'submitbutton',
                 'class' => 'btn btn-primary',
             ),
         ));
     }
 }
 
 ?>