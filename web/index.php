<?php
    
    require_once __DIR__.'/../vendor/autoload.php';
    
    $app = new Silex\Application();
    
    $app->register(new Silex\Provider\TwigServiceProvider(), array(

   'twig.path' => dirname(__DIR__) . "/CHEMIN_HTML",

    ));
    
    $app->get('/', function () {
        return 'Bonjour';
    });
    
    

    $app->run();
?>