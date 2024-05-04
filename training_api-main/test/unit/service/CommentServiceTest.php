<?php

namespace test\service;

use com\linways\base\test\BaseTestCase;
use com\linways\core\dto\Comment;
use com\linways\core\service\CommentService;


class CommentServiceTest extends BaseTestCase
{

    protected function setUp()
    {
        $testDBConfPath = __DIR__ . '/../../db_conf/ams_db_conf.php';
        putenv("TEST_DB_CONFIG=$testDBConfPath");
        putenv("DB_PROFESIONAL_CONFIG=$testDBConfPath");
        putenv("DB_PROFESSIONAL_CONFIG=$testDBConfPath");
        // $this->clearDBTable('comments');
    }

    public function getComment()
    {
        $comment = new Comment();
        $comment->comment = 'first comment';
        $comment->userId = 1;
        $comment->postId = 1;
        $comment->createdBy = 1;


        return $comment;
    }

    public function getUpdate()
    {
        $comment = new Comment();
        $comment->id = 1;
        $comment->comment = 'first super comment';


        return $comment;
    }

    public function testCreatePost()
    {
        $comment = $this->getComment();
        $result = CommentService::getInstance()->createComment($comment);
        $this->assertIsInt($result);
    }

    public function testCommentUpdate()
    {
        $comment = $this->getUpdate();
        $result = CommentService::getInstance()->updateComment($comment);
        $this->assertDatabaseHas("comments", ["id" => "1", "comment" => "first super comment"]);
    }



    public function testAllComments()
    {
        $result = CommentService::getInstance()->listAllComments(1);
        $this->assertIsArray($result);
    }


    public function testDeleteComment()
    {
        $this->assertDatabaseHas('comments',["id"=>"15"]);
        $result = CommentService::getInstance()->deletePost(15);
        $this->assertDatabaseHasNot('comments',["id"=>"15"]);
    }
}
