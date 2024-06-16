<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Model\Product;
use App\Model\Product_transfer;
use App\Model\Purchase_return;
use App\Model\Sale_detail;
use App\Model\Sale_return;
use App\Model\Stock;
use App\Model\Supplier;
use App\Model\User;
use App\Product_return;
use App\Services\FileService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private $user_object;

    public function __construct()
    {
        $this->user_object = new User;

        $this->middleware('auth');
    }

    public function index()
    {
        $user_id = Auth::user()->id;

        $user_info = User::findOrFail($user_id);

        return view('profile', compact('user_info'));
    }

    public function photo(Request $request)
    {
        $user_id = Auth::user()->id;
        $validateData = $request->validate(User::$validatePhotoRule);
        $this->user_object->update_user_photo($request, $user_id);

        return redirect()->back();
    }

    public function password(Request $request)
    {
        $user_id = Auth::user()->id;
        $this->user_object->update_user_password($request, $user_id);

        return redirect()->back();
    }

    public function update(ProfileUpdateRequest $request)
    {
            $user = User::query()->where('id', $request->id)->first();
            $requestData = collect($request->validated())->except(['password'])->toArray();
            $image = $request->file('photo');
            if ($image) {
                $requestData = Arr::set(
                    $requestData,
                    'photo',
                    FileService::imageStore($image, 'images/users/', rand(1, 1000), $user->photo)
                );
            }
            $user = User::query()
                ->where('id', $request->id)
                ->update($requestData);
        
        return redirect()->back();
    }

    public function changePassword(): Factory|View|Application
    {
        return view('changepasword');
    }
}
