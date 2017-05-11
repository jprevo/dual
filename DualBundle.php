<?php

namespace Jprevo\Dual\DualBundle;

use Jprevo\Dual\DualBundle\DependencyInjection\Compiler\TypePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DualBundle
 * @package Jprevo\Dual\DualBundle
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class DualBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new TypePass());

        $container->loadFromExtension('twig', array(
            'form_themes' => array(
                'DualBundle::form/association.html.twig',
            )
        ));
    }
}