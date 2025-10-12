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
            'pagination' => [
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
                'total_items' => $this->total(),
                'per_page' => $this->perPage()
            ],
        ];
    }

    public function toResponse($request)
    {
        $response = parent::toResponse($request);

        return response()->json($this->toArray($request), $response->getStatusCode());
    }
}
