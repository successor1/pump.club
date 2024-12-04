<?php

namespace App\Events;

use App\Models\Trade;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewTradeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $trade;

    public function __construct(Trade $trade)
    {
        $this->trade = $trade;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('launchpad.' . $this->trade->launchpad_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->trade->id,
            'launchpad_id' => $this->trade->launchpad_id,
            'txid' => $this->trade->txid,
            'qty' => $this->trade->qty,
            'amount' => $this->trade->amount,
            'type' => $this->trade->type,
            'created_at' => $this->trade->created_at,
            'price' => bcdiv($this->trade->amount, $this->trade->qty, 18)
        ];
    }
}
