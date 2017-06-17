<?php

use Symfony\Component\HttpFoundation\Request;
use BlogEcrivain\Domain\Comment;
use BlogEcrivain\Domain\Billet;
use BlogEcrivain\Domain\User;
use BlogEcrivain\Form\Type\CommentType;
use BlogEcrivain\Form\Type\BilletType;
use BlogEcrivain\Form\Type\UserType;


// Home page
$app->get('/', function () use ($app) {
    $billets = $app['dao.billet']->findAll();
    
    return $app['twig']->render('index.html.twig', array('billets' => $billets));
    })->bind('home');


// billet details with comments
$app->match('/billet/{billet_id}', function ($billet_id, Request $request) use ($app) {
    $billet = $app['dao.billet']->find($billet_id);
    $commentFormView = null;
    
    //Comment form
        $comment = new Comment();
        $comment->setBillet($billet);
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'Your comment was successfully added.');
        }
        $commentFormView = $commentForm->createView();
         
    $comments = $app['dao.comment']->findAllByArticle($billet_id);
        
    return $app['twig']->render('billet.html.twig', array(
        'billet' => $billet, 
        'comments' => $comments,
        'commentForm' => $commentFormView));
    })->bind('billet');



//Report form
$app->match('/billet/{billet_id}/{com_id}/report', function($billet_id, $com_id, Request $request) use ($app) {
    $ComSignal = $app['dao.comment']->setComSignal($com_id);
    $billet = $app['dao.billet']->find($billet_id);
    $comments = $app['dao.comment']->findAll();
    $app['session']->getFlashBag()->add('success', 'Your comment was successfully report.');
    return $app['twig']->render('report.html.twig', array(
        'billet' => $billet,
        'comments' => $comments));
}) ->bind('report');


// Login form
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');


// Register form
$app->match('/register', function(Request $request) use ($app) {
    $user = new User();
    $userForm = $app['form.factory']->create(UserType::class, $user);
    $userForm->handleRequest($request);
    if ($userForm->isSubmitted() && $userForm->isValid()) {
        
        // generate a random salt value
        $salt = substr(md5(time()), 0, 23);
        $user->setSalt($salt);
        $plainPassword = $user->getPassword();
        
        // find the default encoder
        $encoder = $app['security.encoder.bcrypt'];
        
        // compute the encoded password
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password); 
        $app['dao.user']->save($user);
        $app['session']->getFlashBag()->add('success', 'The user was successfully created.');
    }
    return $app['twig']->render('register.html.twig', array(
        'title' => 'New user',
        'userForm' => $userForm->createView()));
})->bind('register');

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

// Remove a billet
$app->get('/admin/billet/{billet_id}/delete', function($billet_id, Request $request) use ($app) {
    // Delete all associated comments
    $app['dao.comment']->deleteAllByArticle($billet_id);
    // Delete the billet
    $app['dao.billet']->delete($billet_id);
    $app['session']->getFlashBag()->add('success', 'The billet was successfully removed.');
    // Redirect to admin home page
    return $app->redirect($app['url_generator']->generate('admin'));
})->bind('admin_billet_delete');

// Edit an existing comment
$app->match('/admin/comment/{com_id}/edit', function($com_id, Request $request) use ($app) {
    $comment = $app['dao.comment']->find($com_id);
    $commentForm = $app['form.factory']->create(CommentType::class, $comment);
    $commentForm->handleRequest($request);
    if ($commentForm->isSubmitted() && $commentForm->isValid()) {
        $app['dao.comment']->save($comment);
        $app['session']->getFlashBag()->add('success', 'The comment was successfully updated.');
    }
    return $app['twig']->render('comment_form.html.twig', array(
        'title' => 'Editer un commentaire',
        'commentForm' => $commentForm->createView()));
})->bind('admin_comment_edit');

// Remove a comment
$app->get('/admin/comment/{com_id}/delete', function($com_id, Request $request) use ($app) {
    $app['dao.comment']->delete($com_id);
    $app['session']->getFlashBag()->add('success', 'The comment was successfully removed.');
    // Redirect to admin home page
    return $app->redirect($app['url_generator']->generate('admin'));
})->bind('admin_comment_delete');

// Add a user
$app->match('/admin/user/add', function(Request $request) use ($app) {
    $user = new User();
    $userForm = $app['form.factory']->create(UserType::class, $user);
    $userForm->handleRequest($request);
    if ($userForm->isSubmitted() && $userForm->isValid()) {
        // generate a random salt value
        $salt = substr(md5(time()), 0, 23);
        $user->setSalt($salt);
        $plainPassword = $user->getPassword();
        // find the default encoder
        $encoder = $app['security.encoder.bcrypt'];
        // compute the encoded password
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password); 
        $app['dao.user']->save($user);
        $app['session']->getFlashBag()->add('success', 'The user was successfully created.');
    }
    return $app['twig']->render('user_form.html.twig', array(
        'title' => 'New user',
        'userForm' => $userForm->createView()));
})->bind('admin_user_add');

// Edit an existing user
$app->match('/admin/user/{id}/edit', function($id, Request $request) use ($app) {
    $user = $app['dao.user']->find($id);
    $userForm = $app['form.factory']->create(UserType::class, $user);
    $userForm->handleRequest($request);
    if ($userForm->isSubmitted() && $userForm->isValid()) {
        $plainPassword = $user->getPassword();
        // find the encoder for the user
        $encoder = $app['security.encoder_factory']->getEncoder($user);
        // compute the encoded password
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password); 
        $app['dao.user']->save($user);
        $app['session']->getFlashBag()->add('success', 'The user was successfully updated.');
    }
    return $app['twig']->render('user_form.html.twig', array(
        'title' => 'Edit user',
        'userForm' => $userForm->createView()));
})->bind('admin_user_edit');

// Remove a user
$app->get('/admin/user/{id}/delete', function($id, Request $request) use ($app) {
    // Delete all associated comments
    $app['dao.comment']->deleteAllByUser($id);
    // Delete the user
    $app['dao.user']->delete($id);
    $app['session']->getFlashBag()->add('success', 'The user was successfully removed.');
    // Redirect to admin home page
    return $app->redirect($app['url_generator']->generate('admin'));
})->bind('admin_user_delete');