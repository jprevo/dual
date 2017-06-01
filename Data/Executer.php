<?php

namespace Jprevo\Dual\DualBundle\Data;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Jprevo\Dual\DualBundle\Mapping\ClassMetadataProxy;

/**
 * Class Executer
 * @package Jprevo\Dual\DualBundle\Data
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class Executer
{

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * Executer constructor.
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param mixed $entity
     * @param ClassMetadataProxy $meta
     * @return mixed
     */
    public function save($entity)
    {
        $em = $this->getRegistry()
            ->getManagerForClass(get_class($entity));

        $em->persist($entity);
        $em->flush($entity);

        return $entity;
    }

    /**
     * @param Query $query
     * @return Result
     */
    public function execute(Query $query)
    {
        $class = $query->getClassName();
        $alias = $this->getAlias($class);

        $em = $this->getRegistry()->getManagerForClass($class);

        $qb = $em->createQueryBuilder();

        $qb->select($alias)
            ->from($class, $alias);

        $qb->setFirstResult($query->getFirstResult());
        $qb->setMaxResults($query->getResultsPerPage());

        if ($query->getSort()) {
            $qb->orderBy($alias.'.'.$query->getSort(), strtoupper($query->getSortOrder()));
        }

        $data = $qb->getQuery()->getResult();
        $dql = $qb->getDQL();

        $count = $qb->select('COUNT('.$alias.')')->setFirstResult(null)->getQuery()->getSingleScalarResult();

        $result = new Result($query, $data);
        $result->setDql($dql);
        $result->setTotal($count);

        return $result;
    }

    /**
     * @param $className
     * @param array $otherAliases
     * @return string
     */
    public function getAlias($className, array $otherAliases = [])
    {
        $parts = explode('\\', $className);
        $singleName = array_pop($parts);
        $first = $singleName{0};
        $first = strtolower($first);

        return $first;
    }

    /**
     * @return Registry
     */
    protected function getRegistry()
    {
        return $this->registry;
    }

}