<?php
    $app->post("/signup[/]", "UserController:userSignup");

    $app->post("/login[/]", "UserController:userLogin");

    $app->get("/{id}[/]","UserController:getUserDetails");

    $app->post("/{id}[/]", "UserController:userUpdate");

    $app->post("/{id}/update[/]", "UserController:passwordUpdate");

    $app->delete("/{id}[/]", "UserController:userDelete");

    

   
