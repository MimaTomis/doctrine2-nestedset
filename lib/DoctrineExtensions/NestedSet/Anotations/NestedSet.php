<?php
namespace DoctrineExtensions\NestedSet\Annotations;

/**
 * @Annotation
 * @Target("CLASS")
 */
class NestedSet
{
    /**
     * @var string name of left field
     */
    public $leftField;

    /**
     * @var string name of right field
     */
    public $rightField;

    /**
     * @var string name of root field
     */
    public $rootField;
}