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
    public function findAll($limit = null, $orderBy = null, $direction = null)
    {
        $columns = array(
            'content',
            'id',
            'username',
            'date',
            'clientUsed',
        );
        $parameters = array();
        $query = "SELECT * FROM statuses";
        if (null === $orderBy  ||
            (null !== $orderBy && !in_array($orderBy, $columns))) {
            $query .= " ORDER BY id DESC";
        }
        if (null !== $orderBy &&
            in_array($orderBy, $columns)) {
            $query .= " ORDER BY ". $orderBy;
            $query .= ('ASC' === $direction) ? " ASC" : " DESC";
        }
        if (null !== $limit &&
            $limit > 0) {
            $query .= " LIMIT 0, :limit";
            $parameters[':limit'] = $limit;
        }
        $results = $this->connection->executeQuery($query, $parameters);
        if (null === $results)
            return null;
        $results = $results->fetchALL(\PDO::FETCH_ASSOC);

        $arrayStatuses = array();
        foreach ($results as $result) {
            array_push($arrayStatuses, new Status($result['content'], $result['id'], $result['username'], new \DateTime($result['date']), $result['clientused']));
        }

        return $arrayStatuses;
    }

    public function findAllByUser($username, $limit = null, $orderBy = null, $direction = null)
    {
        $columns = array(
            'content',
            'id',
            'username',
            'date',
            'clientUsed',
        );
        $parameters = array();
        $query = "SELECT * FROM statuses WHERE username = :username";
        $parameters[':username'] = $username;
        if (null === $orderBy  ||
            (null !== $orderBy && !in_array($orderBy, $columns))) {
            $query .= " ORDER BY id DESC";
        }
        if (null !== $orderBy &&
            in_array($orderBy, $columns)) {
            $query .= " ORDER BY ". $orderBy;
            $query .= ('ASC' === $direction) ? " ASC" : " DESC";
        }
        if (null !== $limit &&
            $limit > 0) {
            $query .= " LIMIT 0, :limit";
            $parameters[':limit'] = $limit;
        }
        $results = $this->connection->executeQuery($query, $parameters);
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
        if (null === $result)
            return null;
        $result = $result->fetch(\PDO::FETCH_ASSOC);

        return ($result !== false) ? new Status($result['content'], $result['id'], $result['username'], new \DateTime($result['date']), $result['clientused']) : null;
    }
}
