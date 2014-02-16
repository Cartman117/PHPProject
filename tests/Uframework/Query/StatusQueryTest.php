<?php

use Model\Connection;
use Model\StatusQuery;

class StatusQueryTest extends TestCase
{
    private $connection;

    public function setUp()
    {
        $this->connection = new Connection("mysql", "uframework", "localhost", "uframework", "passw0rd");
    }

    public function testFindOneByIdWhichNotExists()
    {
        $statusQuery = new StatusQuery($this->connection);
        $this->assertNull($statusQuery->findOneById(1000));
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

    //Here I choose a user Nico, who have already post statuses, you can change.
    public function testFindByUsername()
    {
        $name = "Nico";
        $statusQuery = new StatusQuery($this->connection);
        $this->assertNotNull($statusQuery->findAllByUser($name));
    }
    */
}
