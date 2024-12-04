<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Resources\Factory as FactoryResource ;
use App\Models\Factory;
use Inertia\Inertia;

use Illuminate\Http\Request;

class FactoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index(Request $request )
    {
        $keyword = $request->get('search');
        $perPage = 25;
        $query  = Factory::query()->with(['launchpads']);
        if (!empty($keyword)) {
            $query->where('version', 'LIKE', "%$keyword%")
			->orWhere('chainId', 'LIKE', "%$keyword%")
			->orWhere('foundry', 'LIKE', "%$keyword%")
			->orWhere('contract', 'LIKE', "%$keyword%")
			->orWhere('lock', 'LIKE', "%$keyword%")
			->orWhere('lock_abi', 'LIKE', "%$keyword%")
			->orWhere('factory_abi', 'LIKE', "%$keyword%")
			->orWhere('abi', 'LIKE', "%$keyword%")
			->orWhere('active', 'LIKE', "%$keyword%");
        } 
        $factoriesItems = $query->latest()->paginate($perPage);
        $factories = FactoryResource::collection($factoriesItems);
        return Inertia::render('Factories/Index', compact('factories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return Inertia::render('Factories/Create');
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request )
    {
        $request->validate([
			'version' => ['required','string'],
			'chainId' => ['required','string'],
			'foundry' => ['required','string'],
			'contract' => ['required','string'],
			'lock' => ['required','string'],
			'lock_abi' => ['required','string'],
			'factory_abi' => ['required','string'],
			'abi' => ['required','string'],
			'active' => ['nullable','boolean'],
		]);
        $factory = new Factory;
        $factory->version = $request->version;
		$factory->chainId = $request->chainId;
		$factory->foundry = $request->foundry;
		$factory->contract = $request->contract;
		$factory->lock = $request->lock;
		$factory->lock_abi = $request->lock_abi;
		$factory->factory_abi = $request->factory_abi;
		$factory->abi = $request->abi;
		$factory->active = $request->active;
		$factory->save();
        
        return redirect()->route('factories.index')->with('success', 'Factory added!');
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, Factory $factory)
    {
        $factory->load(['launchpads']);
        return Inertia::render('Factories/Show', [
            'factory'=> new FactoryResource($factory)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Factory $factory)
    {
        $factory->load(['launchpads']);
        return Inertia::render('Factories/Edit', [
            'factory'=> new FactoryResource($factory)
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
    public function update(Request $request, Factory $factory)
    {
        $request->validate([
			'version' => ['required','string'],
			'chainId' => ['required','string'],
			'foundry' => ['required','string'],
			'contract' => ['required','string'],
			'lock' => ['required','string'],
			'lock_abi' => ['required','string'],
			'factory_abi' => ['required','string'],
			'abi' => ['required','string'],
			'active' => ['nullable','boolean'],
		]);
        
        $factory->version = $request->version;
		$factory->chainId = $request->chainId;
		$factory->foundry = $request->foundry;
		$factory->contract = $request->contract;
		$factory->lock = $request->lock;
		$factory->lock_abi = $request->lock_abi;
		$factory->factory_abi = $request->factory_abi;
		$factory->abi = $request->abi;
		$factory->active = $request->active;
		$factory->save();
        return back()->with('success', 'Factory updated!');
    }

     /**
     * toggle status of  the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function toggle(Request $request, Factory $factory)
    {
        $factory->active = !$factory->active;
        $factory->save();
        return back()->with('success', $factory->active ? __(' :name Factory Enabled !', ['name' => $factory->name]) : __(' :name  Factory Disabled!', ['name' => $factory->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Factory $factory)
    {
        $factory->delete();
        return redirect()->route('factories.index')->with('success', 'Factory deleted!');
    }
}
