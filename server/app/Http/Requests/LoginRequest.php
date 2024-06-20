<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Resources\Common\SendSingleErrorCollection;
use Symfony\Component\HttpFoundation\Response;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|max:50',
            'password' => 'required|max:20',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = new SendSingleErrorCollection('Validation Error', Response::HTTP_UNPROCESSABLE_ENTITY);
        $errors->setErrors($validator->errors()->toArray());

        throw new HttpResponseException(
            response()->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
