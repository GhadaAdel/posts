<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'icon' => $this->icon,
            'parent_id' => $this->when(!is_null($this->parent_id), $this->parent_id),
            'parent_name' => $this->whenLoaded('parent', fn () => $this->parent?->name),
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active
        ];
    }
}
