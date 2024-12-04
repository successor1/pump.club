<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Trade extends JsonResource
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
            'launchpad_id' => $this->launchpad_id,
            'txid' => $this->txid,
            'address' => $this->address,
            'qty' => $this->qty,
            'amount' => $this->amount,
            'type' => $this->type,
            'date' => $this->created_at->toFormattedDateString(),
            'launchpad' => new Launchpad($this->whenLoaded('launchpad')),
        ];
    }
}
