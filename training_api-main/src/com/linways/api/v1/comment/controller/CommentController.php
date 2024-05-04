<?php

namespace com\linways\api\v1\commentController\controller;

use com\linways\api\v1\BaseController;
use com\linways\core\dto\Comment;
use com\linways\core\service\CommentService;
use Linways\Slim\Utils\ResponseUtils;
use Slim\Http\Request;
use Slim\Http\Response;

class CommentController extends BaseController
{


    //function for create a comment
    protected function createComment(Request $request, Response $response)
    {

        $body = $request->getParsedBody();
        $comment = new Comment();
        $comment->comment = $body['comment'];
        $comment->userId = $body['userId'];
        $comment->postId = $body['postId'];
        $comment->createdBy = $body['createdBy'];

        try {

            $id = CommentService::getInstance()->saveComment($comment);
        } catch (\Exception $e) {
            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response, $id);
    }


    //function to update a comment
    protected function updateComment(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $body = $request->getParsedBody();
        $comment = new Comment();
        $comment->id = $id;
        $comment->comment = $body['comment'];
        try {

            CommentService::getInstance()->updateComment($comment);
        } catch (\Exception $e) {
            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response);
    }



    //function get all comments
    protected function getComments(Request $request, Response $response)
    {

        $postId = $request->getAttribute('postId');

        try {

            $comments = CommentService::getInstance()->listAllComments($postId);
        } catch (\Exception $e) {
            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response, $comments);
    }
    

    //function get a comment

    protected function getComment(Request $request, Response $response)
    {
        $commentId = $request->getAttribute('id');
        try {

            $comment = CommentService::getInstance()->getAComment($commentId);
        } catch (\Exception $e) {
            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response, $comment);
    }



    //function to delete a comment
    protected function deleteComment(Request $request, Response $response)
    {

        $id = $request->getAttribute('id');

        try {

            CommentService::getInstance()->deleteComment($id);
        } catch (\Exception $e) {
            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response);
    }
}
