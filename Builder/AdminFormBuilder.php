<?php

Namespace SimpleMQ\AdminGeneratorBundle\Builder;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdminFormBuilder extends AbstractType
{
    protected $fields;

    /**
     * [__construct description]
     * 
     * @param [type] $entityMapping [description]
     * @param [type] $routeResolver [description]
     */
    public function __construct($entityMapping ,$routeResolver)
    {
        $this->entityMapping = $entityMapping;
        $this->entityClass = $routeResolver->getReferenceClass();
        $this->entityMapping->setEntityClass($this->entityClass);     
        $this->fields = $this->entityMapping->getMappedEntityFields();
    }

    /**
     * Form builder, dinamically add entity fields from entity 
     * Metadata 
     * 
     * @param FormBuilder $builder [description]
     * @param array       $options [description]
     * 
     * @return [type]               [description]
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        foreach ($this->fields AS $field) {
          if($field!= 'id')
              $builder->add($field); 
        }     
    }

    /**
     * [getName description]
     * 
     * @return [type] [description]
     */
    public function getName()
    {
        return 'simple_mq_admin_generator_bundle_builderform';
    }   

}

