<?php
namespace DoctrineExtensions\NestedSet\Node;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class Node
{
    /**
     * @var bool
     */
    public $hasManyRoots = false;

    /**
     * @var string
     */
    private $class;

    /**
     * @var NodeField[]
     */
    private $fields = [];

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * Get node field by type
     *
     * @param string $type
     * @return NodeField|null
     */
    public function getField($type)
    {
        return isset($this->fields[$type]) ? $this->fields[$type] : null;
    }

    /**
     * @param NodeField $field
     */
    public function addField(NodeField $field)
    {
        $this->fields[$field->getType()] = $field;
    }

    /**
     * @return bool
     */
    public function hasManyRoots()
    {
        return $this->hasManyRoots;
    }
}