<?php

Namespace SimpleMQ\AdminGeneratorBundle\Builder;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdminFormBuilder extends AbstractType
{
	protected $fields;

    public function __construct($entityMapping ,$routeResolver)
    {
    	$this->entityMapping = $entityMapping;

    	$this->entityClass = $routeResolver->getReferenceClass();
    	$this->entityMapping->setEntityClass($this->entityClass);
    	//$this->fields = $this->entityMapping->getEntityFields();

      $this->fields = $this->entityMapping->getMappedEntityFields();
     // echo "entityFIelds";
     // ladybug_dump($this->entityMapping->getEntityFields());
     // echo "Fields";
     // ladybug_dump($this->fields);
  	}

   /**
     * Form builder, dinamically add entity fields from entity 
     * Metadata 
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        foreach ($this->fields AS $field){
          if($field!= 'id')
              $builder->add($field); 
        }     
    }

    public function getName()
    {
        return 'simple_mq_admin_generator_bundle_builderform';
    }  	

}

