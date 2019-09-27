<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Utils\DBConnection as DBConnection;

/**
 * Class HelloController
 *
 * @package Controllers
 */
class CarController
{
    /**
     * @var \Slim\Container Stores the container for dependency purposes.
     */
    protected $container;


    /**
     * Store the container during class construction.
     *
     * @param \Slim\Container $container
     */
    public function __construct(\Slim\Container $container)
    {
        $this->container = $container;
    }

    /**
     * Output a hello message to a specified name.
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  Array    $args
     * @return mixed
     */
    public function index(Request $request, Response $response, $args)
    {
        return $this->container->get('view')->render(
            $response, 'homepage.twig', [
            'name' => $args['name']
            ]
        );
    }

    public function admin(Request $request, Response $response, $args)
    {
        return $this->container->get('view')->render(
            $response, 'login.twig', [
            'name' => $args['name']
            ]
        );
    }

    public function about(Request $request, Response $response, $args)
    {
        return $this->container->get('view')->render(
            $response, 'about.twig', [
            'name' => $args['name']
            ]
        );
    }

    public function ViewCar(Request $request, Response $response, $next){
        return $this->container->get('view')->render(
            $response, 'view-car.twig', [
            'name' => $next['name']
            ]
        );
    }

    public function ViewCars(Request $request, Response $response, $next){

        $dbConnection = new DBConnection($this->container);
        $conn = $dbConnection->connectDB();
        $sql = 'SELECT name, make FROM cars ORDER BY name';
        $data = $conn->query($sql);

        return $this->container->get('view')->render(
            $response, 'view-cars.twig', [
            'cars' => $data
            ]
        );
    }

    public function addCar(Request $request, Response $response, $next){
        return $this->container->get('view')->render(
            $response, 'add-car.twig', [
            'name' => $next['name']
            ]
        );
    }

    public function editCar(Request $request, Response $response, $next){
        return $this->container->get('view')->render(
            $response, 'edit-car.twig', [
            'name' => $next['name']
            ]
        );
    }


    public function updateCar(Request $request, Response $response, $next){
        $response->getBody()->write('BEFORE');
        $response = $next($request, $response);
        $response->getBody()->write('AFTER');

        return $this->container->get('view')->render(
            $response, 'edit-car.twig', [
            'name' => $next['name']
            ]
        );
    }


    
    public function deleteCar(Request $request, Response $response, $next){
        $response->getBody()->write('BEFORE');
        $response = $next($request, $response);
        $response->getBody()->write('AFTER');

        return $this->container->get('view')->render(
            $response, 'delete-car.twig', [
            'name' => $next['name']
            ]
        );
    }

    public function addRandomData(Request $request, Response $response, $next){
        $dbConnection = new DBConnection($this->container);
        $conn = $dbConnection->connectDB();

        $data = file_get_contents('https://blockchain.info/ticker');
        $decodedData = json_decode($data);
        $sql = 'INSERT INTO cars ("make", "name","trim","year","body",
        "engine_position","engine_type","engine_compression","engine_fuel",
        "image","country","weight","transmission_type","price")
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?);';
        $stmt = $conn->prepare($query);
        $stmt->execute([$data->make, $data->name, $data->trim,
            $data->year, $data->body, $data->engine_position,
            $data->engine_type, $data->engine_compression,
            $data->engine_fuel, $data->image, $data->country,
            $data->weight, $data->transmission, $data->price
        ]);

        return $this->container->get('view')->render(
            $response, 'random-data-added.twig', [
            'name' => $next['name']
            ]
        );
    }

}