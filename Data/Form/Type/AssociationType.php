<?php

namespace Jprevo\Dual\DualBundle\Data\Form\Type;

use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AssociationType
 * @package Jprevo\Dual\DualBundle\Data\Form\Type
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class AssociationType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'association',
            'emName'
        ]);

        $resolver->setRequired('association');
        $resolver->setRequired('emName');
    }

    /**
     * @inheritdoc
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $multiple = false;

        switch ($options['association']['type']) {
            case ClassMetadata::MANY_TO_MANY :
            case ClassMetadata::ONE_TO_MANY :
                $multiple = true;
                break;
            case ClassMetadata::MANY_TO_ONE :
            case ClassMetadata::ONE_TO_ONE :
            default:
                $multiple = false;
                break;
        }

        $view->vars['multiple'] = $multiple;
        $view->vars['association'] = $options['association'];
        $view->vars['em_name'] = $options['emName'];
    }

}
