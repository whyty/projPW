<?php


$application_folder = dirname(__DIR__);


$pathArr   = explode(DIRECTORY_SEPARATOR, $application_folder);
$basename  = '';
$keepPaths = false;
foreach ($pathArr as $paths) {
    if ($paths == 'www') {
        $keepPaths = true;
        continue;
    }

    if ($keepPaths) {
        $basename .= $paths . '/';
    }
}

if (isset($_SERVER['FCGI_ROLE'])) {
    list(, $app_http_path,) = explode('/', $_SERVER['DOCUMENT_URI']);
    $route_path = '/apps/' . $app_http_path;
} else {
    $app_http_path = !empty($basename) ? 'public/' : substr($_SERVER['SCRIPT_NAME'], 1, strrpos($_SERVER['SCRIPT_NAME'], "/"));
    $route_path = '';
}
$basename = isset($_SERVER['FCGI_ROLE']) ? ltrim($route_path, '/') : $app_http_path;

define('BASENAME', '/' . rtrim($basename, '/'));


$config = [];

//slim configuration
$config['slim_config'] = [
    'determineRouteBeforeAppMiddleware' => true,
    'displayErrorDetails'               => true,
    'addContentLengthHeader'            => false,
    'mode'                              => 'dev',
];


