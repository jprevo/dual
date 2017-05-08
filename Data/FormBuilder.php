<?php

namespace Jprevo\Dual\DualBundle\Data;

use Jprevo\Dual\DualBundle\Mapping\ClassMetadataProxy;
use Jprevo\Dual\DualBundle\Mapping\Mapper;
use Jprevo\Dual\DualBundle\Mapping\Type\TypeFinder;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactory;

/**
 * Class FormBuilder
 * @package Jprevo\Dual\DualBundle\Data
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class FormBuilder
{

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var Mapper
     */
    protected $mapper;

    /**
     * @var TypeFinder
     */
    protected $typeFinder;

    /**
     * FormBuilder constructor.
     * @param FormFactory $formFactory
     */
    public function __construct(FormFactory $formFactory, Mapper $mapper, TypeFinder $typeFinder)
    {
        $this->formFactory = $formFactory;
        $this->mapper = $mapper;
        $this->typeFinder = $typeFinder;
    }

    /**
     * @param mixed $entity
     * @param ClassMetadataProxy $meta
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    public function createBuilder($entity, ClassMetadataProxy $meta)
    {
        $meta = $this->getMapper()->getMeta($meta->getEmName(), get_class($entity));

        $builder = $this->getFormFactory()
            ->createBuilder(FormType::class, $entity, []);

        foreach ($meta->fieldMappings as $fieldName => $field) {
            $type = $this->getTypeFinder()->find($field['type']);

            if ($type === null) {
                continue;
            }

            $builder->add($fieldName, $type->getFormType($field), [
                'label' => $fieldName
            ]);
        }

        return $builder;
    }

    /**
     * @return FormFactory
     */
    protected function getFormFactory()
    {
        return $this->formFactory;
    }

    /**
     * @return Mapper
     */
    protected function getMapper()
    {
        return $this->mapper;
    }

    /**
     * @return TypeFinder
     */
    protected function getTypeFinder()
    {
        return $this->typeFinder;
    }

}