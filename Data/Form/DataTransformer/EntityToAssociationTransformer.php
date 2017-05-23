<?php

namespace Jprevo\Dual\DualBundle\Data\Form\DataTransformer;

use Doctrine\ORM\EntityManager;
use Jprevo\Dual\DualBundle\Mapping\ClassMetadataProxy;
use Jprevo\Dual\DualBundle\Mapping\Mapper;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class EntityToAssociationTransformer
 * @package Jprevo\Dual\DualBundle\Form\DataTransformer
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class EntityToAssociationTransformer implements DataTransformerInterface
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
    public function transform($entity)
    {
        if (null === $entity) {
            return null;
        }

        $id = null;

        return json_encode($id);
    }

    /**
     * @param string $ids
     * @return array
     */
    public function reverseTransform($id)
    {
        if (empty($id)) {
            return null;
        }

        $mapper = $this->getMapper();

        dump($this->association);exit();

        //$targetMapping = $mapper->getMeta($this->getEm()->)

        $qb = $this->getEm()->createQueryBuilder();
        $field = $this->getMeta()->identifier[0];

        $qb->select('e')
            ->from($this->getMeta()->getName(), 'e')
            ->where('e.'.$field.' = :id')
            ->setParameter('id', $id);

        var_dump($qb->getDQL());exit();

        return $qb->getQuery()->getSingleResult();
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