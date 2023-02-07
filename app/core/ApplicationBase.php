<?php

namespace app\core;

use app\core\container\Container;

/**
 * Class ApplicationBase
 */
class ApplicationBase extends Container
{
    /**
     * Initialization multione container
     * @param $components
     * @return void
     */
    public function init($components)
    {
        parent::init($components);
    }

    /**
     * Get component
     * @param string $component
     * @return mixed|object|\ReflectionClass|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getComponent(string $component)
    {
        if (isset($this->components[$component]['method'])) {
            return $this->get($component)->{$this->components[$component]['method']}();
        }

        return $this->get($component);
    }

    /**
     * Sort components
     */
    protected function sortComponents()
    {
        $array = [];

        foreach ($this->components as $key => $value)
        {
            $array[$value['sort']] = $key;
        }

        ksort($array);

        return $array;
    }
}