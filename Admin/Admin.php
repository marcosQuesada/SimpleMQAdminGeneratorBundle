<?php

Namespace SimpleMQ\AdminGeneratorBundle\Admin;
/**
 * Admin Class works as Abstract class to be extended from admin mapped entities
 * Works as Builder , permits overide of his methods on admin mapped entities
 * Mainly will resolve :  getForm, getField
 * 
 */
Class Admin
{
    protected $container;
    protected $request;
    protected $em;
    protected $entity;
    protected $mappedEntityService;
    protected $baseRoute;
    protected $actualPathRoute;
    protected $class;
    protected $controllerClass;

    //@TODO: organize actions!
    protected $actions = array('list','show','edit','new','create','delete','update');

    public function __construct($class)
    {        
        $this->class  = $class;    
    }
        
    public function getClass(){
        return $this->class;        
    }    

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function getEntityInstance()
    {
        $entityClass = "\\".$this->class[0];
        return new $entityClass();
    }
    
    /**
     *
     * @return string 
     */
    public function getEntityRoutes(){
        $routes = array();
        
        foreach ($this->actions AS $action){            
            $routes[$action] = 'admin_'.$this->getEntityBaseRoute().'_'.$action;
        }
        return $routes;
    }    

    public function getEntityBaseRoute(){
        return str_replace("\\", "_", $this->class[0]);
    }

    public function getEntityFields()
    {
        return $this->container->get('simple_mq_admin_generator.builder.fields')->getEntityFields();
    }

    public function getForm()
    {
        return $this->container->get('simple_mq_admin_generator.builder.form');
    }

    public function getGridFields()
    {
        return $this->getEntityFields();
    }

    public function getShowFields()
    {
        return $this->getEntityFields();
    }    

    public function addCustomRoutes()
    {
        return array();
    }

}