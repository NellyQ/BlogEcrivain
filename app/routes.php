<?php

// Home page
$app->get('/', function () use ($app) {
    $billets = $app['dao.billet']->findAll();
     return $app['twig']->render('index.html.twig', array('billets' => $billets));
    })->bind('home');

// Article details with comments
$app->get('/billet/{billet_id}', function ($billet_id) use ($app) {
    $billet = $app['dao.billet']->find($billet_id);
    $comments = $app['dao.comment']->findAllByArticle($billet_id);
    return $app['twig']->render('billet.html.twig', array('billet' => $billet, 'comments' => $comments));
})->bind('billet');
