<?php

namespace App\Http\Controllers;

use App\Actions\Uploads;
use App\Enums\LaunchpadStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Factory as ResourcesFactory;
use App\Http\Resources\Launchpad as LaunchpadResource;
use App\Http\Resources\Msg;
use App\Http\Resources\Trade;
use App\Models\Factory;
use App\Models\Launchpad;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LaunchpadsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;
        $query  = Launchpad::query()->with(['user', 'trades']);
        if (!empty($keyword)) {
            $query->where('contract', 'LIKE', "%$keyword%")
                ->orWhere('token', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('symbol', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('website', 'LIKE', "%$keyword%");
        }
        $launchpadsItems = $query->latest()->paginate($perPage);
        $launchpads = LaunchpadResource::collection($launchpadsItems);
        return Inertia::render('Launchpads/Index', compact('launchpads'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $factories = Factory::latestByChain()->get();
        return Inertia::render('Launchpads/Create', [
            'factories' => ResourcesFactory::collection($factories)->keyBy('chainId')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'factory_id' => ['required', 'integer', 'exists:factories,id'],
            'contract' => ['string', 'required'],
            'token' => ['string', 'required'],
            'name' => ['string', 'required'],
            'symbol' => ['string', 'required'],
            'description' => ['string', 'required'],
            'chainId' => ['numeric', 'required'],
            'twitter' => ['string', 'nullable'],
            'discord' => ['string', 'nullable'],
            'telegram' => ['string', 'nullable'],
            'website' => ['string', 'nullable'],
            'logo_uri' => ['nullable', 'required_if:logo_upload,false', 'string'],
            'logo_upload' => ['required', 'boolean'],
            'logo_path' => ['nullable', 'array', 'required_if:logo_upload,true'],
        ]);
        $launchpad = new Launchpad;
        $launchpad->user_id = $request->user()->id;
        $launchpad->factory_id = $request->factory_id;
        $launchpad->contract = $request->contract;
        $launchpad->token = $request->token;
        $launchpad->name = $request->name;
        $launchpad->symbol = $request->symbol;
        $launchpad->description = $request->description;
        $launchpad->chainId = $request->chainId;
        $launchpad->twitter = $request->twitter;
        $launchpad->discord = $request->discord;
        $launchpad->telegram = $request->telegram;
        $launchpad->website = $request->website;
        $launchpad->status = LaunchpadStatus::PREBOND;
        $launchpad->save();
        $upload = app(Uploads::class)->upload($request,  $launchpad, 'logo');
        $launchpad->logo = $upload->url;
        $launchpad->save();
        return redirect()->route('launchpads.show', ['launchpad' => $launchpad->contract]);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, Launchpad $launchpad)
    {

        return Inertia::render('Launchpads/Show', [
            'launchpad' => function () use ($launchpad) {
                $launchpad->load(['factory', 'user']);
                return new LaunchpadResource($launchpad);
            },
            'trades' => function () use ($launchpad) {
                $trades = $launchpad->trades()->latest()->take(12)->get();
                return Trade::collection($trades);
            },
            'msgs' => function () use ($launchpad) {
                $msgs = $launchpad->msgs()->latest()->take(50)->get();
                return Msg::collection($msgs);
            },
            'pinned' => function () use ($launchpad) {
                $msgs = $launchpad->msgs()->where('pinned', true)->latest()->take(2)->get();
                return Msg::collection($msgs);
            },
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
    public function update(Request $request, Launchpad $launchpad)
    {
        $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'factory_id' => ['required', 'integer', 'exists:factories,id'],
            'contract' => ['string', 'required'],
            'token' => ['string', 'required'],
            'name' => ['string', 'required'],
            'symbol' => ['string', 'required'],
            'description' => ['string', 'required'],
            'chainId' => ['string', 'required'],
            'twitter' => ['string', 'nullable'],
            'discord' => ['string', 'nullable'],
            'telegram' => ['string', 'nullable'],
            'website' => ['string', 'nullable'],
            'logo' => ['string', 'required'],
            'logo_uri' => ['required', 'string'],
            'logo_upload' => ['required', 'boolean'],
            'logo_path' => ['nullable', 'string', 'required_if:logo_upload,true'],
            'featured' => ['nullable', 'boolean'],
            'kingofthehill' => ['nullable', 'boolean'],
            'active' => ['nullable', 'boolean'],
        ]);
        app(Uploads::class)->upload($request,  $launchpad, 'logo');
        $launchpad->user_id = $request->user_id;
        $launchpad->factory_id = $request->factory_id;
        $launchpad->contract = $request->contract;
        $launchpad->token = $request->token;
        $launchpad->name = $request->name;
        $launchpad->symbol = $request->symbol;
        $launchpad->description = $request->description;
        $launchpad->chainId = $request->chainId;
        $launchpad->twitter = $request->twitter;
        $launchpad->discord = $request->discord;
        $launchpad->telegram = $request->telegram;
        $launchpad->website = $request->website;
        $launchpad->status = $request->status;
        $launchpad->logo = $request->logo;
        $launchpad->featured = $request->featured;
        $launchpad->kingofthehill = $request->kingofthehill;
        $launchpad->active = $request->active;
        $launchpad->save();
        return back()->with('success', 'Launchpad updated!');
    }
}
