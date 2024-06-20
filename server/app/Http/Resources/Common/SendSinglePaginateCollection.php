<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class SendSinglePaginateCollection extends ResourceCollection
{
    private $message;

    public function __construct($resource, $message)
    {
        parent::__construct($resource);
        $this->message = $message;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => [
                'code' => Response::HTTP_OK,
                'message' => $this->message
            ],
            'data' => $this->collection,
            'pagination' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
            ],
        ];
    }
}
