<?php

namespace \App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Utils\DBConnection as DBConnection;

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
        $dbConnection = new DBConnection();
        $dbConnection->connectDB();
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

        return $this->container->get('view')->render(
            $response, 'view-cars.twig', [
            'name' => $next['name']
            ]
        );
    }

    public function addCar(Request $request, Response $response, $next){
        $response->getBody()->write('BEFORE');
        $response = $next($request, $response);
        $response->getBody()->write('AFTER');

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
}