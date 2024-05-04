<?php

namespace com\linways\core\dto;

use com\linways\base\dto\BaseDTO;

class User extends BaseDTO 
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     * 
     */
    public $email;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $password;


}