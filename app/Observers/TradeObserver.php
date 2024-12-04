<?php

namespace App\Observers;

use App\Actions\Candle;
use App\Models\Trade;
use App\Events\NewTradeEvent;

class TradeObserver
{
    public function created(Trade $trade)
    {
        // Queue Broadcast of the new trade event
        NewTradeEvent::dispatch($trade);
        // Update candles
        app(Candle::class)->update($trade);
    }
}
