<?php

namespace Jprevo\Dual\DualBundle\Mapping\Type;

/**
 * Class DateTimeType
 * @package Jprevo\Dual\DualBundle\Mapping\Type
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class DateTimeType extends AbstractType
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'datetime';
    }

    /**
     * @inheritdoc
     */
    public function getFormType(array $field)
    {
        return \Symfony\Component\Form\Extension\Core\Type\DateTimeType::class;
    }

}