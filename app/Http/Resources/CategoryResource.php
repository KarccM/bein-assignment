<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'children'      => $this->children,
            'parnet_id'     => $this->parent_id,
            'parnet'        => new CategoryResource($this->whenLoaded('parent')),
            'products'      => ProductResource::collection($this->whenLoaded('products')),
            'discount'      => $this->getDiscount(),
        ];
    }
}
