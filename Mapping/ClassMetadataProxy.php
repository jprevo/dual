<?php

namespace Jprevo\Dual\DualBundle\Mapping;

use Doctrine\ORM\Mapping\ClassMetadata;
use Jprevo\Dual\DualBundle\Exception\DualException;

/**
 * Class ClassMetadataProxy
 * @package Jprevo\Dual\DualBundle\Mapping
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class ClassMetadataProxy
{

    /**
     * @var ClassMetadata
     */
    protected $source;

    /**
     * ClassMetadataProxy constructor.
     * @param ClassMetadata $source
     */
    public function __construct(ClassMetadata $source)
    {
        $this->source = $source;
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function findSingleId($entity)
    {
        $identifier = $this->identifier[0];
        $getter = 'get'.ucfirst($identifier);
        $id = $entity->$getter();

        return $id;
    }

    /**
     * @param $entity
     * @return string
     */
    public function findId($entity)
    {
        $id = [];

        foreach ($this->identifier as $identifier) {
            $getter = 'get'.ucfirst($identifier);
            $id[] = $entity->$getter();
        }

        return join('-', $id);
    }

    /**
     * @param array $id
     * @return array
     * @throws DualException
     */
    public function getFindCriterion(array $id)
    {
        $criterion = [];

        if (sizeof($id) !== sizeof($this->identifier)) {
            throw new DualException("Incomplete identifier, cannot extract lookup criterion.");
        }

        foreach ($this->identifier as $i => $identifier) {
            $criterion[$identifier] = $id[$i];
        }

        return $criterion;
    }

    /**
     * @param string $associationName
     * @return bool
     */
    public function isAssociationMultiple($associationName)
    {
        $association = $this->associationMappings[$associationName];
        $type = $association['type'];

        if ($type === ClassMetadata::ONE_TO_MANY || $type === ClassMetadata::MANY_TO_MANY) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        $parts = explode('\\', $this->getName());

        return array_pop($parts);
    }

    /**
     * @return string
     */
    public function getParamName()
    {
        return Mapper::classToParam($this->getName());
    }

    /**
     * @return bool
     */
    public function hasDistinctRootEntity()
    {
        return $this->rootEntityName !== $this->name;
    }

    /**
     * @param $field
     * @return bool
     */
    public function hasSetter($field)
    {
        $setter = 'set'.ucfirst($field);
        $className = $this->getName();

        return method_exists($className, $setter);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->getSource(), $name)) {
            return call_user_func([$this->getSource(), $name], $arguments);
        }

        return $this->__get($name);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->getSource()->{$name};
    }

    /**
     * @return ClassMetadata
     */
    protected function getSource()
    {
        return $this->source;
    }

}