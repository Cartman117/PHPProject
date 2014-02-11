<?php

namespace Model;

class StatusDataMapper
{
    private $con;

    public function __construct(Connection $con)
    {
        $this->con = $con;
    }

    public function persist(Status $status)
    {
        if (mb_strlen($status->getContent()) > 140) {
            return null;    // Status content over 140 characters
        }
        $query = "INSERT INTO statuses (username, content, date, clientused) VALUES (:username, :content, :date, :clientused)";
        $parameters = [
            ':username' => $status->getUsername(),
            ':content' => $status->getContent(),
            ':date' => $status->getDate(),
            ':clientused' => $status->getClientUsed(),
        ];
        $this->con->executeQuery($query, $parameters);
        return;
    }

    public function remove(Status $status)
    {
        $query = "DELETE FROM statuses WHERE id = :id";
        $parameters = [':id' => $status->getId()];

        $this->con->executeQuery($query, $parameters);
    }
}
