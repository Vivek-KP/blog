<?php

namespace com\linways\core\request;

use com\linways\base\request\BaseRequest;

class PasswordUpdateData extends BaseRequest
{
    /**
     * $var int
     */
    public $userId;

    /**
     * $var string
     */
    public $oldPassword;

    /**
     * $var string
     */
    public $newPassword;
}
