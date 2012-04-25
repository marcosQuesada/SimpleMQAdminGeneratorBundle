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

    /**
     * [__construct description]
     * 
     * @param [type] $class [description]
     */
    public function __construct($class)
    {        
        $this->class  = $class;    
    }
        
    /**
     * [getClass description]
     * 
     * @return [type] [description]
     */
    public function getClass()
    {
        return $this->class;        
    }    

    /**
     * [setContainer description]
     * 
     * @param [type] $container [description]
     * 
     * @return void
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * [getEntityInstance description]
     * 
     * @return [type] [description]
     */
    public function getEntityInstance()
    {
        $entityClass = "\\".$this->class[0];
        return new $entityClass();
    }
    
    /**
     * [getEntityRoutes description]
     * 
     * @return [type] [description]
     */
    public function getEntityRoutes()
    {
        $routes = array();
        
        foreach ($this->actions AS $action) {            
            $routes[$action] = 'admin_'.$this->getEntityBaseRoute().'_'.$action;
        }
        return $routes;
    }    

    /**
     * [getEntityBaseRoute description]
     * 
     * @return [type] [description]
     */
    public function getEntityBaseRoute()
    {
        return str_replace("\\", "_", $this->class[0]);
    }

    /**
     * [getEntityFields description]
     * 
     * @return [type] [description]
     */
    public function getEntityFields()
    {
        return $this->container->get('simple_mq_admin_generator.builder.fields')->getEntityFields();
    }

    /**
     * [getForm description]
     * 
     * @return [type] [description]
     */
    public function getForm()
    {
        return $this->container->get('simple_mq_admin_generator.builder.form');
    }

    /**
     * [getGridFields description]
     * 
     * @return [type] [description]
     */
    public function getGridFields()
    {
        return $this->getEntityFields();
    }

    /**
     * [getShowFields description]
     * 
     * @return [type] [description]
     */
    public function getShowFields()
    {
        return $this->getEntityFields();
    }    

    /**
     * [addCustomRoutes description]
     * 
     * @return array [description]
     */
    public function addCustomRoutes()
    {
        return array();
    }

}