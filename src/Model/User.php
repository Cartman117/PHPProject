<?php

namespace Model;

class User
{
    private $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function isValid()
    {
        if (strlen(trim($this->getUsername())) !== 0 && strlen(trim($this->getPassword())) !== 0) {
            return $this->verifyAvailability($this->getUsername());
        }
        return false;
    }

    private function verifyAvailability($username)
    {
        $userQuery = new UserQuery(new Connection("mysql", "uframework", "localhost", "uframework", "passw0rd"));
        $user = $userQuery->findOneByUsername($username);
        if (null !== $user) {
            return false;
        }
        return true;
    }
}