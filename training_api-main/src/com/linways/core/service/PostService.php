<?php

namespace com\linways\core\service;

use com\linways\base\util\MakeSingletonTrait;
use com\linways\core\dto\Post;
use com\linways\core\exception\GlobalException;


class PostService extends BaseService
{
    use MakeSingletonTrait;

    /**
     * Save a post
     * @param  Post $post
     * @return int id for createPost and null for updatePost
 
     */

    public function savePost(Post $post)
    {
        $post = $this->realEscapeObject($post);
        try {
            $this->validateSavePost($post);

            if (!empty($post->id)) {
                $post->id = $this->updatePost($post);
            } else {
                $post->id = $this->createPost($post);
            }
            return $post->id;
        } catch (\Exception $e) {
            throw new GlobalException($e->getCode(), $e->getMessage());

            if (
                $e->getCode() != GlobalException::INVALID_PARAMETERS && $e->getCode() != GlobalException::EMPTY_PARAMETERS
                && $e->getCode() != GlobalException::POST_NOT_FOUND
            ) {
                throw new GlobalException(GlobalException::SOMETHING_WENT_WRONG, "Failed to create post,
                Please try again");
            } else {
                throw new GlobalException($e->getCode(), $e->getMessage());
            }
        }
    }


    /**
     * create new post
     * @param  Post post
     * @return int id
     */


    public function createPost(Post $post)
    {
        $query = "INSERT INTO posts (title, content,user_id,created_by) 
        VALUES ('$post->title', '$post->content','$post->userId','$post->createdBy');";
        try {
            $id = $this->executeQueryForObject($query, True);
            return $id;
        } catch (\Exception $e) {
            throw new GlobalException($e->getCode(), $e->getMessage());
        }
    }


    /**
     * update a post
     * @param  Post post
     * @return null
     */


    public function updatePost(Post $post)
    {

        $query = "UPDATE posts
        SET title = '$post->title', content= '$post->content'
        WHERE id='$post->id' AND user_id='$post->userId';";
        try {
            $this->executeQuery($query);
            return null;
        } catch (\Exception $e) {
            throw new GlobalException($e->getCode(), $e->getMessage());
        }
    }


    /**
     * delete a post
     * @param  int id
     * @return null
     */


    public function deletePost(int $id, int $userId)
    {
        if (!empty($id)) {

            $query = "DELETE FROM posts WHERE id='$id' AND user_id='$userId';";
            try {

                $this->executeQuery($query);
                return null;
            } catch (\Exception $e) {
                throw new GlobalException($e->getCode(), $e->getMessage());
            }
        } else
            throw new GlobalException(GLobalException::EMPTY_PARAMETERS, "id is empty! Please enter a id"); {
        }
    }

    /**
     * get the details of a post
     * @param  int id
     * @return Post
     */


    public function listaPost(int $id)
    {
        if (!empty($id)) {
            $query = "SELECT title,content FROM posts WHERE id='$id';";

            try {
                $post = $this->executeQueryForObject($query);
                if (!empty($post))
                    return $post;
                throw new GlobalException(GLobalException::POST_NOT_FOUND, "post not found");
            } catch (\Exception $e) {
                throw new GlobalException($e->getCode(), $e->getMessage());
            }
        } else
            throw new GlobalException(GLobalException::EMPTY_PARAMETERS, "id is empty! Please enter a id");
    }


    /**
     * get all the post
     * @param null
     * @return list
     */


    public function listAllPosts()
    {
        $query = "SELECT id,title,content FROM posts ORDER BY id DESC;";

        try {
            $posts = $this->executeQueryForList($query);
            if (!empty($posts))
                return $posts;
            throw new GlobalException(GLobalException::POST_NOT_FOUND, "post not found");
        } catch (\Exception $e) {
            throw new GlobalException($e->getCode(), $e->getMessage());
        }
    }



    /**
     * get all the post
     * @param int $userId
     * @return list
     */


    public function listAllPostOfaUser(int $userId)
    {
        $query = "SELECT id,title,content FROM posts WHERE user_id='$userId' ORDER BY id DESC;";

        try {
            $posts = $this->executeQueryForList($query);
            if (!empty($posts))
                return $posts;
            throw new GlobalException(GLobalException::POST_NOT_FOUND, "post not found");
        } catch (\Exception $e) {
            throw new GlobalException($e->getCode(), $e->getMessage());
        }
    }




    /**
     * Validate Post data Before Saving
     * @param Posts $post
     * @return NULL
     */


    private function validateSavePost(Post $post)
    {
        if (empty($post->title))
            throw new GLobalException(GlobalException::EMPTY_PARAMETERS, "Post title is empty! Please enter a title");

        if (empty($post->content))
            throw new GLobalException(GLobalException::EMPTY_PARAMETERS, "Post content is empty! Please enter the content");
    }
}
