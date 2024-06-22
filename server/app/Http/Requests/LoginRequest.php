<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|max:50',
            'password' => 'required|max:50'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException( 
            response()->json([
                "code" => Response::HTTP_UNPROCESSABLE_ENTITY,
                "status" => "Validation Error",
                "errors" => $validator->errors()->toArray()
            ])
        );
    }
}
