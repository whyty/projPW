<?php

//
//routes
//

$app->get( "/", "HomeController:index")->setName("home");
$app->post("/plot-example", "HomeController:plotExample");



// API group
$app->group('/api', function () use ($app) {
    $app->get('/employees', 'ApiController:getEmployees');
    $app->get('/employee/{id}', 'ApiController:getEmployee');
    $app->post('/create', 'ApiController:addEmployee');
    $app->put('/update/{id}', 'ApiController:updateEmployee');
    $app->delete('/delete/{id}', 'ApiController:deleteEmployee');
});