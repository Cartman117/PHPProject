<?php

namespace Model;

class DatabaseFinder implements  FinderInterface{

    private $database_connection;

    public function __construct($database_connection){
        $this->database_connection = $database_connection;
    }
    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll()
    {
        $prepared_query = $this->database_connection->prepare('SELECT * FROM statuses');
        $prepared_query->execute();

        return $prepared_query->FetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed $id
     * @return null|mixed
     */
    public function findOneById($id)
    {
        // TODO: Implement findOneById() method.
    }
}