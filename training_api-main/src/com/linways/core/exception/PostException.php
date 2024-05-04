<?php

namespace com\linways\core\exception;

use com\linways\base\exception\CoreException;

class PostException extends CoreException
{
    const EMPTY_PARAMETERS = "EMPTY_PARAMETERS";

    const INVALID_PARAMETERS = "INVALID_PARAMETERS";

    const POST_NOT_FOUND = "POST_NOT FOUND";

    const ERROR_SAVING_CURRICULUM = "ERROR_SAVING_CURRICULUM";

}