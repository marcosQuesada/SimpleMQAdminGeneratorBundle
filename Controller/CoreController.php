<?php

namespace SimpleMQ\AdminGeneratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Acme\AdminBundle\Form\AdminFormBuilder;


class CoreController extends Controller
{
    /**
     * [dashboardAction description]
     * 
     * @return [type] [description]
     */
    public function dashboardAction()
    {        
        $entityNames = $this->getEntitys();

        return $this->render(
            'SimpleMQAdminGeneratorBundle:Core:index.html.twig', 
            array(  'name' => 'OnDashboard',
                    'mappedEntitiesName' => $entityNames)
        );
    }
    
    /**
     * [sidebarAction description]
     * 
     * @return [type] [description]
     */
    public function sidebarAction()
    {
        $entityNames = $this->getEntitys();
        return $this->render(
            'SimpleMQAdminGeneratorBundle:Core:sidebar.html.twig', 
            array( 'mappedEntitiesName' => $entityNames)
        );
    }
    
    /**
     * [getEntitys description]
     * 
     * @return [type] [description]
     */
    public function getEntitys()
    {
        $entityNames = array();
        $adminPool = $this->container->get('simple_mq_admin_generator.adminpool');

        foreach ($adminPool->getClassEntities() AS $entityClass) {      
            $classParts = explode("\\", $entityClass);
            $entity['route'] = "admin_".implode('_', $classParts)."_list";
            $entity['name'] = array_pop($classParts);
            
            $entityNames[] = $entity;
        }
        return $entityNames;
    }
    
}    