<?php
require '../vendor/autoload.php';
require '../config/config.php';

session_start();

$app = new \Slim\App(["settings" => $config['slim_config']]);
$corsOptions = array(
    "origin" => "*",
    "exposeHeaders" => array("Content-Type", "X-Requested-With", "X-authentication", "X-client"),
    "allowMethods" => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS')
);
$cors = new \CorsSlim\CorsSlim($corsOptions);

$app->add($cors);

$container = $app->getContainer();

$container['errorHandler'] = function () use ($container) {
    return function ($request, $response, $exception) use ($container) {
        return $container['response']->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('Something went wrong!');
    };
};

$container['view'] = function() use ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/templates', [
        'cache' => false
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router, $container->request->getUri()
    ));

    $view->getEnvironment()->addGlobal('mode',$container->get("settings")["mode"]);

    return $view;
};

$controllersDirectory = __DIR__ . '/../controllers/';

$controllers = array_diff(scandir($controllersDirectory), array('..', '.'));

array_walk($controllers, function (&$item) {
    $item = pathinfo($item, PATHINFO_FILENAME);
});

if (!empty($controllers)) {
    foreach ($controllers as $controllerName) {
        $container[$controllerName] = function () use ($controllerName, $container) {
            $className = 'Controllers\\' . $controllerName;
            $controller = new $className($container);
            $controller->setContainer($container);
            return $controller;
        };
    }
} else {
    throw new Exception('No controllers were defined!');
}

require '../config/routes.php';
$app->run();