<?php 

 namespace Friend\Model;

  use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

 class Friend
 {
     public $user_one;
     public $user_two;
     public $state;

     public function exchangeArray($data)
     {
         $this->user_one     = (!empty($data['user_one'])) ? $data['user_one'] : null;
         $this->user_two = (!empty($data['user_two'])) ? $data['user_two'] : null;
         $this->state  = (!empty($data['state'])) ? $data['state'] : null;
     }
	 
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }

	 
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getInputFilter()
     {
         if (!isset($this->inputFilter)) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'user_one',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

			 
	             $inputFilter->add(array(
                 'name'     => 'user_two',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

			 
	             $inputFilter->add(array(
                 'name'     => 'state',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

			 
			 

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }

 }
 
 ?>