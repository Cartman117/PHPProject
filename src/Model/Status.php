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
        if ('' === $username) {
            $username = 'Anonymous';
        }

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
        return $this->date->format('Y-m-d H:i:s');
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
        return '<div class="panel panel-default panel-tweet">
                    <div class="panel-heading">' . $this->getUsername() . ' (on ' . $this->getClientUsed() . ')</div>
                    <div class="panel-body">' . $this->getContent() . '<br />
                        <span class="right">' . $this->getDate() .'</span>
                    </div>
                </div>';
    }
}
