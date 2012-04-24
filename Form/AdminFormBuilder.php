<?php

Namespace SimpleMQ\AdminGeneratorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdminFormBuilder extends AbstractType
{    
    protected $fields;

    /**
     * Receive array Form fields from Adapter
     * @param type $fields 
     */
    public function setup($fields){

        $this->fields = $fields;
    }
    
    /**
     * Form builder, dinamically add entity fields from entity 
     * Metadata 
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        //adapter from reflection Class
        foreach ($this->fields AS $key=>$field){
            $builder->add($key); 
        }     
    }

    public function getName()
    {
        return 'simple_mq_admin_generator_bundle_entityform';
    }
    
    
}