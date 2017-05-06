<?php

namespace Jprevo\Dual\DualBundle\Mapping;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Jprevo\Dual\DualBundle\Exception\DualException;

/**
 * Class Mapper
 * @package Jprevo\Dual\DualBundle\Mapping
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class Mapper
{

    /**
     * @var EntityManager[]
     */
    protected $ems = [];

    /**
     * Mapper constructor.
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        foreach ($registry->getManagerNames() as $id => $name) {
            $this->ems[$id] = $registry->getManager($id);
        }
    }

    /**
     * @param string $paramClass
     * @return ClassMetadataProxy
     * @throws DualException
     */
    public function getMetaFromParam($paramClass)
    {
        list($emName, $class) = explode(':', $paramClass);
        $class = str_replace('/', '\\', $class);

        if (!isset($this->ems[$emName])) {
            throw new DualException(sprintf('Unable to find the Entity Manager "%s".', $emName));
        }

        $em = $this->ems[$emName];

        $meta = $em->getMetadataFactory()->getMetadataFor($class);

        return new ClassMetadataProxy($meta, $emName);
    }

    /**
     * @param string $emName
     * @param string $className
     * @return ClassMetadataProxy
     * @throws DualException
     */
    public function getMeta($emName, $className)
    {
        if (!isset($this->ems[$emName])) {
            throw new DualException(sprintf('Unable to find the Entity Manager "%s".', $emName));
        }

        $em = $this->ems[$emName];
        $meta = $em->getMetadataFactory()->getMetadataFor($className);

        return new ClassMetadataProxy($meta, $emName);
    }

    /**
     * Get class metadata in a tree with EntityManager as index
     * then class namespace as sub index
     * @return array
     */
    public function getTree()
    {
        $tree = [];

        // Create the tree
        foreach ($this->ems as $name => $em) {
            $tree[$name] = [];

            /** @var ClassMetadata $metadata */
            foreach ($em->getMetadataFactory()->getAllMetadata() as $metadata) {
                $ns = $metadata->namespace;

                if (!isset($tree[$name][$ns])) {
                    $tree[$name][$ns] = [];
                }

                $tree[$name][$ns][] = new ClassMetadataProxy($metadata, $name);
            }
        }

        // Sort the tree alphabetically
        ksort($tree);

        foreach ($tree as $emName => $namespaces) {
            ksort($tree[$emName]);

            foreach ($namespaces as $ns => $meta) {
                usort($tree[$emName][$ns], function(ClassMetadataProxy $meta1, ClassMetadataProxy $meta2) {
                    return strcmp($meta1->getName(), $meta2->getName());
                });
            }
        }

        return $tree;
    }

}