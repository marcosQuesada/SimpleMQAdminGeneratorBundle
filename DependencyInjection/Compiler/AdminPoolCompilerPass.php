<?php

namespace SimpleMQ\AdminGeneratorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class AdminPoolCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('simple_mq_admin_generator.adminpool')) {
            return;
        }

        $definition = $container->getDefinition('simple_mq_admin_generator.adminpool');

        foreach ($container->findTaggedServiceIds('admin.pool') as $id => $attributes) {
            $definition->addMethodCall('addMappedEntity', array($id, new Reference($id)));          
        }
    }
}