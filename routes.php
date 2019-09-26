<?php

// Render Twig template within container
$app->get('/', 'Controllers\\CarController:index');
$app->get('/cars', 'Controllers\\CarController:viewCars');
$app->get('/about', 'Controllers\\CarController:about');
$app->get('/car', 'Controllers\\CarController:viewCar');
$app->post('/car', 'Controllers\\CarController:addCar');
$app->put('/editCar', 'Controllers\\CarController:editCar');
$app->get('/admin', 'Controllers\\CarController:admin');