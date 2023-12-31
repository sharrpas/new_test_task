<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
//            'id' => $this->id,
            'order_id' => $this->order_id,
            'status' => $this->status,
            'product' => $this->product->title,
            'user' => $this->user->name,
            'created_at' => $this->created_at
            ];
    }
}
