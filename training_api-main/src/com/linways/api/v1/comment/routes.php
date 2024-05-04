<?php

use com\linways\api\v1\commentController\controller\CommentController;

   $app->post("/[/]", "CommentController:createComment");


    $app->get("/{postId}[/]","CommentController:getComments");

   $app->get('/comment/{id}',"CommentController:getComment");

    $app->post("/update/{id}[/]", "CommentController:updateComment");

    $app->delete("/{id}[/]", "CommentController:deleteComment");

    

   
