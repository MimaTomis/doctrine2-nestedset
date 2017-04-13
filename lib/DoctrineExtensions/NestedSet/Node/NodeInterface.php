<?php
namespace DoctrineExtensions\NestedSet\Node;

interface NodeInterface
{
    /**
     * Get value of ID field
     *
     * @return mixed
     */
    public function getId();

    /**
     * Get value of left field
     *
     * @return int
     */
    public function getNsLeft();

    /**
     * Set value of left field
     *
     * @param int $value
     */
    public function setNsLeft($value);

    /**
     * Get value of right field
     *
     * @return int
     */
    public function getNsRight();

    /**
     * Set value of right field
     *
     * @param int $value
     */
    public function setNsRight($value);

    /**
     * Get value of root field
     *
     * @return mixed
     */
    public function getNsRoot();

    /**
     * Set value of root field
     *
     * @param mixed $value
     */
    public function setNsRoot($value);

    /**
     * Add child node
     *
     * @param NodeInterface $node
     */
    public function addChild(NodeInterface $node);

    /**
     * Get list of child nodes
     *
     * @return NodeInterface[]
     */
    public function getChildren();
}