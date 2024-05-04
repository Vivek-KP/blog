<?php

namespace com\linways\core\request;

use com\linways\base\request\BaseRequest;

class LoginData extends BaseRequest
{
    /**
     * $var string
     */
    public $email;

    /**
     * $var string
     */
    public $password;
}
