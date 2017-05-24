<?php

namespace Jprevo\Dual\DualBundle\Data\Form\DataTransformer;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Jprevo\Dual\DualBundle\Mapping\ClassMetadataProxy;
use Jprevo\Dual\DualBundle\Mapping\Mapper;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class EntityToAssociationTransformer
 * @package Jprevo\Dual\DualBundle\Form\DataTransformer
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
abstract class AbstractEntityTransformer implements DataTransformerInterface
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Mapper
     */
    protected $mapper;

    /**
     * @var ClassMetadataProxy
     */
    protected $association;

    /**
     * EntityToAssociationTransformer constructor.
     * @param EntityManager $em
     * @param Mapper $mapper
     */
    public function __construct(EntityManager $em, Mapper $mapper, array $association)
    {
        $this->em = $em;
        $this->mapper = $mapper;
        $this->association = $association;
    }

    /**
     * @return string
     */
    protected function associationToFieldName()
    {
        if ($this->association['type'] === ClassMetadata::MANY_TO_MANY) {
            $joinColumn = $this->association['joinTable']['joinColumns'][0];
        } else {
            $joinColumn = $this->association['joinColumns'][0];
        }

        $targetColumn = $joinColumn['referencedColumnName'];
        $targetMeta = $this->getTargetMeta();

        return $targetMeta->columnNames[$targetColumn];
    }

    /**
     * @return ClassMetadataProxy
     */
    protected function getTargetMeta()
    {
        return $this->getMapper()
            ->getMeta($this->association['targetEntity']);
    }


    /**
     * @return EntityManager
     */
    protected function getEm()
    {
        return $this->em;
    }

    /**
     * @return Mapper
     */
    protected function getMapper()
    {
        return $this->mapper;
    }

}