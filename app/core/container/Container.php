<?php

namespace app\core\container;

use app\core\container\exception\NotFoundException;
use Psr\Container\ContainerInterface;
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

        return $this->getInstance($item, $this->components[$id]['params']);
    }

    public function add(string $id, array $params = [])
    {
        $this->components[$id]['params'] = $params;

        return $this->get($id);
    }

    public function has(string $id): bool
    {
        try {
            $item = $this->resolve($id);
        } catch (NotFoundException $e) {
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
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getInstance(ReflectionClass $item, $params = [])
    {
        $constructor = $item->getConstructor();

        if (is_null($constructor) || $constructor->getNumberOfRequiredParameters() == 0) {
            return $item->newInstance();
        }

        if (count($params) < 1) {
            $params = [];
            foreach ($constructor->getParameters() as $param) {
                if ($type = $param->getType()) {
                    $params[] = $this->get($type->getName());
                }
            }
        }

        return $item->newInstanceArgs($params);
    }

    private function __clone()
    {
    }
}