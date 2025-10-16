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
            'brand_id' => $this->brand_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'type' => $this->type,
            'is_active' => $this->is_active,
            'attributes' => $this->attributeValues
                ->groupBy('attribute.name')
                ->map(function ($values, $attributeName) {
                    return [
                        'attribute_name' => $attributeName,
                        'values' => $values->pluck('value')->toArray(),
                    ];
                })
                ->values()
        ];
    }
}
