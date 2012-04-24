<?php

namespace SimpleMQ\AdminGeneratorBundle\Routing;

class Resolver
{
    protected $request;
    protected $baseRoute;
    protected $referenceClass;
    
    public function __construct($request)
    {
        $this->request = $request;
        $this->route = $this->request->get('_route');       
        $this->baseRoute = $this->getBaseRoute();
        $this->referenceClass = $this->getReferenceClass();
        
    }
 
    
    public function getReferenceClass(){
        $parts = $this->cleanRouteParts($this->route); 
        if ($parts[0] == 'admin')
            array_shift($parts);        
        return implode('\\' ,$parts);         
    }
    
    public function getBaseRoute(){
        return implode('_' ,$this->cleanRouteParts($this->route));     
    }
    
    public function cleanRouteParts($route){
        $parts = explode('_',$route );
        array_pop($parts);
        return $parts    ;    
    }

   public function getEntityName(){

        $array = explode('\\',$this->referenceClass);
        return array_pop($array);
    }    
                    
}