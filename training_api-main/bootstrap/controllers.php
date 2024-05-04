<?php

use com\linways\api\v1\commentController\controller\CommentController;
use com\linways\api\v1\commentController\controller\PostController;
use com\linways\api\v1\helloWorld\controller\HelloWorldController;
    use com\linways\api\v1\userController\controller\UserController;

    /* Attaching the QUestionController to the Slim application container */
    $container['HelloWorldController'] = function ($container) {
        return new HelloWorldController($container);
    };

    $container['UserController'] = function ($container) {
        return new UserController($container);
    };

    $container['PostController'] = function($container){
        return new PostController($container);
    };

    $container['CommentController'] = function($container){
        return new CommentController($container);
    };