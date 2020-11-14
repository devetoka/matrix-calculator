<?php


namespace App\Utils\Validation;


use App\Http\Response\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait FailedValidation
{
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->getMessageBag()->getMessages();
        $response =  ApiResponse::sendResponse([], trans('validate.error'),
            false, ApiResponse::HTTP_UNPROCESSABLE_ENTITY, $errors
        );

        throw new HttpResponseException($response);
    }

}