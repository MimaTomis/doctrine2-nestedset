<?php
namespace DoctrineExtensions\NestedSet\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class NestedSetNode
{
    /**
     * @var boolean
     */
    public $hasManyRoots = true;

    /**
     * @Required
     * @var string
     */
    public $leftField = 'ns_left';

    /**
     * @Required
     * @var string
     */
    public $rightField = 'ns_right';

    /**
     * @Required
     * @var string
     */
    public $rootField = 'ns_root';

    /**
     * @return bool
     */
    public function hasManyRoots()
    {
        return $this->hasManyRoots;
    }

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