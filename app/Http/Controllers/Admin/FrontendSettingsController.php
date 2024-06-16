<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\FrontendSetting;
use App\Model\Setting;
use App\Services\FileService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class FrontendSettingsController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('ecommerce.setting.index', ['frontend_settings' => FrontendSetting::getFrontendSettingsArray()]);
    }
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $request->except('_token');

        $image = $request->file('site_logo');
        if ($image) {
            $image_name = rand();
            $upload_path = 'images/frontend_settings/';
            $site_logo = FileService::imageStore($image, $upload_path, $image_name, FrontendSetting::get('site_logo'));
            \Arr::set($data,'site_logo',$site_logo);
        }
        FrontendSetting::updateSettings($data);
        session()->flash('message', 'Setting Updated Successfully!');
        return redirect()->back();
    }
}
