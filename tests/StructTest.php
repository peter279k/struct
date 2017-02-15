<?php

namespace Odan\Test;

use Odan\ValueType\Struct;
use Odan\Test\Struct\User;
use PHPUnit\Framework\TestCase;
use PDO;

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
     *
     * @expectedException \Odan\ValueType\Exception\StructException
     */
    public function testIssetUndefined()
    {
        $user = new User();
        $this->assertFalse(isset($user->username));
        $user->username = 'bob';
        $this->assertTrue(isset($user->username));

        // throw exception here
        isset($user->nada);
    }

    /**
     * Test unset.
     */
    public function testUnset()
    {
        $user = new User();
        $user->username = 'bob';
        unset($user->username);
        $this->assertFalse(isset($user->username));
        $this->assertNull($user->username);
    }

    /**
     * Test unset.
     *
     * @expectedException \Odan\ValueType\Exception\StructException
     */
    public function testUnsetUndefined()
    {
        $user = new User();
        unset($user->nada);
    }

    public function getPdo()
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->exec('CREATE TABLE user(id INTEGER PRIMARY KEY ASC, username, email)');

        $stmt = $pdo->prepare("INSERT INTO user (username, email) VALUES (:username, :email)");
        $stmt->bindValue(':username', 'bob');
        $stmt->bindValue(':email', 'bob@exmaple.com');
        $stmt->execute();
        $stmt->execute();
        $stmt->execute();
        return $pdo;
    }

    /**
     * Test PDO.
     */
    public function testPdoFetchAll()
    {
        $pdo = $this->getPdo();
        $rows = $pdo->query('SELECT username, email FROM user')->fetchAll(PDO::FETCH_CLASS, User::class);
        $this->assertTrue(isset($rows[0]->username));
        $this->assertTrue(isset($rows[0]->email));
        unset($pdo);
    }

    /**
     * Test PDO.
     */
    public function testPdoFetch()
    {
        $pdo = $this->getPdo();
        $stmt = $pdo->query('SELECT username, email FROM user');
        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
        $row = $stmt->fetch();
        $this->assertTrue(isset($row->username));
        $this->assertTrue(isset($row->email));
        unset($pdo);
    }

    /**
     * Test PDO.
     *
     * @expectedException \Odan\ValueType\Exception\StructException
     */
    public function testPdoSelectUndefined()
    {
        $pdo = $this->getPdo();
        $pdo->query('SELECT id, username, email FROM user')->fetchAll(PDO::FETCH_CLASS, User::class);
        unset($pdo);
    }

}
