<?php
namespace DoctrineExtensions\NestedSet\Annotation;

/**
 * Interface AnnotationDefinerInterface
 * Parse and return NestedSetNode annotation, cache parsed annotations
 *
 * @package DoctrineExtensions\NestedSet\Annotation
 * @author Dmitriy Konev
 */
interface AnnotationDefinerInterface
{
    /**
     * Get NestedSetNode annotation by node class
     *
     * @param string $class
     * @return NestedSetNode
     */
    public function getNodeAnnotation($class);
}