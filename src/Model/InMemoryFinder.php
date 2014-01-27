<?php

namespace Model;

use Exception\HttpException;

class InMemoryFinder implements FinderInterface
{
    private $statuses = array();

    public function __construct()
    {
        $status1 = new Status("First status created ever", 0, 0, date("Y-m-d H:i:s"), "Windows Phone");
        $status2 = new Status("Second status created ever", 1, 0, date("Y-m-d H:i:s"));
        $status3 = new Status("Another status created by another person", 2, 1, date("Y-m-d H:i:s"), "iOS");
        array_push($this->statuses, $status1);
        array_push($this->statuses, $status2);
        array_push($this->statuses, $status3);
    }

    /**
     * {@inheritDoc}
     */
    public function findAll()
    {
        return $this->statuses;
    }

    /**
     * {@inheritDoc}
     */
    public function findOneById($id)
    {
        if(isset($this->statuses[$id])) {
            return $this->statuses[$id];
        }
        throw new HttpException(404, 'Page not found. False status id.');
    }
}