<?php

namespace Jprevo\Dual\DualBundle\Mapping\Type;
use Symfony\Component\Form\Extension\Core\Type\BaseType;

/**
 * Class AbstractType
 * @package Jprevo\Dual\DualBundle\Mapping\Type
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
abstract class AbstractType
{

    /**
     * The doctrine type name
     * @return string
     */
    abstract public function getName();

    /**
     * @param array $field
     * @return BaseType
     */
    abstract public function getFormType(array $field);

    /**
     * @param array $field
     * @return array
     */
    public function getFormFieldOptions(array $field)
    {
        return [];
    }

}