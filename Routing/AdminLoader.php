<?php

namespace SimpleMQ\AdminGeneratorBundle\Routing;
 
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;
 
class AdminLoader implements LoaderInterface
{
    private $loaded = false;
    protected $container;


    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function load($resource, $type = null)
    {
                
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add this loader twice');
        }
        
       $adminPool = $this->container->get('simple_mq_admin_generator.adminpool');
       
       $actions = $adminPool->getCRUDActions();
       
        $routes = new RouteCollection();        
        //Add Dashboard
        $route = new Route('dashboard', array( 
                    '_controller' => 'SimpleMQAdminGeneratorBundle:Core:dashboard')
                );

        $routes->add('simple_mq_admin_dashboard', $route); 
        
        foreach ($adminPool->getClassEntities() AS $entityName=>$entityClass){
            foreach ($actions AS $action){   
                $pattern = (($action === 'list')|($action === 'new')|($action === 'create'))? 
                            strtolower($entityName)."/".$action : strtolower($entityName)."/".$action."/{id}";
                $defaults = array(
                    '_controller' => 'simple_mq_admin_generator.crud_controller:'.$action.'Action',
                );
                $route = new Route($pattern, $defaults);
                $ruta = 'admin_'.str_replace("\\", "_",$entityClass).'_'.$action;
                $routes->add($ruta, $route);                
            }
        }
        
        //Adding Custom Entity Routes
        foreach($adminPool->getMappedEntity() AS $key=>$value)
        {
            $adminEntity = $adminPool->getAdminEntityServiceFromPool($key);
            $localRoutes = $adminEntity->addCustomRoutes();

            foreach ($localRoutes as $value) {
                $route = new Route($value['pattern'], $value['defaults']);
                $routes->add($value['ruta'], $route);             
            }
        }
        
        return $routes;
    }
 
    public function supports($resource, $type = null)
    {
        return 'admin' === $type;
    }
 
    public function getResolver()
    {
    }
 
    public function setResolver(LoaderResolver $resolver)
    {
        // irrelevant to us, since we don't need a resolver
    }
}