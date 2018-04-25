<?php

namespace Controllers;

use \Models\Employee;

class ApiController extends Controller
{
    protected $params;
    protected $model;

    public function __construct($container)
    {
        parent::__construct($container);
        $this->model = new Employee();
    }

    public function getEmployees($request, $response, $args)
    {
        $result = $this->model->getEmployees();
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
            $result = $this->model->getEmployee($id);
        }
        $body = $response->getBody();
        $body->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withBody($body);
    }


    public function addEmployee($request, $response, $args)
    {

        $params = $request->getParams();

        $result = $this->model->addEmployee($params);

        $body = $response->getBody();
        $body->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withBody($body);
    }


    public function updateEmployee($request, $response, $args)
    {
        $params = $request->getParams();
        $id = $request->getAttribute('id');
        $result = $this->model->updateEmployee($params, $id);

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
            $result = $this->model->deleteEmployee($id);
        }
        $body = $response->getBody();
        $body->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withBody($body);
    }
}
