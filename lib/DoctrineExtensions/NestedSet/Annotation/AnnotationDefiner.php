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

namespace DoctrineExtensions\NestedSet\Annotation;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;

/**
 * Class AnnotationDefiner
 * Parse and return NestedSetNode annotation, cache parsed annotations
 *
 * @package DoctrineExtensions\NestedSet\Annotation
 * @author Dmitriy Konev
 */
class AnnotationDefiner implements AnnotationDefinerInterface
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
     * Get NestedSetNode annotation by node class
     *
     * @param string $class
     * @return NestedSetNode
     */
    public function getNodeAnnotation($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        if (!array_key_exists($class, $this->nodes)) {
            $this->nodes[$class] = $this->findNodeAnnotation($class);
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

        return $this->annotationReader->getClassAnnotation(new \ReflectionClass($class), NestedSetNode::class);
    }
}
