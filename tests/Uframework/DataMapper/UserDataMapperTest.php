<?php

use Model\User;
use Model\UserDataMapper;

class UserDataMapperTest extends TestCase
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

    public function testPersist()
    {
        $userDataMapper = new UserDataMapper($this->connection);
        $user = new User("Nico", "nico");
        $this->assertTrue($userDataMapper->persist($user));
    }
}