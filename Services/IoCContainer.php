<?php

namespace Services;

/**
 * Class IoCContainer
 * @package Services
 *
 * An instance built using the IoCContainer supports constructor dependency injection for both itself and its dependencies.
 * It also makes sure that services are always singletons, i.e. there is never more than one instance of any particular service.
 */
class IoCContainer {
  private $singletons = [];

  /**
   * Build an instance of a class.
   *
   * @param string $className
   * @param array $loadedClasses
   * @return object
   * @throws \Exception
   */
  public function build(string $className, $loadedClasses = [])
  {
    $reflector = $this->getReflector($className);
    $namespace = $reflector->getNamespaceName();
    $loadedClasses[] = $className;

    if ($namespace === 'Services' && isset($this->singletons[$className])) {
      return $this->singletons[$className];
    }

    $constructor = $reflector->getConstructor();

    if(is_null($constructor)) {
      return $this->createInstance($className, $namespace);
    }

    $dependencies = [];
    $parameters = $constructor->getParameters();
    foreach ($parameters as $parameter)
    {
      $paramClass = $parameter->getClass();
      if ($this->isValidDependency($paramClass, $className, $loadedClasses)) {
        $dependencies[] = $this->build($paramClass->name, $loadedClasses);
      }
    }

    return $this->createInstanceWithDependencies($className, $namespace, $reflector, $dependencies);
  }

  /**
   * Get a ReflectionClass for a class.
   *
   * @param string $className
   * @return \ReflectionClass
   * @throws \Exception
   */
  private function getReflector(string $className): \ReflectionClass
  {
    $reflector = new \ReflectionClass($className);

    if (!$reflector->isInstantiable()) {
      throw new \Exception("[$className] is not instantiable");
    }
    return $reflector;
  }

  /**
   * Create an instance of a class, without any dependencies.
   *
   * @param string $className
   * @param string $namespace
   * @return object
   */
  private function createInstance(string $className, string $namespace)
  {
    $instance = new $className;

    if ($namespace === 'Services') {
      $this->singletons[$className] = $instance;
    }

    return $instance;
  }

  /**
   * Checks if a dependency for a class is also a valid class.
   *
   * @param \ReflectionClass $paramClass
   * @param string $className
   * @param array $loadedClasses
   * @return boolean
   * @throws \Exception
   */
  private function isValidDependency(\ReflectionClass $paramClass, string $className, array $loadedClasses)
  {
    if (is_null($paramClass)) {
      throw new \Exception("Cannot resolve [$paramClass->name] in constructor of $className");
    } else {
      if ($paramClass->name === $className) {
        throw new \Exception("Cannot inject class $className into itself");
      } else if (in_array($paramClass->name, $loadedClasses)) {
        throw new \Exception("Cyclic dependency detected for $paramClass->name in $className");
      }

      return true;
    }
  }

  /**
   * Create an instance of a class, with dependencies injected.
   *
   * @param string $className
   * @param string $namespace
   * @param \ReflectionClass $reflector
   * @param array $dependencies
   * @return object
   */
  private function createInstanceWithDependencies(string $className, string $namespace, \ReflectionClass $reflector, array $dependencies)
  {
    $instance = $reflector->newInstanceArgs($dependencies);

    if ($namespace === 'Services') {
      $this->singletons[$className] = $instance;
    }

    return $instance;
  }
}
