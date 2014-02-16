<?php

use Model\Connection;

class MockConnection extends Connection
{
    public function __construct()
    {
    }

    public function executeQuery($query, array $parameters = [])
{
    $preparedQuery = $this->prepare($query);

    foreach ($parameters as $name => $value) {
        $this->bind($preparedQuery, $name, $value);
    }

    return $preparedQuery;
}

    private function bind($preparedQuery, $name, $value)
    {
        switch ($name) {
            case ':limit':
                $preparedQuery->bindValue($name, $value, self::PARAM_INT);
                break;
            default:
                $preparedQuery->bindValue($name, $value, self::PARAM_STR);
                break;
        }
    }
} 