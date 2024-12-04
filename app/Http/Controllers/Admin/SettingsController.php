<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Uploads;
use App\Enums\SettingRpc;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class SettingsController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $request->validate([
            'logo_uri' => ['nullable', 'required_if:logo_upload,true', 'string'],
            'logo_upload' => ['required', 'boolean'],
            'logo_path' => ['nullable', 'array', 'required_if:logo_upload,true'],
            'name' => ['required', 'string'],
            'twitter' => ['nullable', 'string', 'url'],
            'youtube' => ['nullable', 'string', 'url'],
            'telegram_group' => ['nullable', 'string', 'url'],
            'telegram_channel' => ['nullable', 'string', 'url'],
            'discord' => ['nullable', 'string', 'url'],
            'documentation' => ['nullable', 'string', 'url'],
            'rpc' => ['nullable', 'string',  new Enum(SettingRpc::class)],
            'ankr' => ['nullable', 'string'],
            'infura' => ['nullable', 'string'],
            'blast' => ['nullable', 'string'],
            'chat' => ['nullable', 'boolean'],
            'featured' => ['nullable', 'boolean'],
        ]);
        $setting = Setting::find(1);
        if ($request->logo_upload || $request->logo_uri) {
            $upload = app(Uploads::class)->upload($request,  $setting, 'logo');
            $setting->logo = $upload->url;
        }
        $setting->name = $request->name;
        $setting->twitter = $request->twitter;
        $setting->youtube = $request->youtube;
        $setting->telegram_group = $request->telegram_group;
        $setting->telegram_channel = $request->telegram_channel;
        $setting->discord = $request->discord;
        $setting->documentation = $request->documentation;
        $setting->rpc = $request->rpc;
        $setting->ankr = $request->ankr;
        $setting->infura = $request->infura;
        $setting->blast = $request->blast;
        $setting->chat = $request->chat;
        $setting->featured = $request->featured;
        $setting->save();
        return back();
    }
}
