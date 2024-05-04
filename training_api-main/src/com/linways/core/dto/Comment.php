<?php
namespace com\linways\core\dto;

use com\linways\base\dto\BaseDTO;

class Comment extends BaseDTO
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $comment;

    /**
     * @var int
     */
    public $userId;

    /**
     * @var int
     */
    public $postId;
}