<?php

namespace Model;

class UserQuery implements FinderInterface
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findAll()
    {
        echo "Function not implemented.";
    }

    public function findOneById($id)
    {
        echo "Function not implemented.";
    }

    public function findOneByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $parameters = [':username' => $username];

        $result = $this->connection->executeQuery($query, $parameters);
        $result = $result->fetch(\PDO::FETCH_ASSOC);

        return ($result !== false) ? new User($result['username'], $result['password']) : null;
    }

    public function findByUsernameAndPassword($username, $password)
    {
        $user = $this->findOneByUsername($username);
        if (null === $user) {
            return false;
        }

        return $this->verifyPassword($password, $user->getPassword());
    }

    private function verifyPassword($password, $passwordHash)
    {
        return password_verify($password, $passwordHash);
    }
}
