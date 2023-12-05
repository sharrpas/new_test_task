<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => ProductResource::collection($this->collection),
            'links' => [
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'next_page' => $this->nextPageUrl(),
                'previous_page' => $this->previousPageUrl(),
            ],
        ];    }
}
