<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 22.04.2018
 * Time: 17:13
 */

namespace Models;


class Employee extends Model
{
    public function getEmployees()
    {
        $sql = "select * FROM employee";
        try {
            $db = $this->db_connection;
            $stmt = $db->query($sql);
            $emp = $stmt->fetchAll(\PDO::FETCH_OBJ);
            $db = null;
            return $emp;
        } catch(\PDOException $e) {
            return ['error' => ['text' => $e->getMessage()]];

        }
    }


    public function getEmployee($employeeId)
    {
        try {
            $db = $this->db_connection;
            $sth = $db->prepare("SELECT * FROM employee WHERE id=$employeeId");
            $sth->bindParam("id", $employeeId);
            $sth->execute();
            $todos = $sth->fetchObject();
            return $todos;
        } catch(\PDOException $e) {
            return ['error' => ['text' => $e->getMessage()]];
        }
    }


    public function addEmployee($employee)
    {
        $sql = "INSERT INTO employee (employee_name, employee_salary, employee_age) VALUES (:name, :salary, :age)";
        try {
            $db = $this->db_connection;
            $stmt = $db->prepare($sql);
            $stmt->bindParam("name", $employee['name']);
            $stmt->bindParam("salary", $employee['salary']);
            $stmt->bindParam("age", $employee['age']);
            $stmt->execute();
            $employee['id'] = $db->lastInsertId();
            $db = null;
            return $employee;
        } catch(\PDOException $e) {
            return ['error' => ['text' => $e->getMessage()]];
        }
    }

    public function updateEmployee($employee, $id)
    {
        $sql = "UPDATE employee SET employee_name=:name, employee_salary=:salary, employee_age=:age WHERE id=:id";
        try {
            $db = $this->db_connection;
            $stmt = $db->prepare($sql);
            $stmt->bindParam("name", $employee['name']);
            $stmt->bindParam("salary", $employee['salary']);
            $stmt->bindParam("age", $employee['age']);
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $db = null;
            return $employee;
        } catch(\PDOException $e) {
            ['error' => ['text' => $e->getMessage()]];
        }
    }

    public function deleteEmployee($id) {

        $sql = "DELETE FROM employee WHERE id=:id";
        try {
            $db = $this->db_connection;
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $db = null;
            return ['success' => ['text' => "Employee with id $id was successfully deleted!"]];
        } catch(\PDOException $e) {
            return ['error' => ['text' => $e->getMessage()]];
        }
    }
}
