<?php

namespace com\linways\core\dto;

use com\linways\base\dto\BaseDTO;

class Post extends BaseDTO
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */

    public $title;

    /**
     * @var string
     */
    public $content;

    /**
     * @var int
     */
    public $userId;
}
