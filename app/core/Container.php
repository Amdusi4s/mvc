<?php

namespace app\core;

use Psr\Container\ContainerInterface;
use app\core\exception\NotFoundContainerException;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{
    private array $services = [];
    public array $components = [];

    public function init($components)
    {
        $this->components = $components;
    }

    public function get($id)
    {
        $item = $this->resolve($this->components[$id]['class']);
        if (!($item instanceof ReflectionClass)) {
            return $item;
        }
        return $this->getInstance($item);
    }

    public function has(string $id): bool
    {
        try {
            $item = $this->resolve($id);
        } catch (NotFoundContainerException $e) {
            return false;
        }
        if ($item instanceof ReflectionClass) {
            return $item->isInstantiable();
        }
        return isset($item);
    }

    public function set(string $key, $value)
    {
        $this->services[$key] = $value;
        return $this;
    }

    private function resolve($id)
    {
        try {
            $name = $id;
            if (isset($this->services[$id])) {
                $name = $this->services[$id];
                if (is_callable($name)) {
                    return $name();
                }
            }
            return (new ReflectionClass($name));
        } catch (ReflectionException $e) {
            throw new NotFoundContainerException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getInstance(ReflectionClass $item)
    {
        $constructor = $item->getConstructor();

        if (is_null($constructor) || $constructor->getNumberOfRequiredParameters() == 0) {
            return $item->newInstance();
        }
        $params = [];
        foreach ($constructor->getParameters() as $param) {
            if ($type = $param->getType()) {
                $params[] = $this->get($type->getName());
            }
        }
        return $item->newInstanceArgs($params);
    }
}