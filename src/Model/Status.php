<?php

namespace Model;

class Status
{
    private $content;
    private $id;
    private $username;
    private $date;
    private $clientUsed;

    public function __construct($content, $id, $username, $date, $clientUsed = 'PC')
    {
        $this->content      = $content;
        $this->id           = $id;
        $this->username     = $username;
        $this->date         = $date;
        $this->clientUsed   = $clientUsed;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getDate()
    {
        return $this->date->format('Y-m-d H:i:s');;
    }

    public function getClientUsed()
    {
        return $this->clientUsed;
    }

    public static function getNextId($file)
    {
        $finder = new JsonFinder($file);

        return $finder->findNextStatusId();
    }

    public function __toString()
    {
        return '<div class="status">User : ' . $this->getUsername() . '  Date : ' . $this->getDate() . '<br/>' . $this->getContent() . '</div><br/>';
    }
}
