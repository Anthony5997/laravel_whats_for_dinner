<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IngredientsFridge
{
 
    
    public function payload($data) 
    {
        $response = [];
        for ($i=0; $i < count($data) ; $i++) { 
        
            array_push($response, [
                "id" => $data[$i]->id,
                "name" => $data[$i]->name,
                "image"=> $data[$i]->image === null ? '' : $data[$i]->image,
                "category_id"=> $data[$i]->ingredient_category_id,
                "category_name"=> $data[$i]->category_name,
                "quantity"=> $data[$i]->quantity === null ? 0 : $data[$i]->quantity,
                "unit_id"=> $data[$i]->unit_id,
                "unit_name"=> $data[$i]->unit_name
                ]);
            

        } 
        return $response;
    }
}
