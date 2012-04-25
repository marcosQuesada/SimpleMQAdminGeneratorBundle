<?php

namespace SimpleMQ\AdminGeneratorBundle\Entity;

/**
 * Handles Fields description in auto schema
 * Using Mapping description (fieldNames & ReflectionClass)
 * 
 */
Class Mapper
{
    protected $entityManager;
    protected $metadataFactory;
    protected $allMetadata;
    protected $entity;
    protected $entityClass;
    protected $entityReflectionClass;
    protected $entityFields;   //#TODO: Unificar Repository&Fields!!!
    protected $entityFieldNames;    

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        $this->metadataFactory = $this->entityManager->getMetadataFactory();
        $this->allMetadata = $this->entityManager->getMetadataFactory()->getAllMetadata();  
        
    }
    
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
        $this->entity = $this->getEntityMapperFromClass($this->entityClass); 
        $this->entityFields = $this->getEntityFields(); /// TODO: ! REFACTOR 
        $this->entityReflectionClass = $this->entity->getReflectionProperties();        
    }
    
    /**
     * Reordenar array key por array Asociativo
     * @return type 
     */
    public function processEntityFields(){
        $fields = array();
        
        foreach($this->entityFields AS $field){
            $fields[$field['fieldName']] = $field;
        }
        return $fields;
    }
    
    public function createEntityFieldMapper(){
        $fieldNames = $this->processEntityFields();
        foreach($this->entityReflectionClass AS $key=>$field){

            if(isset($fieldNames[$key])){
                $fieldNames[$key]['reflectionClass'] = $field;
            }else{
                $fieldNames[$key] = '';
            }   
        }        
        return $fieldNames;
    }
    
    

    public function getMappedEntityFields(){
        $fieldNames = $this->processEntityFields();
        
        $fields = array();
        foreach($this->entityReflectionClass AS $key=>$field){
            $fields[]= $field->getName();
        }        
        return $fields;
    }

    public function getEntityFields(){
        $fields = array();
        $fieldNames = $this->entity->getFieldNames();
        foreach ($fieldNames AS $field){    
            $fields[] = $this->entity->getFieldMapping($field);
        }        
        
        return $fields;
    }
    /**
     *
     * @param string $class
     * @return ClassMetadata from Class
     */
    public function getEntityMapperFromClass($class){
        return $this->metadataFactory->getMetadataFor($class);
    }    
    
    public function getEntity()
    {
        return $this->entity;
    }

}
