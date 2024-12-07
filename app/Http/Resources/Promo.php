<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Promo extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'image' => $this->image,
            'url' => $this->url,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'active' => $this->active,

        ];
    }
}
