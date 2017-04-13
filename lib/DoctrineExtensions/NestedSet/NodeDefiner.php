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
use DoctrineExtensions\NestedSet\Annotation\NestedSetNode;
use DoctrineExtensions\NestedSet\Node\NodeInterface;

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
     * @var NestedSetNode[]
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
     * @return NestedSetNode
     */
    public function getNodeAnnotation($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        if (!isset($this->nodes[$class])) {
            $nodeAnnotation = $this->findNodeAnnotation($class);
            $this->nodes[$class] = $nodeAnnotation ?: $this->getDefaultNodeAnnotation($class);
        }

        return $this->nodes[$class];
    }

    /**
     * @param string $class
     * @return NestedSetNode
     */
    protected function findNodeAnnotation($class)
    {
        if (!class_exists($class)) {
            throw new \InvalidArgumentException('Parameter "$class" must contain name of existent class');
        }

        if (!is_subclass_of($class, NodeInterface::class)) {
            throw new \InvalidArgumentException(sprintf('Parameter "$class" must implement "%s" interface', NodeInterface::class));
        }

        return $this->annotationReader->getClassAnnotation(new \ReflectionClass($class), NestedSetNode::class);
    }

    /**
     * @param string $class
     * @return NestedSetNode
     */
    protected function getDefaultNodeAnnotation($class)
    {
        return new NestedSetNode();
    }
}
