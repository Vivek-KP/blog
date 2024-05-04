<?php

namespace com\linways\api\v1\commentController\controller;

use com\linways\api\v1\BaseController;
use com\linways\core\dto\Post;
use com\linways\core\service\PostService;
use Linways\Slim\Utils\ResponseUtils;
use Slim\Http\Request;
use Slim\Http\Response;

class PostController extends BaseController
{


    //function for create a post
    protected function createPost(Request $request, Response $response)
    {

        $params = $request->getParsedBody();
        $post = new Post();
        $post->title = $params['title'];
        $post->content = $params['content'];
        $post->userId = $params['userId'];
        $post->createdBy = $params['createdBy'];

        try {

            $id = PostService::getInstance()->savePost($post);
        } catch (\Exception $e) {
            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response, $id);
    }




    //function to update a post
    protected function updatePost(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $userId = $request->getAttribute('userId');
        $body = $request->getParsedBody();

        $post = new Post();
        $post->id = $id;
        $post->userId = $userId;
        $post->title = $body['title'];
        $post->content = $body['content'];

        try {

            PostService::getInstance()->savePost($post);
        } catch (\Exception $e) {
            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response);
    }




    //function get a post
    protected function getPost(Request $request, Response $response)
    {
        $id = $request->getAttribute("id");

        try {

            $post = PostService::getInstance()->listaPost($id);
        } catch (\Exception $e) {
            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response, $post);
    }




    //function all the posts of a user
    protected function getAllPostsOfaUser(Request $request, Response $response)
    {

        $userId = $request->getAttribute("userId");

        try {

            $posts = PostService::getInstance()->listAllPostOfaUser($userId);
        } catch (\Exception $e) {
            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response, $posts);
    }




    //function to get all the posts
    protected function getAllPosts(Request $request, Response $response)
    {

        try {

            $posts = PostService::getInstance()->listAllPosts();
        } catch (\Exception $e) {
            return ResponseUtils::fault($response, $e);
        }

        return ResponseUtils::result($response, $posts);
    }




    //function to delete a post
    protected function deletePost(Request $request, Response $response)
    {

        $userId = $request->getAttribute("userId");
        $id = $request->getAttribute("id");

        try {

            PostService::getInstance()->deletePost($id, $userId);
        } catch (\Exception $e) {
            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response);
    }
}
