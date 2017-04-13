<?php
namespace DoctrineExtensions\NestedSet\Node;

abstract class BaseNode implements NodeInterface
{
    /**
     * @ID
     * @var int
     */
    private $id;

    /**
     * @Column(type="integer", name="ns_left")
     * @var int
     */
    private $nsLeft;

    /**
     * @Column(type="integer", name="ns_right")
     * @var int
     */
    private $nsRight;

    /**
     * @Column(type="integer", name="ns_root")
     * @var int
     */
    private $nsRoot;

    /**
     * @var NodeInterface[]
     */
    private $children = [];

    /**
     * Get value of ID field
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get value of left field
     *
     * @return int
     */
    public function getNsLeft()
    {
        return $this->nsLeft;
    }

    /**
     * Set value of left field
     *
     * @param int $value
     */
    public function setNsLeft($value)
    {
        $this->nsLeft = $value;
    }

    /**
     * Get value of right field
     *
     * @return int
     */
    public function getNsRight()
    {
        return $this->nsRight;
    }

    /**
     * Set value of right field
     *
     * @param int $value
     */
    public function setNsRight($value)
    {
        $this->nsRight = $value;
    }

    /**
     * Get value of root field
     *
     * @return mixed
     */
    public function getNsRoot()
    {
        return $this->nsRoot;
    }

    /**
     * Set value of root field
     *
     * @param mixed $value
     */
    public function setNsRoot($value)
    {
        $this->nsRoot = $value;
    }

    /**
     * Add child node
     *
     * @param NodeInterface $node
     */
    public function addChild(NodeInterface $node)
    {
        $this->children[] = $node;
    }

    /**
     * Get list of child nodes
     *
     * @return NodeInterface[]
     */
    public function getChildren()
    {
        return $this->children;
    }
}