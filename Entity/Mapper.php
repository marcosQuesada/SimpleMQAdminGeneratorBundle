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

    /**
     * [__construct description]
     * 
     * @param [type] $entityManager [description]
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        $this->metadataFactory = $this->entityManager->getMetadataFactory();
        $this->allMetadata = $this->entityManager->getMetadataFactory()->getAllMetadata();  
        
    }
    
    /**
     * [setEntityClass description]
     * 
     * @param [type] $entityClass [description]
     * 
     * @return void
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
        $this->entity = $this->getEntityMapperFromClass($this->entityClass); 
        $this->entityFields = $this->getEntityFields(); /// TODO: ! REFACTOR 
        $this->entityReflectionClass = $this->entity->getReflectionProperties();        
    }

    /**
     * Reordenar array key por array Asociativo
     * 
     * @return [type] [description]
     */
    public function processEntityFields()
    {
        $fields = array();
        
        foreach ($this->entityFields AS $field) {
            $fields[$field['fieldName']] = $field;
        }
        return $fields;
    }
    
    /**
     * [createEntityFieldMapper description]
     * 
     * @return [type] [description]
     */
    public function createEntityFieldMapper()
    {
        $fieldNames = $this->processEntityFields();
        foreach ($this->entityReflectionClass AS $key=>$field) {

            if (isset($fieldNames[$key])) {
                $fieldNames[$key]['reflectionClass'] = $field;
            } else {
                $fieldNames[$key] = '';
            }   
        }        
        return $fieldNames;
    }
    
    /**
     * [getMappedEntityFields description]
     * 
     * @return [type] [description]
     */
    public function getMappedEntityFields()
    {
        $fieldNames = $this->processEntityFields();
        
        $fields = array();
        foreach ($this->entityReflectionClass AS $key=>$field) {
            $fields[]= $field->getName();
        }        
        return $fields;
    }

    /**
     * [getEntityFields description]
     * 
     * @return [type] [description]
     */
    public function getEntityFields()
    {
        $fields = array();
        $fieldNames = $this->entity->getFieldNames();
        foreach ($fieldNames AS $field) {    
            $fields[] = $this->entity->getFieldMapping($field);
        }        
        
        return $fields;
    }

    /**
     * [getEntityMapperFromClass description]
     * 
     * @param [type] $class [description]
     * 
     * @return [type]        [description]
     */
    public function getEntityMapperFromClass($class)
    {
        return $this->metadataFactory->getMetadataFor($class);
    }    
    
    /**
     * [getEntity description]
     * 
     * @return [type] [description]
     */
    public function getEntity()
    {
        return $this->entity;
    }

}
