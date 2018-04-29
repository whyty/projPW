<?php

//
//routes
//

$app->get( "/", "HomeController:index")->setName("home");
$app->post("/plot-example", "HomeController:plotExample");
//API
$app->get( "/api/", "ApiController:index")->setName("api");
$app->get('/api/examples', 'ApiController:getExamples');
$app->get('/api/example/{id}', 'ApiController:getExample');
$app->get('/api/employees', 'ApiController:getEmployees');
$app->get('/api/employee/{id}', 'ApiController:getEmployee');
$app->post('/api/create', 'ApiController:addEmployee');
$app->put('/api/update/{id}', 'ApiController:updateEmployee');
$app->delete('/api/delete/{id}', 'ApiController:deleteEmployee');

