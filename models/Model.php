<?php
namespace Models;


/**
 * Model
 *
 * To be used for data handling
 *
 * */

class Model {

    protected $db_connection;

    public function __construct()
    {
        $this->db_connection = $this->setDbConnection();
    }


    private function setDbConnection() {
        $dbhost="127.0.0.1";
        $dbuser="root";
        $dbpass="1";
        $dbname="project";
        $dbh = new \PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $dbh;
    }
}