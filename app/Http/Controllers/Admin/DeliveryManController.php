<?php

namespace App\Http\Controllers\Admin;

use App\Model\DeliveryMan;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\FileService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\DeliveryManRequest;

class DeliveryManController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $deliver_mans = DeliveryMan::query()
            ->search($request->get('search'))
            ->latest('name')
            ->paginate(100);
        return view('admin.deliveryman.list', ['delivery_mans' => $deliver_mans]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.deliveryman.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DeliveryManRequest $request
     * @return RedirectResponse
     */
    public function store(DeliveryManRequest $request)
    {
        try {
            $deliveryMan = new DeliveryMan();
            $requestData = $request->all();
            $image = $request->file('photo');
            if ($image) {
                $requestData = Arr::set(
                    $requestData,
                    'photo',
                    FileService::imageStore($image, 'images/deliveryman/', rand(1, 1000))
                );
            }
            $deliveryMan->fill($requestData)->save();
            Session::flash('message', 'Delivery Man Created Successfully!');
            return redirect()->route('delivery-man.index');
        } catch (\Exception $e) {

        }
    }


    public function show(DeliveryMan $deliveryMan)
    {
        //
    }


    public function edit(DeliveryMan $deliveryMan)
    {
        return view('admin.deliveryman.edit', ['delivery_man' => $deliveryMan]);
    }


    public function update(DeliveryManRequest $request, DeliveryMan $deliveryMan)
    {
        $requestData = $request->all();
        $image = $request->file('photo');
        if ($image) {
            $requestData = Arr::set(
                $requestData,
                'photo',
                FileService::imageStore($image, 'images/deliveryman/', rand(1, 1000), $deliveryMan->photo)
            );
        }
        $deliveryMan->fill($requestData)->save();

        Session::flash('message', 'Delivery Man Update Successfully!');
        return redirect()->route('delivery-man.index');
    }


    public function destroy(DeliveryMan $deliveryMan)
    {

        return redirect()->route('delivery-man.index');
    }
}
