<?php

namespace Jprevo\Dual\DualBundle\Data;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;

/**
 * Class Executer
 * @package Jprevo\Dual\DualBundle\Data
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class Executer
{

    /**
     * @var EntityManager[]
     */
    protected $ems = [];

    /**
     * Executer constructor.
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        foreach ($registry->getManagerNames() as $id => $name) {
            $this->ems[$id] = $registry->getManager($id);
        }
    }

    /**
     * @param Query $query
     * @return Result
     */
    public function execute(Query $query)
    {
        $class = $query->getClassName();
        $alias = $this->getAlias($class);

        $em = $this->getEm(
            $query->getEmName()
        );

        $qb = $em->createQueryBuilder();

        $qb->select($alias)
            ->from($class, $alias);

        $qb->setFirstResult(0);
        $qb->setMaxResults( $query->getResultsPerPage() );

        if ($query->getSort()) {
            $qb->orderBy($alias.'.'.$query->getSort(), strtoupper($query->getSortOrder()));
        }

        $data = $qb->getQuery()->getResult();
        $dql = $qb->getDQL();

        $count = $qb->select('COUNT('.$alias.')')->getQuery()->getSingleScalarResult();

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
     * @param $name
     * @return EntityManager
     */
    protected function getEm($name)
    {
        return $this->ems[$name];
    }

}