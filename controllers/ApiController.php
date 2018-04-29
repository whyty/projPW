<?php

namespace Controllers;

use \Models\Employee;
use \Models\Gnuplot;

class ApiController extends Controller
{
    protected $params;
    protected $model;

    public function __construct($container)
    {
        parent::__construct($container);
        $this->employeeModel = new Employee();
        $this->gnuplotModel = new Gnuplot();
    }

    public function index ($request, $response, $args)
    {
        $employees = array_column($this->employeeModel->getEmployees(), 'id');
        $examples = array_column($this->gnuplotModel->getExamples(), 'id');
        return $this->container->view->render($response, "api.twig", ['employees' => $employees, 'examples' => $examples]);
    }

    public function getEmployees($request, $response, $args)
    {
        $result = $this->employeeModel->getEmployees();
        $body = $response->getBody();
        $body->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withBody($body);
    }


    public function getEmployee($request, $response, $args)
    {
        $id =  $request->getAttribute('id');
        $result = [];
        if (empty($id)) {
            $result = ['error' => ['text' => 'Id is empty']];
        } else {
            $result = $this->employeeModel->getEmployee($id);
        }
        $body = $response->getBody();
        $body->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withBody($body);
    }


    public function addEmployee($request, $response, $args)
    {

        $params = $request->getParams();

        $result = $this->employeeModel->addEmployee($params);

        $body = $response->getBody();
        $body->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withBody($body);
    }


    public function updateEmployee($request, $response, $args)
    {
        $params = $request->getParams();
        $id = $request->getAttribute('id');
        $result = $this->employeeModel->updateEmployee($params, $id);

        $body = $response->getBody();
        $body->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withBody($body);
    }


    public function deleteEmployee($request, $response, $args)
    {
        $id =  $request->getAttribute('id');

        if (empty($id)) {
            $result = ['error' => ['text' => 'Id is empty']];
        } else {
            $result = $this->employeeModel->deleteEmployee($id);
        }
        $body = $response->getBody();
        $body->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withBody($body);
    }

    public function getExamples($request, $response, $args)
    {
        $result = $this->gnuplotModel->getExamples();
        $body = $response->getBody();
        $body->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withBody($body);
    }

    public function getExample($request, $response, $args)
    {
        $id =  $request->getAttribute('id');
        $result = [];
        if (empty($id)) {
            $result = ['error' => ['text' => 'Id is empty']];
        } else {
            $result = $this->gnuplotModel->getExample($id);
        }
        $body = $response->getBody();
        $body->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withBody($body);
    }
}
