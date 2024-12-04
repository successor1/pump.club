<?php
namespace App\Http\Controllers;
use App\Actions\Uploads;
use App\Http\Controllers\Controller;
use App\Http\Resources\Rate as RateResource ;
use App\Models\Rate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RatesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index(Request $request )
    {
        $keyword = $request->get('search');
        $perPage = 25;
        $query  = Rate::query();
        if (!empty($keyword)) {
            $query->where('symbol', 'LIKE', "%$keyword%")
			->orWhere('chainId', 'LIKE', "%$keyword%")
			->orWhere('usd_rate', 'LIKE', "%$keyword%");
        } 
        $ratesItems = $query->latest()->paginate($perPage);
        $rates = RateResource::collection($ratesItems);
        return Inertia::render('Rates/Index', compact('rates'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return Inertia::render('Rates/Create');
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request )
    {
        $request->validate([
			'symbol' => ['required','string'],
			'symbol_uri' => ['required', 'string'],
			'symbol_upload' => ['required', 'boolean'],
			'symbol_path' => ['nullable', 'string', 'required_if:symbol_upload,true'],
			'chainId' => ['required','string'],
			'usd_rate' => ['nullable','string','url'],
		]);
        $rate = new Rate;
        $rate->symbol = $request->symbol;
		$rate->chainId = $request->chainId;
		$rate->usd_rate = $request->usd_rate;
		$rate->save();
        app(Uploads::class)->upload($request,  $rate, 'symbol');
        return redirect()->route('rates.index')->with('success', 'Rate added!');
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, Rate $rate)
    {
        
        return Inertia::render('Rates/Show', [
            'rate'=> new RateResource($rate)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Rate $rate)
    {
        
        return Inertia::render('Rates/Edit', [
            'rate'=> new RateResource($rate)
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
    public function update(Request $request, Rate $rate)
    {
        $request->validate([
			'symbol' => ['required','string'],
			'symbol_uri' => ['required', 'string'],
			'symbol_upload' => ['required', 'boolean'],
			'symbol_path' => ['nullable', 'string', 'required_if:symbol_upload,true'],
			'chainId' => ['required','string'],
			'usd_rate' => ['nullable','string','url'],
		]);
        app(Uploads::class)->upload($request,  $rate, 'symbol');
        $rate->symbol = $request->symbol;
		$rate->chainId = $request->chainId;
		$rate->usd_rate = $request->usd_rate;
		$rate->save();
        return back()->with('success', 'Rate updated!');
    }

     /**
     * toggle status of  the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function toggle(Request $request, Rate $rate)
    {
        $rate->active = !$rate->active;
        $rate->save();
        return back()->with('success', $rate->active ? __(' :name Rate Enabled !', ['name' => $rate->name]) : __(' :name  Rate Disabled!', ['name' => $rate->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Rate $rate)
    {
        $rate->delete();
        return redirect()->route('rates.index')->with('success', 'Rate deleted!');
    }
}
