<?php

namespace SimpleMQ\AdminGeneratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SimpleMQ\AdminGeneratorBundle\Admin\Admin; // @TODO: fuera y pasa a Service + Herencia
//
use SimpleMQ\AdminGeneratorBundle\Admin\Test;

class DefaultController extends Controller
{

    public function indexAction($name)
    {
        return $this->render('SimpleMQAdminGeneratorBundle:Default:index.html.twig', array('name' => $name));
    }
     
}
