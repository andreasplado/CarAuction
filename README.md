## SlimPHP Setup

### How do I get started?

Take a copy of `config_sample.php` and rename to `config.php`, entering information about your MySQL connection.

You'll also need to run `composer install` to setup necessary assets to get started.

Good luck!

### What do I need to know?

* https://www.slimframework.com/
* https://www.phptherightway.com/
* https://twig.symfony.com/doc/2.x/

How to run:
    php -S localhost:8080 -t public public/index.php



disable ssl:
add composer.json:
    "config": {
        "disable-tls": true,
        "secure-http": false
    }
 run composer dump-autoload