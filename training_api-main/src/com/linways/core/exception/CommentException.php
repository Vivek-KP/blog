<?php

namespace com\linways\core\exception;

use com\linways\base\exception\CoreException;

class CommentException extends CoreException
{
    const EMPTY_PARAMETERS = "EMPTY_PARAMETERS";

    const INVALID_PARAMETERS = "INVALID_PARAMETERS";

    const COMMENT_NOT_FOUND = "COMMENT_NOT_FOUND";

    const ERROR_SAVING_CURRICULUM = "ERROR_SAVING_CURRICULUM";

}