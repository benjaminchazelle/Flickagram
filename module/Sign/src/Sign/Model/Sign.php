<?php 

 namespace Sign\Model;

  use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;


 class Sign
 {
     public $id;
     public $email;
     public $password;
     public $real_name;

     public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->email = (!empty($data['email'])) ? $data['email'] : null;
         $this->password  = (!empty($data['password'])) ? $data['password'] : null;
         $this->real_name  = (!empty($data['real_name'])) ? $data['real_name'] : null;
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
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'email',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(array('name' => 'Zend\Validator\EmailAddress'))
             ));

             $inputFilter->add(array(
                 'name'     => 'password',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 6,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));
			 
             $inputFilter->add(array(
                 'name'     => 'real_name',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 240,
                         ),
                     ),
                 ),
             )); 
           
			 
			 

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }

 }
 
 ?>