<?php

namespace Jprevo\Dual\DualBundle\Data;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\Mapping\ClassMetadata;
use Jprevo\Dual\DualBundle\Data\Form\DataTransformer\EntityToAssociationTransformer;
use Jprevo\Dual\DualBundle\Data\Form\Type\AssociationType;
use Jprevo\Dual\DualBundle\Data\Form\DataTransformer\EntitiesToAssociationTransformer;
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
     * @var Registry
     */
    protected $doctrine;

    /**
     * FormBuilder constructor.
     * @param FormFactory $formFactory
     */
    public function __construct(Registry $doctrine, FormFactory $formFactory, Mapper $mapper, TypeFinder $typeFinder)
    {
        $this->formFactory = $formFactory;
        $this->mapper = $mapper;
        $this->typeFinder = $typeFinder;
        $this->doctrine = $doctrine;
    }

    /**
     * @param mixed $entity
     * @param ClassMetadataProxy $meta
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    public function createBuilder($entity)
    {
        $mapper = $this->getMapper();
        $meta = $mapper->getMeta(get_class($entity));

        $builder = $this->getFormFactory()
            ->createBuilder(FormType::class, $entity, []);

        $em = $this->getDoctrine()
            ->getManagerForClass(get_class($entity));

        foreach ($meta->fieldMappings as $fieldName => $field) {
            $type = $this->getTypeFinder()->find($field['type']);

            if ($type === null) {
                continue;
            }

            if (!$meta->hasSetter($fieldName)) {
                continue;
            }

            $builder->add($fieldName, $type->getFormType($field), [
                'label' => $fieldName,
                'required' => false
            ]);
        }

        foreach ($meta->associationMappings as $assocName => $association) {
            if (!$association['isOwningSide']) {
                continue;
            }

            $builder->add($assocName, AssociationType::class, [
                'label' => $assocName,
                'association' => $association,
                'required' => false
            ]);

            if ($meta->isAssociationMultiple($assocName)) {
                $transformer = new EntitiesToAssociationTransformer($em, $mapper, $association);
            } else {
                $transformer = new EntityToAssociationTransformer($em, $mapper, $association);
            }

            $builder->get($assocName)->addModelTransformer($transformer);
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

    /**
     * @return Registry
     */
    protected function getDoctrine()
    {
        return $this->doctrine;
    }

}