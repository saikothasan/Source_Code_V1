<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Setting;
use App\Services\FileService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class SettingsController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.setting.index', ['settings' => Setting::getSettingsArray()]);
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
            $upload_path = 'images/settings/';
            $site_logo = FileService::imageStore($image, $upload_path, $image_name, Setting::get('site_logo'));
            \Arr::set($data,'site_logo',$site_logo);
        }
        $print_logo = $request->file('print_logo');
        if ($print_logo) {
            $image_name = rand();
            $upload_path = 'images/settings/';
            $print_logo = FileService::imageStore($print_logo, $upload_path, $image_name, Setting::get('print_logo'));
            \Arr::set($data,'print_logo',$print_logo);
        }
        Setting::updateSettings($data);
        session()->flash('message', 'Setting Updated Successfully!');
        return redirect()->back();
    }
}
