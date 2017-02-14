<?php

namespace Odan\Test;

use Odan\ValueType\Struct;
use Odan\Test\Struct\User;
use PHPUnit\Framework\TestCase;

/**
 * ContainerTest
 *
 * @coversDefaultClass Odan\ValueType\Struct
 */
class ContainerTest extends TestCase
{

    /**
     * Test create object.
     *
     * @return void
     * @covers ::__set
     */
    public function testInstance()
    {
        $this->assertInstanceOf(Struct::class, new Struct());
    }

    /**
     * Test undefined property.
     *
     * @covers ::__get
     * @expectedException Odan\ValueType\Exception\StructException
     */
    public function testGet()
    {
        $user = new User();
        $user->username = 'bob';
        $user->email = 'bob@example.com';

        // Get undefined property
        $value = $user->nada;
    }

    /**
     * Test undefined property.
     *
     * @expectedException Odan\ValueType\Exception\StructException
     */
    public function testSet()
    {
        $user = new User();
        $user->username = 'bob';
        $user->email = 'bob@example.com';

        // Set undefined property
        $user->nada = 'not existing field';
    }

    /**
     * Test isset.
     */
    public function testIsset()
    {
        $user = new User();
        $this->assertFalse(isset($user->username));
        $user->username = 'bob';
        $this->assertTrue(isset($user->username));
        $this->assertFalse(isset($user->username->undefined));
    }

    /**
     * Test isset.
     */
    public function testIssetUndefined()
    {
        $user = new User();
        $this->assertFalse(isset($user->nada));
        $this->assertFalse(isset($user->nada->undefined));
    }

}
