<?php

Namespace SimpleMQ\AdminGeneratorBundle\Admin;

/**
 * Published as admin.pool
 * Compiler loads all Services tagged AS simple.admin.pool
 * 
 */
Class AdminPool
{
    protected $container;
    protected $entityMapper; //@TODO container->getDoctrine->getEntityMapper ??
    protected $mappedEntities;

    protected $actions; //@TODO pasa a ROUTER Class
    protected $baseRoute;//@TODO pasa a ROUTER Class
    protected $title;//@TODO NECESARIO ??
    
    public function __construct( $container,
                                 $entityMapper )
    {
        $this->entityMaper = $entityMapper;
        $this->container = $container;
    }
    

    /**
     * Builds MappedEntityCollection
     * @param type $id
     * @param type $entity 
     */
    public function addMappedEntity( $id , $entity )
    {
        $mappedEntity['id'] = $id;
        $mappedEntity['adminEntity'] = $entity;
        $entityClass = $entity->getClass();
        $mappedEntity['entityClass'] = $entityClass[0];
        $parts = explode('\\',$mappedEntity['entityClass']);
        $key = array_pop($parts);
        $key = str_replace('Admin','',$key);
        $this->mappedEntities[$key] = $mappedEntity;

    }
    
    public function getMappedEntity( )
    {
        return $this->mappedEntities;
    }
    

    /**  @TODO: 
    *   Repplaces findMappedEntityByClass
    *   Resolver gets Entity 
    *   
    *   Returns Local Admin Entity Instance
    **/
    public function getAdminEntityServiceFromPool($referenceClass)
    {
        $adminEntity = $this->getEntityName($referenceClass);
        $adminMappedEntity = $this->mappedEntities[$adminEntity];
        //id is Admin Entity Service name
        return $this->container->get($adminMappedEntity['id']);

    }

    public function findMappedEntityByClass($referenceClass)
    {
        

        foreach($this->getMappedEntity() AS $mappedEntities)
        {
            if ($mappedEntities['entityClass'] == $referenceClass)
                $entity = $mappedEntities;
        }
        
        return $entity;
    }



    /**
     *
     *  title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function getTitle()
    {
        return $this->title;        
    }
    

    /**
     * Return Entity Class from services
     * hooked on acme_admin.admin_pool
     * @return type array Class Strings
     */
    public function getClassEntities(){
       $classes = array();
       
       foreach($this->mappedEntities AS $key=>$item){

            $item =$item['adminEntity']->getClass();
            $classes[$this->getEntityName($item[0])] = $item[0];                   
       }
       
       return $classes;
    }   

   public function getEntityName($class){

        $array = explode('\\',$class);
        return array_pop($array);
    }    
    
    /**
     * Router builders
     * 
     */
    public function setCRUDActions($actions){
        $this->actions = $actions;
    }
    
    public function getCRUDActions(){
        $CRUDActions = array();
        foreach ($this->getActions() As $key=>$action)
        {
            $CRUDActions[]= $key;
        }
        
        return $CRUDActions;
    }    
    
    public function getActions(){
        return $this->actions;
    }
    
    /**
     * Base route path: ex: /admin/
     * @param type $path 
     */
    public function setBaseRoute($path)
    {
        $this->baseRoute = $path;
    }
    
    public function getBaseRoute()
    {
        return $this->baseRoute;
    }    
    


}