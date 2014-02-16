<?php

namespace Model;

class UserDataMapper
{
    private $con;

    public function __construct(Connection $con)
    {
        $this->con = $con;
    }

    public function persist(User $user)
    {
        // Name or password too large
        if (mb_strlen($user->getUsername()) > 30) {
            return -1;
        }
        if (mb_strlen($user->getPassword()) > 30) {
            return -1;
        }
        $passwordHash = $this->hashPassword(trim($user->getPassword()));
        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $parameters = [
            ':username' => trim($user->getPassword()),
            ':password' => $passwordHash,
        ];

        return $this->con->executeQuery($query, $parameters);
    }

    // Not used yet
    public function remove(User $user)
    {
        $userQuery = new UserQuery($this->con);
        if (!$userQuery->findByUsernameAndPassword($user->getUsername(), $user->getPassword())) {
            return false;
        }
        $query = "DELETE FROM users WHERE username = :username";
        $parameters = [':username' => $user->getUsername(),];

        $this->con->executeQuery($query, $parameters);
    }

    private function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
