<?php

namespace App\Utils;

class DBConnection
{
    protected $container;

    public function __construct(\Slim\Container $container)
    {
        $this->container = $container;
    }


    public function connectDB(){
        $container['db'] = function ($c) {
            $db = $c['settings']['db'];
            $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
                $db['user'], $db['pass']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        };
    }
}