<?php
namespace DoctrineExtensions\NestedSet\Node;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class NodeField
{
    const TYPE_LEFT = 'left';
    const TYPE_RIGHT = 'right';
    const TYPE_ROOT = 'root';
    const TYPE_ID = 'id';

    /**
     * @Enum({"left", "right", "root", "id"})
     */
    public $type;

    /**
     * @var \ReflectionProperty
     */
    private $property;
    
    /**
     * @var string
     */
    private $columnName;

    /**
     * @param \ReflectionProperty $property
     */
    public function setProperty(\ReflectionProperty $property)
    {
        $this->property = $property;
    }

    /**
     * Get table column of node field
     *
     * @return string
     */
    public function getColumnName()
    {
        return $this->columnName ?: $this->property->getName();
    }

    /**
     * Set table column name
     *
     * @param string $columnName
     */
    public function setColumnName($columnName)
    {
        $this->columnName = $columnName;
    }

    /**
     * Get type of node field (left, right or root)
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Return field value by given object
     *
     * @param object $object
     * @return int
     */
    public function getValue($object)
    {
        return $this->property->getValue($object);
    }

    /**
     * Set value on node field
     *
     * @param object $object
     * @param int $value
     */
    public function setValue($object, $value)
    {
        $this->property->setValue($object, $value);
    }
}