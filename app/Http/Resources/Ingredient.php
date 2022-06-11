<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ingredient extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "name" => $this->name,
            "image" => $this->image,
            "ingredient_category_id" => $this->ingredient_category_id,
        ];
    }
}
