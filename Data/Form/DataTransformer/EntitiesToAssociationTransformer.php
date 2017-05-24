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
class EntitiesToAssociationTransformer extends AbstractEntityTransformer
{

    /**
     * @param array $entities
     * @return string
     */
    public function transform($entities)
    {
        return json_encode([]);
    }

    /**
     * @param string $ids
     * @return array
     */
    public function reverseTransform($ids)
    {
        if (empty($ids)) {
            return [];
        }

        $ids = json_decode($ids);

        if (empty($ids)) {
            return [];
        }

        $targetField = $this->associationToFieldName();
        $targetMeta = $this->getTargetMeta();

        $qb = $this->getEm()->createQueryBuilder();

        $qb->select('e')
            ->from($targetMeta->getName(), 'e')
            ->where('e.'.$targetField.' IN (:ids)')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }

}