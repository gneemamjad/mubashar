<?php

namespace App\Exceptions;

use App\Helpers\ResponseCode;
use App\Traits\Response;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryNotFoundException extends Exception
{
    use Response;

    public function render()
    {
        throw new HttpResponseException(
            $this->errorResponse("Category not found",ResponseCode::NOT_FOUND)
        );
    }
}
