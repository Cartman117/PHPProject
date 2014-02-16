<?php

use Model\Status;
use Model\StatusDataMapper;

class StatusDataMapperTest extends TestCase
{
    private $connection;

    public function setUp()
    {
        $this->connection = $this->getMock('Model\MockConnection', array('executeQuery'));
        $this->connection
            ->expects($this->any())
            ->method('executeQuery')
            ->will($this->returnValue(true));
    }

    // I don't succeed to compare the query because of the binds.
    // I can't test the remove method because she takes a status in parameter, and because we use a MockConnection and I
    // don't succeed to compare the query.

    public function testPersist()
    {
        $statusDataMapper = new StatusDataMapper($this->connection);
        $date = new DateTime();
        $status = new Status("Toto", 0, "Nico", new DateTime());

        $this->assertTrue($statusDataMapper->persist($status));
    }
}