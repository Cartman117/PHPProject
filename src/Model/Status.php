<?php

namespace Model;

class Status
{
    private $content;
    private $id;
    private $userId;
    private $date;
    private $clientUsed;

    public function __construct($content, $id, $userId, $date, $clientUsed)
    {
        $this->content      = $content;
        $this->id           = $id;
        $this->userId       = $userId;
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

    public function getUserId()
    {
        return $this->userId;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getClientUsed()
    {
        return $this->clientUsed;
    }
}