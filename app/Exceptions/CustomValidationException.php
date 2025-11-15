<?php

namespace App\Exceptions;

use App\Helpers\ResponseCode;
use App\Traits\Response;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomValidationException extends Exception
{
    use Response;

    public function render()
    {
        throw new HttpResponseException(
            $this->errorResponse($this->getMessage(),ResponseCode::NOT_FOUND)
        );
    }
}
