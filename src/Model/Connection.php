<?php

namespace Model;

class Connection {

    private $PDO;

    public function __construct($db_type, $db_name, $db_host, $db_user, $db_password){

        try{
            $this->PDO = new PDO($db_type . 'dbname=' . $db_name . ';host=' . $db_host);
        }catch(\PDOException $e){
            echo 'Can\'t contact database : ' . $e->getMessage();
        }

    }

    public function getConnection(){
        return $this->PDO;
    }
} 