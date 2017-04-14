<?php
namespace DoctrineExtensions\NestedSet\Factory;

use Doctrine\ORM\EntityManager;
use DoctrineExtensions\NestedSet\Annotation\AnnotationDefiner;
use DoctrineExtensions\NestedSet\Config;
use DoctrineExtensions\NestedSet\Manager;

/**
 * Create and return instance of NestedSet Manager class.
 * Parse annotations and configure manager.
 *
 * @package DoctrineExtensions\NestedSet\Factory
 * @author Dmitriy Konev
 */
class Factory implements FactoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var AnnotationDefiner
     */
    private $annotationDefiner;

    /**
     * @var Manager[]
     */
    private $managers = [];

    /**
     * @var Config[]
     */
    private $configs = [];

    public function __construct(EntityManager $entityManager, AnnotationDefiner $annotationDefiner)
    {
        $this->entityManager = $entityManager;
        $this->annotationDefiner = $annotationDefiner;
    }

    /**
     * Create instance of manager by given class
     *
     * @param string $class
     * @return Manager
     */
    public function createManager($class)
    {
        if (!isset($this->managers[$class])) {
            $config = $this->createConfig($class);
            $this->managers[$class] = new Manager($config);
        }

        return $this->managers[$class];
    }

    /**
     * Create instance of Config class
     *
     * @param string $class
     * @return Config
     */
    public function createConfig($class)
    {
        if (!isset($this->configs[$class])) {
            $annotation = $this->annotationDefiner->getNodeAnnotation($class);
            $config = new Config($this->entityManager, $class);

            if ($annotation) {
                $config->setLeftFieldName($annotation->getLeftField());
                $config->setRightFieldName($annotation->getRightField());
                $config->setRootFieldName($annotation->getRootField());
            }

            $this->configs[$class] = $config;
        }

        return $this->configs[$class];
    }
}