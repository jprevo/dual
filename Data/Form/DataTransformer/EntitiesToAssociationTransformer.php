<?php

namespace Jprevo\Dual\DualBundle\Data\Form\DataTransformer;

use Doctrine\ORM\EntityManager;
use Jprevo\Dual\DualBundle\Mapping\ClassMetadataProxy;
use Jprevo\Dual\DualBundle\Mapping\Mapper;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class EntitiesToAssociationTransformer
 * @package Jprevo\Dual\DualBundle\Form\DataTransformer
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class EntitiesToAssociationTransformer implements DataTransformerInterface
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
     * @param array $entities
     * @return string
     */
    public function transform($entities)
    {
        if (empty($entities)) {
            return json_encode([]);
        }

        $ids = [];

        foreach ($entities as $entity) {
            $id = $this->getMeta()->findId($entity);
            $ids[] = $id;
        }

        return json_encode($ids);
    }

    /**
     * @param string $ids
     * @return array
     */
    public function reverseTransform($ids)
    {
        $ids = json_decode($ids, true);

        if (empty($ids)) {
            return [];
        }

        $qb = $this->getEm()->createQueryBuilder();
        $field = $this->getMeta()->identifier[0];

        $qb->select('e')
            ->from($this->getMeta()->getName(), 'e')
            ->where('e.'.$field.' IN (:ids)')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }

    /**
     * @return EntityManager
     */
    protected function getEm()
    {
        return $this->em;
    }

    /**
     * @return ClassMetadataProxy
     */
    protected function getMeta()
    {
        return $this->meta;
    }

}