<?php

namespace Jprevo\Dual\DualBundle\Mapping\Type;

/**
 * Class IntegerType
 * @package Jprevo\Dual\DualBundle\Mapping\Type
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class IntegerType extends AbstractType
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'integer';
    }

    /**
     * @inheritdoc
     */
    public function getFormType(array $field)
    {
        return \Symfony\Component\Form\Extension\Core\Type\IntegerType::class;
    }

}