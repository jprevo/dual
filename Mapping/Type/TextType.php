<?php

namespace Jprevo\Dual\DualBundle\Mapping\Type;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class TextType
 * @package Jprevo\Dual\DualBundle\Mapping\Type
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class TextType extends AbstractType
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'text';
    }

    /**
     * @inheritdoc
     */
    public function getFormType(array $field)
    {
        return TextareaType::class;
    }

}