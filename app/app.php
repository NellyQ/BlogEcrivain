<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => function () use ($app) {
                return new BlogEcrivain\DAO\UserDAO($app['db']);
            },
        ),
    ),
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('register_path' => '/register', 'check_path' => '/login_check'),
            'users' => function () use ($app) {
                return new BlogEcrivain\DAO\UserDAO($app['db']);
            },
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    ),
));

$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app['twig'] = $app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
});
$app->register(new Silex\Provider\ValidatorServiceProvider());

// Register services.
$app['dao.billet'] = new BlogEcrivain\DAO\BilletDAO($app['db']);
$app['dao.comment'] = new BlogEcrivain\DAO\CommentDAO($app['db']);
    

$app['dao.user'] = function ($app) {
    return new BlogEcrivain\DAO\UserDAO($app['db']);
};

$app['dao.comment']->setBilletDAO($app['dao.billet']);
$app['dao.comment']->setUserDAO($app['dao.user']);
$app['dao.billet']->setCommentDAO($app['dao.comment']);


// Register error handler
$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    switch ($code) {
        case 403:
            $message = 'Accès refusé.';
            break;
        case 404:
            $message = 'Le lien demandé n\'a pas pu être trouvé.';
            break;
        default:
            $message = "Il y a eu un problème lors du chargement de la page";
    }
    return $app['twig']->render('error.html.twig', array('message' => $message));
});
