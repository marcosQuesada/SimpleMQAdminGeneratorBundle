<?php

namespace SimpleMQ\AdminGeneratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CRUDController 
{
    protected $doctrine;
    protected $formFactory;
    protected $templating;
    protected $request;
    protected $router;
    protected $container;
    protected $adminEntity;
    protected $entity;
    protected $entityManager;
    protected $repository;
    protected $entityName;
 

    /**
     * Finds and displays a Test entity.
     * 
     * @param [type] $doctrine      [description]
     * @param [type] $container     [description]
     * @param [type] $formFactory   [description]
     * @param [type] $templating    [description]
     * @param [type] $request       [description]
     * @param [type] $router        [description]
     * @param [type] $adminPool     [description]
     * @param [type] $routeResolver [description]
     * 
     * @return void
     */    
    public function __construct( $doctrine, $container,                            FormFactoryInterface $formFactory,
        EngineInterface $templating,
        Request $request,
        RouterInterface $router,
        $adminPool,
        $routeResolver
    ) {
        $this->doctrine    = $doctrine;
        $this->container = $container;
        $this->formFactory = $formFactory;
        $this->templating  = $templating;
        $this->request     = $request;
        $this->router      = $router;
        $this->entityManager = $this->doctrine->getEntityManager();
        $this->entityClass = $routeResolver->getReferenceClass();
        $this->entityName = $routeResolver->getEntityName();
        $this->adminEntity = $adminPool->getAdminEntityServiceFromPool($this->entityName);
        $this->adminEntity->setContainer($this->container);
        $this->entity = $this->adminEntity->getEntityInstance();
        $this->repository = $this->entityManager->getRepository('\\'.$this->entityClass);  
    }    


    /**
     * [listAction description]
     * 
     * @return [type] [description]
     */
    public function listAction()
    {
        $entities = $this->repository->findAll();

        return $this->templating->renderResponse(
            'SimpleMQAdminGeneratorBundle:CRUD:index.html.twig', array(
                'entityName' => $this->entityName,
                'entities' => $entities,
                'entityRoutes' => $this->adminEntity->getEntityRoutes(),                
                'entityFields' => $this->adminEntity->getGridFields())
        );
    }


    /**
     * Finds and displays a Test entity.
     * 
     * @param [type] $id [description]
     * 
     * @return [type]     [description]
     */
    public function showAction($id)
    {
        $entity = $this->repository->find($id);
 
        if (!$entity) {
            throw new NotFoundHttpException('Unable to find entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->templating->renderResponse(
            'SimpleMQAdminGeneratorBundle:CRUD:show.html.twig', array(
                'entityName' => $this->entityName,
                'entity' => $entity,
                'entityRoutes' => $this->adminEntity->getEntityRoutes(),
                'entityFields' => $this->adminEntity->getShowFields(),
                'id' => $id,
                'delete_form' => $deleteForm->createView())
        );        
    }

    /**
     * [newAction description]
     * 
     * @return [type] [description]
     */
    public function newAction()
    {
        $formType = $this->adminEntity->getForm();
        
        $form = $this->formFactory->create($formType, $this->entity);

        return $this->templating->renderResponse(
            'SimpleMQAdminGeneratorBundle:CRUD:new.html.twig', array(
            'entityName' => $this->entityName,
            'entity' => $this->entity,
            'entityRoutes' => $this->adminEntity->getEntityRoutes(),
            'form'   => $form->createView())
        );

    }

    /**
     * [createAction description]
     * 
     * @return [type] [description]
     */
    public function createAction()
    {
        $formType = $this->adminEntity->getForm();
        
        $form = $this->formFactory->create($formType, $this->entity);        
        $form->bindRequest($this->request);
        
        if ($form->isValid()) {
            $em = $this->doctrine->getEntityManager();
            $em->persist($this->entity);
            $em->flush();
            $this->container->get('session')->setFlash('notice', 'Creation successfully!');
            $routes = $this->adminEntity->getEntityRoutes();

            $uri = $this->router->generate(
                $routes['show'], 
                array('id' => $this->entity->getId())
            );
            return new RedirectResponse($uri);    
            
        }        
        
        return $this->templating->renderResponse(
            'SimpleMQAdminGeneratorBundle:CRUD:new.html.twig', array(
                'entityName' => $this->entityName,
                'entity' => $this->entity,
                'entityRoutes' => $this->adminEntity->getEntityRoutes(),
                'form'   => $form->createView())
        );        
    
    }

    /**
     * [editAction description]
     * 
     * @param [type] $id [description]
     * 
     * @return [type]     [description]
     */
    public function editAction($id)
    {
        $entity = $this->repository->find($id);
 
        if (!$entity) {
            throw new NotFoundHttpException('Unable to find entity.');
        }
        $formType = $this->adminEntity->getForm();
        
        $form = $this->formFactory->create($formType, $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->templating->renderResponse(
            'SimpleMQAdminGeneratorBundle:CRUD:edit.html.twig', array(
                'entityName' => $this->entityName,
                'entity' => $this->entity,
                'entityRoutes' => $this->adminEntity->getEntityRoutes(),
                'form'   => $form->createView(),
                'delete_form' => $deleteForm->createView(), 
                'id' => $id)
        );        
    }

    /**
     * [updateAction description]
     * 
     * @param [type] $id [description]
     * 
     * @return [type]     [description]
     */
    public function updateAction($id)
    {
        $entity = $this->repository->find($id);
 
        if (!$entity) {
            throw new NotFoundHttpException('Unable to find entity.');
        }        
        $formType = $this->adminEntity->getForm();
        
        $form = $this->formFactory->create($formType, $entity);
        $form->bindRequest($this->request);
        $deleteForm = $this->createDeleteForm($id);        
      
        $form->bindRequest($this->request);
        
        if ($form->isValid()) {
            $em = $this->doctrine->getEntityManager();
            $em->persist($entity);
            $em->flush();
            $this->container->get('session')->setFlash('notice', 'Update successfully!');
            $routes = $this->adminEntity->getEntityRoutes();

            return new RedirectResponse($this->router->generate($routes['edit'], array('id' => $entity->getId())));            
        }          

        return $this->templating->renderResponse('SimpleMQAdminGeneratorBundle:CRUD:edit.html.twig', array(
            'entityName' => $this->entityName,
            'entity' => $this->entity,
            'entityRoutes' => $this->adminEntity->getEntityRoutes(),
            'form'   => $form->createView(),
            'delete_form' => $deleteForm->createView(), 
        ));        
    }

    /**
     * [deleteAction description]
     * 
     * @param [type] $id [description]
     * 
     * @return [type]     [description]
     */
    public function deleteAction($id)
    {          
        $form = $this->createDeleteForm($id);
        $form->bindRequest($this->request);

        if ($form->isValid()) {
            
            $entity = $this->repository->find($id);

            if (!$entity) {
                throw new NotFoundHttpException('Unable to find Test entity.');
            }
            $em = $this->doctrine->getEntityManager();
            $em->remove($entity);
            $em->flush();
            $this->container->get('session')->setFlash('notice', 'Delete successfully!');
        }
        $routes = $this->adminEntity->getEntityRoutes();
        
        return new RedirectResponse($this->router->generate($routes['list']));
    }

    /**
     * [createDeleteForm description]
     * 
     * @param [type] $id [description]
     * 
     * @return [type]     [description]
     */
    protected function createDeleteForm($id)
    {
        return  $this->formFactory->createBuilder('form')
            ->add('id', 'hidden')
            ->getForm();
    }    
}
