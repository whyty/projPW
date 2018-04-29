<?php

namespace Controllers;

use \Models\Gnuplot;

class HomeController extends Controller
{
    protected $params;

    public function __construct($container)
    {
        parent::__construct($container);
    }

    public function index($request, $response, $args)
    {
        $model = new Gnuplot();
        $examples = $model->getExamples();
        return $this->container->view->render($response, "plot.twig", ['examples' => $examples]);
    }


    public function plotExample($request, $response, $args)
    {
        $result = array('valid' => true);
        $plotExampleName = $request->getParam('plot-example');
        if (!empty($plotExampleName)) {
            $plotExampleExecutableFile = $plotExampleName.'.pg';
            $cmd = "cd ".__DIR__."/../public/plot-examples/ && ./$plotExampleExecutableFile";
            exec($cmd);
            $result['image'] = "$plotExampleName.png";
        } else {
            $result['valid'] = false;
            $result['message'] = 'No ploting example selected.';
        }
        $body = $response->getBody();
        $body->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withBody($body);
    }


}
