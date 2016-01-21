<?php 

 namespace Flick\Model;

  use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

 
 use Zend\InputFilter\Factory as InputFactory;

 class Flick
 {
     public $id;
     public $address;
     public $name;
     public $fileupload;
     public $owner;

     public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->address = (!empty($data['address'])) ? $data['address'] : null;
         $this->name  = (!empty($data['name'])) ? $data['name'] : null;
         $this->fileupload  = (!empty($data['fileupload'])) ? $data['fileupload'] : null;
         $this->comment  = (!empty($data['comment'])) ? $data['comment'] : null;
         $this->mark  = (!empty($data['mark'])) ? $data['mark'] : null;
         $this->owner  = (!empty($data['owner'])) ? $data['owner'] : null;
     }
	 
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }

	 
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getInputFilter($uploadRequire=true)
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
                 'name'     => 'address',
                 'required' => false,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'name',
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
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));
			 
             $inputFilter->add(array(
                 'name'     => 'comment',
                 'required' => false,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
             )); 

			
	         $inputFilter->add(array(
                 'name'     => 'mark',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
					array (
						'name' => 'Between',
						'options' => array (
							'min' => 1,
							'max' => 5,
							'messages' => array('notBetween' => 'Point must be between %min% and %max%')
						),
					),
                 ),
             ));
			$factory  = new InputFactory();
			$inputFilter->add(
                $factory->createInput(array(
                    'name'     => 'fileupload',
                    'required' => $uploadRequire,
                ))
            );

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }

 }
 
 ?>