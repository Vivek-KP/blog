<?php

namespace com\linways\core\exception;

use com\linways\base\exception\CoreException;

class GlobalException extends CoreException
{
    const EMPTY_PARAMETERS = "EMPTY_PARAMETERS";

    const INVALID_PARAMETERS = "INVALID_PARAMETERS";

    const USER_NOT_FOUND = "USER_NOT FOUND";

    const SOMETHING_WENT_WRONG = "SOMETHING_WENT_WRONG";
 
    const COMMENT_NOT_FOUND = "COMMENT_NOT_FOUND";

    const POST_NOT_FOUND = "POST_NOT FOUND";


}