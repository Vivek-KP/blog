<?php

namespace com\linways\core\service;

use com\linways\base\util\MakeSingletonTrait;
use com\linways\core\dto\Comment;
use com\linways\core\exception\GlobalException;

class CommentService extends BaseService
{
    use MakeSingletonTrait;

    /**
     * Save comment
     * @param  Comment $comment
     * @return int id for createComment and null for updateComment

     */

    public function saveComment(Comment $comment)
    {

        $comment = $this->realEscapeObject($comment);

        try {
            $this->validateSaveComment($comment);

            if (!empty($comment->id)) {
                $comment->id = $this->updateComment($comment);
            } else {
                $comment->id = $this->createComment($comment);
            }
            return $comment->id;
        } catch (\Exception $e) {
            if (
                $e->getCode() != GLobalException::INVALID_PARAMETERS &&
                $e->getCode() != GLobalException::EMPTY_PARAMETERS && $e->getCode() != GLobalException::COMMENT_NOT_FOUND
            ) {
                throw new GLobalException(GlobalException::SOMETHING_WENT_WRONG, "Failed to post comment.Please try again");
            } else {
                throw new GLobalException($e->getCode(), $e->getMessage());
            }
        }
    }



    /**
     * create new comment
     * @param  Comment $comment
     * @return int id
     */

    public function createComment(Comment $comment)
    {

        $query = "INSERT INTO comments (comment, user_id,post_id,created_by) 
         VALUES ('$comment->comment', '$comment->userId','$comment->postId',$comment->createdBy);";
        try {
            $id = $this->executeQueryForObject($query, TRUE);
            return $id;
        } catch (\Exception $e) {
            throw new GLobalException($e->getCode(), $e->getMessage());
        }
    }



    /**
     * update comment
     * @param  Comment $comment
     * @return null
     */

    public function updateComment(Comment $comment)
    {

        $query = "UPDATE comments
        SET comment= '$comment->comment'
        WHERE id='$comment->id';";
        try {
            $this->executeQuery($query);
            return null;
        } catch (\Exception $e) {
            throw new GLobalException($e->getCode(), $e->getMessage());
        }
    }



    /**
     * delete a comment
     * @param  int $id
     * @return null
     */


    public function deleteComment(int $id)
    {
        if (!empty($id)) {

            $query = "DELETE FROM comments WHERE id='$id';";
            try {
                $this->executeQuery($query);
                return null;
            } catch (\Exception $e) {
                throw new GlobalException($e->getCode(), $e->getMessage());
            }
        } else
            throw new GlobalException(GlobalException::EMPTY_PARAMETERS, "id is empty! Please enter a id");
    }



    /**
     * get all the comments
     * @param int $postId
     * @return list
     */


    public function listAllComments(int $postId)
    {

        $query = "SELECT id,comment FROM comments WHERE post_id='$postId';";

        try {
            $comments = $this->executeQueryForList($query);
            if (!empty($comments))
                return $comments;
            throw new GlobalException(GlobalException::COMMENT_NOT_FOUND, "Post or Comment not found");
        } catch (\Exception $e) {
            throw new GlobalException($e->getCode(), $e->getMessage());
        }
    }


    /**
     * get a  comment
     * @param int $id
     * @return object 
     */

    public function getAComment(int $id)
    {
        if (!empty($id)) {

            $query = "SELECT user_id,comment FROM comments WHERE id='$id';";
            $userId = $this->executeQueryForObject($query);
            if (!empty($userId))
                return $userId;
            throw new GlobalException(GlobalException::COMMENT_NOT_FOUND, "Comment not found");
        } else
            throw new GlobalException(GlobalException::EMPTY_PARAMETERS, "id is empty! Please enter a id");
    }


    /**
     * Validate Comment Before Saving
     * @param Comment $comment
     * @return NULL
     */

    private function validateSaveComment(Comment $comment)
    {
        if (empty($comment->comment))
            throw new GlobalException(GlobalException::EMPTY_PARAMETERS, "Comment is empty! Please enter a comment");
    }
}
