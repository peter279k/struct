<?php

namespace Odan\ValueType;

use Odan\ValueType\Exception\StructException;

/**
 * Struct trait
 */
trait StructTrait
{

    /**
     * Magic method.
     *
     * @param string $name
     * @throws Exception
     */
    public function __get($name)
    {
        $vars = get_class_vars(get_class($this));
        if (array_key_exists($name, $vars)) {
            $this->{$name} = null;
        } else {
            throw new StructException(sprintf("Property [%s] doesn't exist for class [%s].", $name, get_class($this)));
        }
    }

    /**
     * Magic method.
     *
     * @param string $name
     * @throws Exception
     */
    public function __set($name, $value)
    {
        $vars = get_class_vars(get_class($this));
        if (array_key_exists($name, $vars)) {
            $this->{$name} = null;
        } else {
            throw new StructException(sprintf("Property [%s] doesn't exist for class [%s]. Cannot set value [%s].", $name, get_class($this), $value));
        }
    }

    /**
     * Magic method.
     *
     * @param string $name
     * @throws Exception
     */
    public function __isset($name)
    {
        $vars = get_class_vars(get_class($this));
        if (array_key_exists($name, $vars)) {
            $this->{$name} = null;
        } else {
            throw new StructException(sprintf("Property [%s] doesn't exist for class [%s].", $name, get_class($this)));
        }
    }

    /**
     * Magic method.
     *
     * @param string $name
     * @throws Exception
     */
    public function __unset($name)
    {
        throw new StructException(sprintf("Property [%s] doesn't exist for class [%s].", $name, get_class($this)));
    }

}
