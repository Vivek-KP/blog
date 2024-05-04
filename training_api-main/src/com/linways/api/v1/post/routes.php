<?php
    $app->post("/add[/]", "PostController:createPost");


    $app->get("/p1/{id}[/]","PostController:getPost");

    $app->get("/all/{userId}[/]","PostController:getAllPostsOfaUser");

    
    $app->get("/all[/]","PostController:getAllPosts");

    $app->post("/update/{userId}/{id}[/]", "PostController:updatePost");


    $app->delete("/{userId}/{id}[/]", "PostController:deletePost");


    

   
