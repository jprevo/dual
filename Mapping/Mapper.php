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

    protected $registry;

    /**
     * Mapper constructor.
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param string $emName
     * @param string $className
     * @return ClassMetadataProxy
     * @throws DualException
     */
    public function getMeta($className)
    {
        $em = $this->getRegistry()->getManagerForClass($className);
        $meta = $em->getMetadataFactory()->getMetadataFor($className);

        return new ClassMetadataProxy($meta);
    }

    /**
     * @param $emName
     * @param $className
     * @return string
     */
    public static function classToParam($className)
    {
        return str_replace('\\', '/', $className);
    }

    /**
     * @param $param
     * @return array
     */
    public static function paramToClass($param)
    {
        return str_replace('/', '\\', $param);
    }

    /**
     * Get class metadata in a tree with EntityManager as index
     * then class namespace as sub index
     * @return array
     */
    public function getTree()
    {
        $tree = [];
        $ems = $this->getRegistry()->getManagers();

        // Create the tree
        foreach ($ems as $name => $em) {
            $tree[$name] = [];

            /** @var ClassMetadata $metadata */
            foreach ($em->getMetadataFactory()->getAllMetadata() as $metadata) {
                $ns = $metadata->namespace;

                if (!isset($tree[$name][$ns])) {
                    $tree[$name][$ns] = [];
                }

                $tree[$name][$ns][] = new ClassMetadataProxy($metadata);
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

    /**
     * @return Registry
     */
    protected function getRegistry()
    {
        return $this->registry;
    }

}