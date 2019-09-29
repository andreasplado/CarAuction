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
            $response, 'homepage.twig'
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
            $response, 'about.twig'
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

        $data = file_get_contents('https://www.carqueryapi.com/api/0.3/?callback=?&cmd=getModel&model=11459');
        $decodedData = json_decode($data);

        //Get all data
        $sql = 'SELECT name FROM cars ORDER BY name';
        $oldData = $conn->query($sql);

        
        foreach (array_combine($oldData, $data) as $oldDataItem => $dataItem) {
            //Chek if any matching results
            if($oldDataItem->name === $dataItem->name){
                //update
                $sql = 'UPDATE cars
                SET column1 = value1, column2 = value2, ...
                WHERE name='. ". $dataItem->name. " ."'";
            }else{
                //Insert new one
                $sql = 'INSERT INTO cars ("make", "name","trim","year","body",
                "engine_position","engine_type","engine_compression","engine_fuel",
                "image","country","weight","transmission_type","price")
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?);';
                $stmt = $conn->prepare($sql);
                $stmt->execute([$dataItem->make, $dataItem->name, $dataItem->trim,
                    $dataItem->year, $dataItem->body, $dataItem->engine_position,
                    $dataItem->engine_type, $dataItem->engine_compression,
                    $dataItem->engine_fuel, $dataItem->image, $dataItem->country,
                    $dataItem->weight, $dataItem->transmission, $dataItem->price
                ]);
            }
        }




        return $this->container->get('view')->render(
            $response, 'random-data-added.twig', [
            'name' => $next['name']
            ]
        );
    }

}