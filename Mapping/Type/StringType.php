<?php

namespace Jprevo\Dual\DualBundle\Mapping\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class StringType
 * @package Jprevo\Dual\DualBundle\Mapping\Type
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class StringType extends AbstractType
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'string';
    }

    /**
     * @inheritdoc
     */
    public function getFormType(array $field)
    {
        return TextType::class;
    }

}