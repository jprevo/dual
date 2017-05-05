<?php

namespace Jprevo\Dual\DualBundle\Mapping;

use Doctrine\ORM\Mapping\ClassMetadata;

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
     * @var string
     */
    protected $emName;

    /**
     * ClassMetadataProxy constructor.
     * @param ClassMetadata $source
     */
    public function __construct(ClassMetadata $source, $emName)
    {
        $this->source = $source;
        $this->emName = $emName;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        $parts = explode('\\', $this->getSource()->getName());

        return array_pop($parts);
    }

    /**
     * @return string
     */
    public function getParamName()
    {
        $name = $this->getSource()->getName();
        $name = str_replace('\\', '/', $name);
        $name = $this->getEmName() . ':' . $name;

        return $name;
    }

    /**
     * @return string
     */
    public function getEmName()
    {
        return $this->emName;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func([$this->getSource(), $name], $arguments);
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