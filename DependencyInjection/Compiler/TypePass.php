<?php

namespace Jprevo\Dual\DualBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class TypePass
 * @package Jprevo\Dual\DualBundle\DependencyInjection\Compiler
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class TypePass implements CompilerPassInterface
{

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('dual.type_finder')) {
            return;
        }

        $definition = $container->findDefinition('dual.type_finder');
        $taggedServices = $container->findTaggedServiceIds('dual.type');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('add', array(new Reference($id)));
        }
    }
}