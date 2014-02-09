<?php

namespace Model;

class InMemoryFinder implements FinderInterface
{
    private $statuses = array();

    public function __construct()
    {
        $this->statuses[0] = new Status("First status created ever", 0, 'Nico', new \DateTime(), "Windows Phone");
        $this->statuses[1] = new Status("Second status created ever", 1, 'Nico', new \DateTime());
        $this->statuses[2] = new Status("Another status created by another person", 2, 'Leo', new \DateTime(), "iOS");
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
        if (isset($this->statuses[$id])) {
            return $this->statuses[$id];
        }

        return null;
    }
}
