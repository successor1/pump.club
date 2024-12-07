<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Resources\Poolstat as PoolstatResource ;
use App\Models\Poolstat;
use Inertia\Inertia;

use Illuminate\Http\Request;

class PoolstatsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index(Request $request )
    {
        $keyword = $request->get('search');
        $perPage = 25;
        $query  = Poolstat::query()->with(['launchpad']);
        if (!empty($keyword)) {
            $query->where('launchpad_id', 'LIKE', "%$keyword%")
			->orWhere('token0_price', 'LIKE', "%$keyword%")
			->orWhere('token1_price', 'LIKE', "%$keyword%")
			->orWhere('tvl_usd', 'LIKE', "%$keyword%")
			->orWhere('volume_24h', 'LIKE', "%$keyword%")
			->orWhere('fee_tier', 'LIKE', "%$keyword%")
			->orWhere('transactions_24h', 'LIKE', "%$keyword%")
			->orWhere('total_transactions', 'LIKE', "%$keyword%")
			->orWhere('liquidity', 'LIKE', "%$keyword%")
			->orWhere('price_change_1h', 'LIKE', "%$keyword%")
			->orWhere('price_change_24h', 'LIKE', "%$keyword%")
			->orWhere('price_change_7d', 'LIKE', "%$keyword%")
			->orWhere('min_price_24h', 'LIKE', "%$keyword%")
			->orWhere('max_price_24h', 'LIKE', "%$keyword%")
			->orWhere('timestamp', 'LIKE', "%$keyword%");
        } 
        $poolstatsItems = $query->latest()->paginate($perPage);
        $poolstats = PoolstatResource::collection($poolstatsItems);
        return Inertia::render('Poolstats/Index', compact('poolstats'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return Inertia::render('Poolstats/Create');
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request )
    {
        $request->validate([
			'launchpad_id' => ['required','exists:launchpads,id'],
			'token0_price' => ['required','numeric'],
			'token1_price' => ['required','numeric'],
			'tvl_usd' => ['required','numeric'],
			'volume_24h' => ['required','numeric'],
			'fee_tier' => ['required','numeric'],
			'transactions_24h' => ['required','integer'],
			'total_transactions' => ['required','integer'],
			'liquidity' => ['required','numeric'],
			'price_change_1h' => ['required','numeric'],
			'price_change_24h' => ['required','numeric'],
			'price_change_7d' => ['required','numeric'],
			'min_price_24h' => ['required','numeric'],
			'max_price_24h' => ['required','numeric'],
			'timestamp' => ['required'],
		]);
        $poolstat = new Poolstat;
        $poolstat->launchpad_id = $request->launchpad_id;
		$poolstat->token0_price = $request->token0_price;
		$poolstat->token1_price = $request->token1_price;
		$poolstat->tvl_usd = $request->tvl_usd;
		$poolstat->volume_24h = $request->volume_24h;
		$poolstat->fee_tier = $request->fee_tier;
		$poolstat->transactions_24h = $request->transactions_24h;
		$poolstat->total_transactions = $request->total_transactions;
		$poolstat->liquidity = $request->liquidity;
		$poolstat->price_change_1h = $request->price_change_1h;
		$poolstat->price_change_24h = $request->price_change_24h;
		$poolstat->price_change_7d = $request->price_change_7d;
		$poolstat->min_price_24h = $request->min_price_24h;
		$poolstat->max_price_24h = $request->max_price_24h;
		$poolstat->timestamp = $request->timestamp;
		$poolstat->save();
        
        return redirect()->route('poolstats.index')->with('success', 'Poolstat added!');
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, Poolstat $poolstat)
    {
        $poolstat->load(['launchpad']);
        return Inertia::render('Poolstats/Show', [
            'poolstat'=> new PoolstatResource($poolstat)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Poolstat $poolstat)
    {
        $poolstat->load(['launchpad']);
        return Inertia::render('Poolstats/Edit', [
            'poolstat'=> new PoolstatResource($poolstat)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Poolstat $poolstat)
    {
        $request->validate([
			'launchpad_id' => ['required','exists:launchpads,id'],
			'token0_price' => ['required','numeric'],
			'token1_price' => ['required','numeric'],
			'tvl_usd' => ['required','numeric'],
			'volume_24h' => ['required','numeric'],
			'fee_tier' => ['required','numeric'],
			'transactions_24h' => ['required','integer'],
			'total_transactions' => ['required','integer'],
			'liquidity' => ['required','numeric'],
			'price_change_1h' => ['required','numeric'],
			'price_change_24h' => ['required','numeric'],
			'price_change_7d' => ['required','numeric'],
			'min_price_24h' => ['required','numeric'],
			'max_price_24h' => ['required','numeric'],
			'timestamp' => ['required'],
		]);
        
        $poolstat->launchpad_id = $request->launchpad_id;
		$poolstat->token0_price = $request->token0_price;
		$poolstat->token1_price = $request->token1_price;
		$poolstat->tvl_usd = $request->tvl_usd;
		$poolstat->volume_24h = $request->volume_24h;
		$poolstat->fee_tier = $request->fee_tier;
		$poolstat->transactions_24h = $request->transactions_24h;
		$poolstat->total_transactions = $request->total_transactions;
		$poolstat->liquidity = $request->liquidity;
		$poolstat->price_change_1h = $request->price_change_1h;
		$poolstat->price_change_24h = $request->price_change_24h;
		$poolstat->price_change_7d = $request->price_change_7d;
		$poolstat->min_price_24h = $request->min_price_24h;
		$poolstat->max_price_24h = $request->max_price_24h;
		$poolstat->timestamp = $request->timestamp;
		$poolstat->save();
        return back()->with('success', 'Poolstat updated!');
    }

     /**
     * toggle status of  the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function toggle(Request $request, Poolstat $poolstat)
    {
        $poolstat->active = !$poolstat->active;
        $poolstat->save();
        return back()->with('success', $poolstat->active ? __(' :name Poolstat Enabled !', ['name' => $poolstat->name]) : __(' :name  Poolstat Disabled!', ['name' => $poolstat->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Poolstat $poolstat)
    {
        $poolstat->delete();
        return redirect()->route('poolstats.index')->with('success', 'Poolstat deleted!');
    }
}
