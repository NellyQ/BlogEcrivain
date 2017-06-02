<?php

// Home page
$app->get('/', function () use ($app) {
    $billets = $app['dao.billet']->findAll();
     return $app['twig']->render('index.html.twig', array('billets' => $billets));

    ob_start();             // start buffering HTML output
    require '../views/view.php';
    $view = ob_get_clean(); // assign HTML output to $view
    return $view;
});