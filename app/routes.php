<?php

use Symfony\Component\HttpFoundation\Request;
use BlogEcrivain\Domain\Comment;
use BlogEcrivain\Domain\Billet;
use BlogEcrivain\Form\Type\CommentType;
use BlogEcrivain\Form\Type\BilletType;

// Home page
$app->get('/', function () use ($app) {
    $billets = $app['dao.billet']->findAll();
     return $app['twig']->render('index.html.twig', array('billets' => $billets));
    })->bind('home');

// Article details with comments
$app->match('/billet/{billet_id}', function ($billet_id, Request $request) use ($app) {
    $billet = $app['dao.billet']->find($billet_id);
    $commentFormView = null;
    
    if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
        // A user is fully authenticated : he can add comments
        $comment = new Comment();
        $comment->setBillet($billet);
        $user = $app['user'];
        $comment->setComAuthor($user);
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'Your comment was successfully added.');
        }
        $commentFormView = $commentForm->createView();
    }
    $comments = $app['dao.comment']->findAllByArticle($billet_id);
        
    return $app['twig']->render('billet.html.twig', array(
        'billet' => $billet, 
        'comments' => $comments,
        'commentForm' => $commentFormView));
})->bind('billet');


// Login form
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');

// Admin home page
$app->get('/admin', function() use ($app) {
    $billets = $app['dao.billet']->findAll();
    $comments = $app['dao.comment']->findAll();
    $users = $app['dao.user']->findAll();
    return $app['twig']->render('admin.html.twig', array(
        'billets' => $billets,
        'comments' => $comments,
        'users' => $users));
})->bind('admin');

// Add a new billet
$app->match('/admin/billet/add', function(Request $request) use ($app) {
    $billet = new Billet();
    $billetForm = $app['form.factory']->create(BilletType::class, $billet);
    $billetForm->handleRequest($request);
    if ($billetForm->isSubmitted() && $billetForm->isValid()) {
        $app['dao.billet']->save($billet);
        $app['session']->getFlashBag()->add('success', 'The billet was successfully created.');
    }
    return $app['twig']->render('billet_form.html.twig', array(
        'title' => 'New billet',
        'billetForm' => $billetForm->createView()));
})->bind('admin_billet_add');

// Edit an existing billet
$app->match('/admin/billet/{billet_id}/edit', function($billet_id, Request $request) use ($app) {
    $billet = $app['dao.billet']->find($billet_id);
    $billetForm = $app['form.factory']->create(BilletType::class, $billet);
    $billetForm->handleRequest($request);
    if ($billetForm->isSubmitted() && $billetForm->isValid()) {
        $app['dao.billet']->save($billet);
        $app['session']->getFlashBag()->add('success', 'The billet was successfully updated.');
    }
    return $app['twig']->render('billet_form.html.twig', array(
        'title' => 'Edit billet',
        'billetForm' => $billetForm->createView()));
})->bind('admin_billet_edit');

// Remove an article
$app->get('/admin/billet/{billet_id}/delete', function($billet_id, Request $request) use ($app) {
    // Delete all associated comments
    $app['dao.comment']->deleteAllByArticle($billet_id);
    // Delete the article
    $app['dao.billet']->delete($billet_id);
    $app['session']->getFlashBag()->add('success', 'The billet was successfully removed.');
    // Redirect to admin home page
    return $app->redirect($app['url_generator']->generate('admin'));
})->bind('admin_billet_delete');

// Hachage password
/*$app->get('/hashpwd', function() use ($app) {
    $rawPassword = 'Alaska';
    $salt = '%qUgq3NAYfC1MKwrW?yevbE';
    $encoder = $app['security.encoder.bcrypt'];
    return $encoder->encodePassword($rawPassword, $salt);
});
*/