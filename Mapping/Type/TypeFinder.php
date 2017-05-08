<?php

namespace Jprevo\Dual\DualBundle\Mapping\Type;

/**
 * Class TypeFinder
 * @package Jprevo\Dual\DualBundle\Mapping\Type
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class TypeFinder
{

    /**
     * @var AbstractType[]
     */
    protected $types = [];

    /**
     * @param $name
     * @return AbstractType|null
     */
    public function find($name)
    {
        return isset($this->types[$name]) ? $this->types[$name] : null;
    }

    /**
     * @param AbstractType $type
     */
    public function add(AbstractType $type)
    {
        $this->types[$type->getName()] = $type;
    }

}