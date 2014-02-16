<?php

use Model\Connection;
use Model\UserQuery;

class UserQueryTest extends TestCase
{
    private $connection;

    public function setUp()
    {
        $this->connection = new Connection("mysql", "uframework", "localhost", "uframework", "passw0rd");
    }

    public function testFindOneByNameNotExisting()
    {
        $name = "uheriurehguiehgerh";
        $userQuery = new \Model\UserQuery($this->connection);
        $this->assertNull($userQuery->findOneByUsername($name));
    }

    // This tests works with a user Nico with a password nico, you can change this with another couple login/password you create
    /*
    public function testFindOneByName()
    {
        $name = "Nico";
        $userQuery = new \Model\UserQuery($this->connection);
        $this->assertNotNull($userQuery->findOneByUsername($name));
    }

    public function testFindOneByUsernameAndPassword()
    {
        $name = "Nico";
        $password = "nico";
        $userQuery = new \Model\UserQuery($this->connection);
        $this->assertNotNull($userQuery->findByUsernameAndPassword($name, $password));
    }

    // No more tests because we have to fill the database before tests others
    /*
    public function testFindFirst()
    {
        $statusQuery = new StatusQuery($this->connection);
        $this->assertNotNull($statusQuery->findOneById(1));
    }

    public function testFindAll()
    {
        $statusQuery = new StatusQuery($this->connection);
        $this->assertNotNull($statusQuery->findAll());
    }
    */
}
