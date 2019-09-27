<?php

// Render Twig template within container
$app->get('/', 'App\\Controllers\\CarController:index');
$app->get('/cars', 'App\\Controllers\\CarController:viewCars');
$app->get('/about', 'App\\Controllers\\CarController:about');
$app->get('/car', 'App\\Controllers\\CarController:viewCar');
$app->post('/car', 'App\\Controllers\\CarController:addCar');
$app->put('/editCar', 'App\\Controllers\\CarController:editCar');
$app->get('/admin', 'App\\Controllers\\CarController:admin');