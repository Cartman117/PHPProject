<?php

namespace Model;

class StatusQuery implements FinderInterface
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll()
    {
        $query = "SELECT * FROM statuses";

        $results = $this->connection->executeQuery($query);
        $results = $results->fetchALL(\PDO::FETCH_ASSOC);

        $arrayStatuses = array();
        foreach ($results as $result) {
            array_push($arrayStatuses, new Status($result['content'], $result['id'], $result['username'], new \DateTime($result['date']), $result['clientused']));
        }

        return $arrayStatuses;
    }

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id)
    {
        $query = "SELECT * FROM statuses WHERE id = :id";
        $parameters = [':id' => $id];

        $result = $this->connection->executeQuery($query, $parameters);
        $result = $result->fetch(\PDO::FETCH_ASSOC);

        return ($result !== false) ? new Status($result['content'], $result['id'], $result['username'], new \DateTime($result['date']), $result['clientused']) : null;
    }

    /**
     * Add a status into the database.
     *
     * @param  Status        $status
     * @throws HttpException
     */
    public function addNewStatus(Status $status)
    {
        $query = "INSERT INTO statuses (username, content, date, clientused) VALUES (:username, :content, :date, :clientused)";
        $parameters = [':username' => $status->getUsername(),
                    ':content' => $status->getContent(),
                    ':date' => $status->getDate(),
                    ':clientused' => $status->getClientUsed()];

        $this->connection->executeQuery($query, $parameters);
    }

    /**
     * Delete a status.
     *
     * @param Status $status The status to delete
     */
    public function deleteStatus(Status $status)
    {
        $query = "DELETE FROM statuses WHERE id = :id";
        $parameters = [':id' => $status->getId()];

        $this->connection->executeQuery($query, $parameters);
    }
}
