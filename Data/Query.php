<?php

namespace Jprevo\Dual\DualBundle\Data;

use Jprevo\Dual\DualBundle\Mapping\Mapper;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Query
 * @package Jprevo\Dual\DualBundle\Data
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class Query
{

    const SORT_ORDER_ASC = 'asc';
    const SORT_ORDER_DESC = 'desc';

    /**
     * @var string
     */
    protected $className;

    /**
     * @var int
     */
    protected $page = 1;

    /**
     * @var int
     */
    protected $resultsPerPage = 10;

    /**
     * @var string
     */
    protected $sort;

    /**
     * @var string
     */
    protected $sortOrder;

    /**
     * @var string
     */
    protected $search;

    /**
     * Query constructor.
     * @param array $options
     * @throws QueryException
     */
    public function __construct(array $options)
    {
        if (empty($options['className'])) {
            throw new QueryException('The entity class name is required.');
        }

        foreach ($options as $spec => $value) {
            if (property_exists($this, $spec)) {
                $this->{$spec} = $value;
            }
        }

    }

    /**
     * @param Request $request
     * @return Query
     */
    public static function fromRequest(Request $request)
    {
        $options = [];

        if ($request->get('cl')) {
            $options['className'] = $request->get('cl');
        } else {
            $class = $request->get('class');
            $className = Mapper::paramToClass($class);
            $options['className'] = $className;
        }

        $options['sort'] = $request->get('so');
        $options['sortOrder'] = $request->get('ord');
        $options['page'] = $request->get('page');
        $options['search'] = $request->get('q');

        return new static($options);
    }

    /**
     * @return array
     */
    public function toParameters()
    {
        return [
            'cl' => $this->getClassName(),
            'page' => $this->getPage(),
            'so' => $this->getSort(),
            'ord' => $this->getSortOrder(),
            'q' => $this->getSearch()
        ];
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        if ($this->page < 1) {
            $this->page = 1;
        }

        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getFirstResult()
    {
        return ($this->getPage() - 1) * $this->getResultsPerPage();
    }

    /**
     * @return int
     */
    public function getResultsPerPage()
    {
        return $this->resultsPerPage;
    }

    /**
     * @param int $resultsPerPage
     */
    public function setResultsPerPage($resultsPerPage)
    {
        $this->resultsPerPage = $resultsPerPage;
    }

    /**
     * @return string
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param string $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * @return string
     */
    public function getSortOrder()
    {
        if ($this->sortOrder === null && $this->sort !== null) {
            return static::SORT_ORDER_ASC;
        }

        return $this->sortOrder;
    }

    /**
     * @param string $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    /**
     * @return string
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @param string $search
     */
    public function setSearch($search)
    {
        $this->search = $search;
    }

}