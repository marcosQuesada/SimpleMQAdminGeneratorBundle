<?php

Namespace SimpleMQ\AdminGeneratorBundle\Builder;

class Builder
{
    protected $entityMapping;

    /**
     * [__construct description]
     * 
     * @param [type] $entityMapping [description]
     * @param [type] $routeResolver [description]
     */
    public function __construct($entityMapping ,$routeResolver)
    {
        $this->entityMapping = $entityMapping;
        $this->entityClass   = $routeResolver->getReferenceClass();
        $this->entityMapping->setEntityClass($this->entityClass);
    }

    /**
     * [getEntityMapping description]
     * 
     * @return [type] [description]
     */
    public function getEntityMapping()
    {
        return $this->entityMapping;
    }

    /**
     * [getEntityFields description]
     * 
     * @return [type] [description]
     */
    public function getEntityFields()
    {
        return $this->entityMapping->getEntityFields();
    }
}