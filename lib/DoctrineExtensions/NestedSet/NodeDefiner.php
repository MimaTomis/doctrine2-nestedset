<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL.
 */

namespace DoctrineExtensions\NestedSet;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Column;
use DoctrineExtensions\NestedSet\Node\Node;
use DoctrineExtensions\NestedSet\Node\NodeField;

/**
 * The Config class holds configuration for each NestedSet Manager instance.
 *
 * @author  Brandon Turner <bturner@bltweb.net>
 */
class NodeDefiner
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * @var Node[]
     */
    private $nodes = [];

    /**
     * @param EntityManager $entityManager
     * @param AnnotationReader $annotationReader
     */
    public function __construct(EntityManager $entityManager, AnnotationReader $annotationReader)
    {
        $this->entityManager = $entityManager;
        $this->annotationReader = $annotationReader;
    }

    /**
     * Get node
     *
     * @param string $class
     * @return Node
     */
    public function getNode($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        if (!isset($this->nodes[$class])) {
            $this->nodes[$class] = $this->createNode($class);
        }

        return $this->nodes[$class];
    }

    /**
     * @param string $class
     * @return Node
     */
    protected function createNode($class)
    {
        if (!class_exists($class)) {
            throw new \InvalidArgumentException('Parameter "$class" must contain name of existent class');
        }

        $class = new \ReflectionClass($class);
        $node = $this->annotationReader->getClassAnnotation($class, Node::class);

        if (!$node) {
            throw new \InvalidArgumentException('Parameter "$class" must be nested set node');
        }

        $node->setClass($class);
        $this->setFields($node, $class);

        return $node;
    }

    /**
     * Find annotations of node fields. Apply node fields to node.
     *
     * @param Node $node
     * @param \ReflectionClass $class
     */
    protected function setFields(Node $node, \ReflectionClass $class)
    {
        $properties = $class->getProperties();

        foreach ($properties as $property) {
            $annotations = $this->annotationReader->getPropertyAnnotations($property);
            $nodeField = null;
            $column = null;

            foreach ($annotations as $annotation) {
                if ($annotation instanceof NodeField) {
                    $nodeField = $annotation;
                } elseif ($annotation instanceof Column) {
                    $column = $annotation;
                }
            }

            if ($nodeField) {
                $nodeField->setProperty($property);

                if ($column && $column->name) {
                    $nodeField->setColumnName($column->name);
                }

                $node->addField($nodeField);
            }
        }
    }
}
