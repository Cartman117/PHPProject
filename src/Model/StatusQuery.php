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
    public function findAll($limit = null, $orderBy = null)
    {
        $query = "SELECT * FROM statuses";
        if (null !== $orderBy &&
            null !== $limit) {
            $query += " ORDER BY :orderBy LIMIT 0, :limit";
            $parameters = [
                ':orderBy'  => $orderBy,
                ':limit'    => $limit,
            ];
        }
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
}
