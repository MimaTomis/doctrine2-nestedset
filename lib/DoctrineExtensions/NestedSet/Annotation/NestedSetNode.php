<?php
namespace DoctrineExtensions\NestedSet\Annotation;

use DoctrineExtensions\NestedSet\Config;

/**
 * Annotation for nested set Node class.
 * Easy configuration node
 *
 * @see Config
 * @Annotation
 * @Target("CLASS")
 */
class NestedSetNode
{
    /**
     * Sets whether or not to hydrate the level field when fetching trees
     *
     * @var boolean
     */
    public $hydrateLevel = true;

    /**
     * Sets whether or not to hydrate the outline number when fetching trees
     *
     * @var boolean
     */
    public $hydrateOutlineNumber = true;

    /**
     * Sets the right field name
     *
     * @Required
     * @var string
     */
    public $leftField;

    /**
     * Sets the right field name
     *
     * @Required
     * @var string
     */
    public $rightField;

    /**
     * Sets the root field name
     *
     * @var string
     */
    public $rootField;

    /**
     * @return string
     */
    public function getLeftField()
    {
        return $this->leftField;
    }

    /**
     * @return string
     */
    public function getRightField()
    {
        return $this->rightField;
    }

    /**
     * @return string
     */
    public function getRootField()
    {
        return $this->rootField;
    }
}