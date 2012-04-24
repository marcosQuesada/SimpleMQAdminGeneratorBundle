<?php

namespace SimpleMQ\AdminGeneratorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use SimpleMQ\AdminGeneratorBundle\DependencyInjection\Compiler\AdminPoolCompilerPass;

class SimpleMQAdminGeneratorBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AdminPoolCompilerPass());
    }   
    
}    