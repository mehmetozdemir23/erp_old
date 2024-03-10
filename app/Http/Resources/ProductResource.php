<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'thumbnail' => $this->thumbnail(),
            'name' => $this->name,
            'category' => $this->whenLoaded('category', fn () => $this->category->name),
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock->quantity,
            'sales_count' => $this->whenCounted('sales'),
            'last_update' => $this->updated_at->diffForHumans(),
        ];
    }
}
