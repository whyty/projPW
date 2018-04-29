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
        try {
            //sql connection
            /*$dbhost="127.0.0.1";
            $dbuser="root";
            $dbpass="1";
            $dbname="project";
            $dbh = new \PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);*/
            $sqliteDbFile = __DIR__ . "/../database/project.db";
            $dbh = new \PDO("sqlite:$sqliteDbFile");
            $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $dbh;
        } catch (\PDOException $e) {
            // handle the exception here
            print $e->getMessage(); exit;
        }

    }
}