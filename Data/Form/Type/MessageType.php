<?php

namespace Jprevo\Dual\DualBundle\Data\Form\Type;

use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MessageType
 * @package Jprevo\Dual\DualBundle\Data\Form\Type
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class MessageType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'message' => ''
        ]);

        $resolver->setRequired('message');
    }

    /**
     * @inheritdoc
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['message'] = $options['message'];
    }

}
