<?php

namespace test\service;

use com\linways\base\test\BaseTestCase;
use com\linways\core\dto\Post;
use com\linways\core\service\PostService;

class PostServiceTest extends BaseTestCase
{

    protected function setUp()
    {
        $testDBConfPath = __DIR__ . '/../../db_conf/ams_db_conf.php';
        putenv("TEST_DB_CONFIG=$testDBConfPath");
        putenv("DB_PROFESIONAL_CONFIG=$testDBConfPath");
        putenv("DB_PROFESSIONAL_CONFIG=$testDBConfPath");
        $this->clearDBTable('posts');
    }

    public function getPost()
    {
        $post = new Post();
        $post->title = 'Blog';
        $post->content = 'first blog';
        $post->userId = 6;
        $post->createdBy = 6;

        return $post;
    }

    public function getUpdate()
    {
        $post = new Post();
        $post->id = 1;
        $post->title = 'The Blog';
        $post->content = 'first blog';

        return $post;
    }

    public function testCreatePost()
    {
        $post = $this->getPost();
        $result = PostService::getInstance()->createPost($post);
        $this->assertIsInt($result);
    }

    public function testPostUpdate()
    {
        $post = $this->getUpdate();
        $result = PostService::getInstance()->updatePost($post);
        $this->assertDatabaseHas("posts", ["id" => "15", "title" => "The Blog", "content" => "first blog"]);
    }

    public function testPostDetails()
    {
        $result = PostService::getInstance()->listaPost(1);
        $this->assertIsObject($result);
    }

    public function testAllPostDetails()
    {
        $result = PostService::getInstance()->listAllPost();
        $this->assertIsArray($result);
    }


    public function testDeletePost()
    {
        $this->assertDatabaseHas('posts',["id"=>"15"]);
        $result = PostService::getInstance()->deletePost(15);
        $this->assertDatabaseHasNot('posts',["id"=>"15"]);
        
       
    }
}
