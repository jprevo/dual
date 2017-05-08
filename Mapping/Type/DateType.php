<?php

namespace Jprevo\Dual\DualBundle\Mapping\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class DateType
 * @package Jprevo\Dual\DualBundle\Mapping\Type
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class DateType extends AbstractType
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'date';
    }

    /**
     * @inheritdoc
     */
    public function getFormType(array $field)
    {
        return \Symfony\Component\Form\Extension\Core\Type\DateType::class;
    }

}