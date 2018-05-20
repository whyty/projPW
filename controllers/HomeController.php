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
        //$model = new Gnuplot();
        //$examples = $model->getExamples();
        return $this->container->view->render($response, "plot.twig");
    }


    public function plotExample($request, $response, $args)
    {
        $result = array('valid' => true);
        $params = $request->getParams();
        if (empty($params['plot_image_name']) || empty($params['plot_command'])) {
            $errorMsg = 'Generating plot was interupted by: <br>';
            if (empty($params['plot_image_name'])) {
                $errorMsg .= 'Missing image name.<br>';
            }

            if (empty($params['plot_command'])) {
                $errorMsg .= 'Missing plot command.<br>';
            }
            $result['valid'] = false;
            $result['message'] = $errorMsg;

        } else {
            $imageName = str_replace(" ", "_" ,$params['plot_image_name']);
            $fileContent = "#!/usr/bin/gnuplot" . "\n";
            $fileContent .= "reset" . "\n";
            $fileContent .= "set terminal png" . "\n";
            $fileContent .= "set output '../plot-images/$imageName.png'" . "\n";
            if (!empty($params['plot_name'])) $fileContent .= "set title '" . $params['plot_name'] . "'" . "\n";
            $fileContent .= $params['plot_command'];
            $scriptPath = __DIR__ . "/../public/plot-examples/";
            file_put_contents($scriptPath . "plot.pg", $fileContent);
            $cmd = "cd $scriptPath && chmod +x plot.pg && ./plot.pg";
            exec($cmd);
            $result['image'] = $imageName . ".png";
        }
        /*if (!empty($plotExampleName)) {
            $plotExampleExecutableFile = $plotExampleName.'.pg';
            $cmd = "cd ".__DIR__."/../public/plot-examples/ && ./$plotExampleExecutableFile";
            exec($cmd);
            $result['image'] = "$plotExampleName.png";
        } else {
            $result['valid'] = false;
            $result['message'] = 'No ploting example selected.';
        }*/
        $body = $response->getBody();
        $body->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withBody($body);
    }


}
