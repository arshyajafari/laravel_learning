<?php

namespace App\Http\Resources;

use App\Models\AdminModel;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = auth('sanctum')->user();
        // return parent::toArray($request);
        $isAdmin = is_object($user) && is_a($user, AdminModel::class);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $isAdmin ? $this->price : $this->price * 2,
            'image' => $this->when($isAdmin, $this->image),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'categories' => $this->whenLoaded('categories', CategoryResource::collection($this->categories))
        ];
    }
}
