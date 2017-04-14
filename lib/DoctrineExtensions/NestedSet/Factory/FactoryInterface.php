<?php
namespace DoctrineExtensions\NestedSet\Factory;

use DoctrineExtensions\NestedSet\Manager;

/**
 * Interface NestedSetFactoryInterface
 * @package DoctrineExtensions\NestedSet\Factory
 * @author Dmitriy Konev
 */
interface FactoryInterface
{
    /**
     * Create instance of manager by given class
     *
     * @param string $class
     * @return Manager
     */
    public function createManager($class);
}