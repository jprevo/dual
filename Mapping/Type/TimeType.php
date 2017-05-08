<?php

namespace Jprevo\Dual\DualBundle\Mapping\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class TimeType
 * @package Jprevo\Dual\DualBundle\Mapping\Type
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class TimeType extends AbstractType
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'time';
    }

    /**
     * @inheritdoc
     */
    public function getFormType(array $field)
    {
        return \Symfony\Component\Form\Extension\Core\Type\TimeType::class;
    }

}