<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 22.04.2018
 * Time: 17:13
 */

namespace Models;


class Gnuplot extends Model
{
    public function getExamples()
    {
        $sql = "select * FROM gnuplot";
        try {
            $db = $this->db_connection;
            $stmt = $db->query($sql);
            $plots = $stmt->fetchAll(\PDO::FETCH_OBJ);
            $db = null;
            return $plots;
        } catch(\PDOException $e) {
            return ['error' => ['text' => $e->getMessage()]];

        }
    }


    public function getExample($exampleId)
    {
        try {
            $db = $this->db_connection;
            $sth = $db->prepare("SELECT * FROM gnuplot WHERE id=:id");
            $sth->bindParam("id", $exampleId);
            $sth->execute();
            $example = $sth->fetchObject();
            return $example;
        } catch(\PDOException $e) {
            return ['error' => ['text' => $e->getMessage()]];
        }
    }
}
