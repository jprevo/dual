<?php

namespace Jprevo\Dual\DualBundle\Mapping\Type;

use Symfony\Component\Form\Extension\Core\Type\NumberType;

/**
 * Class StringType
 * @package Jprevo\Dual\DualBundle\Mapping\Type
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class DecimalType extends AbstractType
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'decimal';
    }

    /**
     * @inheritdoc
     */
    public function getFormType(array $field)
    {
        return NumberType::class;
    }

}