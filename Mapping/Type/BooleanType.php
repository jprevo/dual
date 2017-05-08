<?php

namespace Jprevo\Dual\DualBundle\Mapping\Type;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

/**
 * Class BooleanType
 * @package Jprevo\Dual\DualBundle\Mapping\Type
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class BooleanType extends AbstractType
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'boolean';
    }

    /**
     * @inheritdoc
     */
    public function getFormType(array $field)
    {
        return CheckboxType::class;
    }

}