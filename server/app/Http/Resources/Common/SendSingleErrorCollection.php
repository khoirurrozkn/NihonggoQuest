<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SendSingleErrorCollection extends ResourceCollection
{
    private $message;
    private $code;
    private $errors = [];

    public function __construct(string $message, int $code = 500)
    {
        $this->message = $message;
        $this->code = $code;
    }

    public function setErrors(array $errors){
        $this->errors = $errors;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $res = [
            'status' => [
                'code' => $this->code,
                'message' => $this->message
            ]
        ];

        if( !empty($this->errors) ) $res['errors'] = $this->errors;

        return $res;
    }
}
