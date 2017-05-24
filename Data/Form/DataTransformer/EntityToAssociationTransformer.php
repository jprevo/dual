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
class EntityToAssociationTransformer extends AbstractEntityTransformer
{

    /**
     * @param array $entities
     * @return string
     */
    public function transform($entity)
    {
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

        $id = json_decode($id);

        if (empty($id)) {
            return null;
        }

        $targetField = $this->associationToFieldName();
        $targetMeta = $this->getTargetMeta();

        $qb = $this->getEm()->createQueryBuilder();

        $qb->select('e')
            ->from($targetMeta->getName(), 'e')
            ->where('e.'.$targetField.' = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

}