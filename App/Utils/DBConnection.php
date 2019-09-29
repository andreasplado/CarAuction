<?php

namespace App\Utils;

use \PDO as PDO;

class DBConnection
{
    protected $container;

    public function __construct(\Slim\Container $container)
    {
        $this->container = $container;
    }


    public function connectDB(){
        
        $this->$container['pdo'] = function (\Slim\Container $container) {
            // better load the settings with $container->get('settings')
            $host = '127.0.0.1';
            $dbname = 'car_auction';
            $username = 'root';
            $password = '';
            $charset = 'utf8';
            $collate = 'utf8_unicode_ci';
            $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
            $options = [
                \PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_PERSISTENT => false,
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset COLLATE $collate"
            ];
            return new \PDO($dsn, $username, $password, $options);
        };
    }
}