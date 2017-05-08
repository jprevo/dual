<?php

namespace Jprevo\Dual\DualBundle\Data;

/**
 * Class Result
 * @package Jprevo\Dual\DualBundle\Data
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class Result
{

    /**
     * @var string
     */
    protected $dql;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var int
     */
    protected $total;

    /**
     * @var Query
     */
    protected $query;

    /**
     * Result constructor.
     * @param array $data
     */
    public function __construct(Query $query, array $data)
    {
        $this->query = $query;
        $this->data = $data;
    }

    /**
     * @param int $index
     * @param string $field
     * @return null
     */
    public function getValue($index, $field)
    {
        $getters = [
            'get' . ucfirst($field),
            'is' . ucfirst($field)
        ];

        foreach ($getters as $getter) {
            $entity = $this->data[$index];

            if (method_exists($entity, $getter)) {
                return $entity->$getter();
            }
        }

        return null;
    }

    /**
     * @return int
     */
    public function getPageCount()
    {
        return ceil($this->getTotal() / $this->getQuery()->getResultsPerPage());
    }

    /**
     * @return string
     */
    public function getDql()
    {
        return $this->dql;
    }

    /**
     * @param string $dql
     */
    public function setDql($dql)
    {
        $this->dql = $dql;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return Query
     */
    public function getQuery()
    {
        return $this->query;
    }

}
