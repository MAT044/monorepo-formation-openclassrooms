<?php

use TomTroc\Controller\BookController;
use TomTroc\Controller\HomeController;
use TomTroc\Controller\MessageController;
use TomTroc\Controller\UserController;
use TomTroc\Core\Router\Router;

return function(Router $router) {
    $router->get('app_home', '/', [HomeController::class, 'index']);
    $router->all('app_user_login', '/connexion', [UserController::class, 'login']);
    $router->all('app_user_register', '/inscription', [UserController::class, 'register']);
    $router->all('app_user_account', '/mon-compte', [UserController::class, 'account']);
    $router->post('app_user_avatar', '/mon-compte/avatar', [UserController::class, 'avatar']);
    $router->get('app_user_info', '/utilisateurs/{id}', [UserController::class, 'info']);
    $router->get('app_books_list', '/livres', [BookController::class, 'list']);
    $router->get('app_books_show', '/livres/{id}', [BookController::class, 'show']);
    $router->get('app_books_delete', '/mes-livres/{id}/supprimer', [BookController::class, 'delete']);
    $router->all('app_books_new', '/mes-livres/nouveau', [BookController::class, 'form']);
    $router->all('app_books_edit', '/mes-livres/{id}/modifier', [BookController::class, 'form']);
    $router->post('app_book_illustration', '/mes-livres/{id}/illustration', [BookController::class, 'illustration']);
    $router->get('app_conversation_list', '/conversations', [MessageController::class, 'messager']);
    $router->all('app_conversation_detail', '/conversations/{id}', [MessageController::class, 'messager']);
};