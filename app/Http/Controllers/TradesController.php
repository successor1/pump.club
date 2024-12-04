<?php

namespace App\Http\Controllers;

use App\Enums\TradeType;
use App\Http\Controllers\Controller;
use App\Models\Trade;
use Illuminate\Http\Request;
use App\Models\TradeCandle;
use App\Models\Launchpad;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules\Enum;

class TradesController extends Controller
{

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'launchpad_id' => ['required', 'integer', 'exists:launchpads,id'],
            'address' => ['required', 'string'],
            'qty' => ['required', 'string'],
            'txid' => ['required', 'string'],
            'amount' => ['required', 'string'],
            'type' => ['required', 'string', 'max:255', new Enum(TradeType::class)],
        ]);
        $trade = Trade::where('txid', $request->txid)->firstOrNew();
        $user = $request->user();
        //if user in not current silently discard
        if (strtolower($user->address) != strtolower($request->address)) return back();
        $trade->launchpad_id = $request->launchpad_id;
        $trade->txid = $request->txid;
        $trade->address = $request->address;
        $trade->qty = $request->qty;
        $trade->amount = $request->amount;
        $trade->type = $request->type;
        $trade->save();
        return back();
    }


    /**
     * Retrieve candlestick data for a specific launchpad and timeframe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Launchpad  $launchpad
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @queryParam timeframe string The timeframe for candles (1m, 5m, 15m, 1h, 4h, 1d). Default: 1h
     * @queryParam limit integer The maximum number of candles to return. Default: 200
     *
     * @response {
     *   "candles": [
     *     {
     *       "time": 1638360000,
     *       "open": "1.23456",
     *       "high": "1.25000",
     *       "low": "1.22000",
     *       "close": "1.24500",
     *       "volume": "1000.50"
     *     }
     *   ]
     * }
     */

    public function getCandles(Request $request, Launchpad $launchpad)
    {
        $timeframe = $request->input('timeframe', '1h');
        $limit = $request->input('limit', 200);

        $cacheKey = "candles:{$launchpad->id}:{$timeframe}:{$limit}";

        return Cache::remember($cacheKey, 60, function () use ($launchpad, $timeframe, $limit) {
            $candles = TradeCandle::where('launchpad_id', $launchpad->id)
                ->where('timeframe', $timeframe)
                ->orderBy('timestamp', 'desc')
                ->limit($limit)
                ->get()
                ->map(function ($candle) {
                    return [
                        'time' => $candle->timestamp->timestamp,
                        'open' => (float) $candle->open,
                        'high' => (float) $candle->high,
                        'low' => (float) $candle->low,
                        'close' => (float) $candle->close,
                        'volume' => (float) $candle->volume,
                    ];
                })
                ->reverse()
                ->values();
            return response()->json([
                'candles' => $candles,
            ]);
        });
    }

    /**
     * Retrieve recent trades for a specific launchpad.
     *
     * @param  \App\Models\Launchpad  $launchpad
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "trades": [
     *     {
     *       "id": 1,
     *       "txid": "0x123...",
     *       "qty": "100.5",
     *       "amount": "125.62",
     *       "type": "buy",
     *       "created_at": "2024-01-01T12:00:00Z",
     *       "price": "1.25"
     *     }
     *   ]
     * }
     */
    public function getRecentTrades(Launchpad $launchpad)
    {
        $trades = Trade::where('launchpad_id', $launchpad->id)
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get()
            ->map(function ($trade) {
                return [
                    'id' => $trade->id,
                    'txid' => $trade->txid,
                    'qty' => $trade->qty,
                    'amount' => $trade->amount,
                    'type' => $trade->type,
                    'created_at' => $trade->created_at,
                    'price' => bcdiv($trade->amount, $trade->qty, 18)
                ];
            });

        return response()->json([
            'trades' => $trades
        ]);
    }

    /**
     * Retrieve 24-hour price statistics for a launchpad.
     *
     * @param  \App\Models\Launchpad  $launchpad
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "price": "1.23456",
     *   "change_24h": "5.25",
     *   "volume_24h": "1000000.50",
     *   "high_24h": "1.25000",
     *   "low_24h": "1.22000"
     * }
     */
    public function getPriceStats(Launchpad $launchpad)
    {
        $cacheKey = "price_stats:{$launchpad->id}";
        return Cache::remember($cacheKey, 60, function () use ($launchpad) {
            $latest = Trade::where('launchpad_id', $launchpad->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$latest) {
                return response()->json([
                    'price' => '0',
                    'change_24h' => '0',
                    'volume_24h' => '0',
                    'high_24h' => '0',
                    'low_24h' => '0',
                ]);
            }

            $dayAgo = now()->subDay();
            $stats = DB::table('trades')
                ->where('launchpad_id', $launchpad->id)
                ->where('created_at', '>=', $dayAgo)
                ->select([
                    DB::raw('SUM(CAST(qty AS DECIMAL(36,18))) as volume'),
                    DB::raw('MAX(CAST(amount AS DECIMAL(36,18)) / CAST(qty AS DECIMAL(36,18))) as high'),
                    DB::raw('MIN(CAST(amount AS DECIMAL(36,18)) / CAST(qty AS DECIMAL(36,18))) as low'),
                ])
                ->first();
            // Get first trade price from 24h ago for price change calculation
            $firstTrade = Trade::where('launchpad_id', $launchpad->id)
                ->where('created_at', '>=', $dayAgo)
                ->orderBy('created_at', 'asc')
                ->first();
            $currentPrice = bcdiv($latest->amount, $latest->qty, 18);
            $oldPrice = $firstTrade ? bcdiv($firstTrade->amount, $firstTrade->qty, 18) : $currentPrice;
            // Calculate price change percentage
            $priceChange = $oldPrice != 0 ?
                bcmul(bcdiv(bcsub($currentPrice, $oldPrice, 18), $oldPrice, 18), '100', 2) :
                '0';
            return response()->json([
                'price' => $currentPrice,
                'change_24h' => $priceChange,
                'volume_24h' => $stats->volume ?? '0',
                'high_24h' => $stats->high ?? '0',
                'low_24h' => $stats->low ?? '0',
            ]);
        });
    }
}
