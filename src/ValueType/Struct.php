<?php

namespace Odan\ValueType;

use Odan\ValueType\Exception\StructException;

/**
 * Struct
 */
class Struct
{

    /**
     * Magic method.
     *
     * @param string $name
     * @throws Exception
     */
    public function __get($name)
    {
        throw new StructException(sprintf("Cannot get undefined property (%s)", $name));
    }

    /**
     * Magic method.
     *
     * @param string $name
     * @throws Exception
     */
    public function __set($name, $value)
    {
        throw new StructException(sprintf("Cannot set undefined property (%s)%s", $name, $value = ''));
    }

}
