<?php

namespace Model;

class Connection extends \PDO
{

    public function __construct($db_type, $db_name, $db_host, $db_user, $db_password)
    {
        try {
            parent::__construct($db_type . ':dbname=' . $db_name . ';host=' . $db_host, $db_user, $db_password);
        } catch (\PDOException $e) {
            echo 'Can\'t contact database : ' . $e->getMessage();
        }
    }

    public function executeQuery($query, array $parameters = [])
    {
        $preparedQuery = $this->prepare($query);

        foreach ($parameters as $name => $value) {
            $this->bind($preparedQuery, $name, $value);
        }

        $preparedQuery->execute();

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
