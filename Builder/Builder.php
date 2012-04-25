<?php

Namespace SimpleMQ\AdminGeneratorBundle\Builder;

class Builder
{
	protected $entityMapping;


    public function __construct($entityMapping ,$routeResolver)
    {
    	$this->entityMapping = $entityMapping;
    	$this->entityClass = $routeResolver->getReferenceClass();
    	$this->entityMapping->setEntityClass($this->entityClass);
  	}

  	public function getEntityMapping()
  	{
  		return $this->entityMapping;
  	}

  	//@TODO: Continue!!!
  	public function getEntityFields()
  	{
  		return $this->entityMapping->getEntityFields();
      //return $this->entityMapping->getMappedEntityFields();

  	}
}