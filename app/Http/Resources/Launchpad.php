<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Launchpad extends JsonResource
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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'factory_id' => $this->factory_id,
            'contract' => $this->contract,
            'token' => $this->token,
            'name' => $this->name,
            'symbol' => $this->symbol,
            'description' => $this->description,
            'chainId' => (int) $this->chainId,
            'twitter' => $this->twitter,
            'discord' => $this->discord,
            'telegram' => $this->telegram,
            'website' => $this->website,
            'status' => $this->status,
            'logo' => $this->logo,
            'featured' => $this->featured,
            'kingofthehill' => $this->kingofthehill,
            'active' => $this->active,
            'factory' => new Factory($this->whenLoaded('factory')),
            'user' => new ViewUser($this->whenLoaded('user')),
            'trades' => Trade::collection($this->whenLoaded('trades')),
            'msgs' => Msg::collection($this->whenLoaded('msgs')),
            'uploads' => Upload::collection($this->whenLoaded('uploads')),
        ];
    }
}
