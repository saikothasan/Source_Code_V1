<?php

namespace App\Http\Controllers\Admin\Supplier;

use App\Http\Controllers\Controller;
use App\Model\Stock;
use App\Model\User;
use App\Http\Requests\SupplierRequest;
use App\Model\Purchase;
use App\Model\Section;
use App\Model\Supplier;
use App\Services\FileService;
use Arr;
use Hash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{

    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $suppliers = Supplier::query()->with(['supplierPurchaseDetail' => function ($query) {
            $query->select(
                'purchase_details.*',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(total) as total_amount')
            )->groupBy('purchase_details.supplier_id');
        }])->with(['supplierPurchaseDuePayment' => function ($query) {
            $query->select(
                'purchase_dues.*',
                DB::raw('SUM(purchase_dues.paid_total) as total_due_paid'),
                DB::raw('SUM(purchase_dues.due_total) as total_due_after_paid')
            )->groupBy('purchase_dues.supplier_id');
        }])->withCount(['stocks' => function ($query) {
            $query->where('stock_status', Stock::STATUS['Stock']);
        }])
            ->get();
        return view('supplier.list', compact('suppliers'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('supplier.add');
    }


    public function store(SupplierRequest $request, Supplier $supplier)
    {
        try {
            $role = Section::where('name', 'Supplier')->first();
            if ($role) {
                DB::beginTransaction();
                $user = new User();
                $user->status = User::STATUS['Active'];
                $user->email = $request->email;
                $user->name = $request->name;
                $user->phone = $request->phone;
                $user->section_id = $role->id;
                $user->password = Hash::make($request->password);
                $user->save();


                $user->assignRole($role->id);
                $supplier->user_id = $user->id;

                $requestData = $request->all();
                $image = $request->file('photo');

                if ($image) {
                    $requestData = Arr::set(
                        $requestData,
                        'photo',
                        FileService::imageStore($image, 'images/supplier/', rand(1, 1000))
                    );
                }
                $supplier->fill($requestData)->save();

                DB::commit();
                session()->flash('message', 'Supplier create Successfully!');
                return redirect()->route('suppliers.index');
            } else {
                session()->flash('warning', 'There is No Supplier Role!');
                return redirect()->route('suppliers.index');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            session()->flash('error', 'Something Went Wrong!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show(Request $request, $id)
    {
        $supplier_info = Supplier::findOrFail($id);
        $user_info = User::findOrFail($supplier_info->user_id);
        $purchases = Purchase::query()
            ->filterByDate($request->get('from_date'), $request->get('to_date'))
            ->where('supplier_id', $id)
            ->withCount('purchaseDetails as total_items')
            ->withCount(['stocks as total_available' => function ($query) use ($id) {
                $query->where('supplier_id', $id);
            }]);
        $purchasesClone = clone $purchases;
        $purchasesClone = $purchasesClone->get();
        $total_items = collect($purchasesClone)->sum('total_items');
        $total_quantity = collect($purchasesClone)->sum('total_quantity');
        $total_buy_price = collect($purchasesClone)->sum('total');
        $purchases = $purchases->paginate(100);
        

        return view('supplier.pages.purchase', [
            'supplier_info' => $supplier_info,
            'purchases' => $purchases,
            'total_items' => $total_items,
            'total_quantity' => $total_quantity,
            'user_info' =>  $user_info,
            'total_buy_price' => $total_buy_price,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        $supplier_info = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier_info'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Supplier $supplier
     * @return RedirectResponse
     */
    public function update(Request $request, Supplier $supplier)
    {
        try {
            $requestData = $request->all();
            $image = $request->file('photo');
            if ($image) {
                $requestData = Arr::set(
                    $requestData,
                    'photo',
                    FileService::imageStore($image, 'images/supplier/', rand(1, 1000), $supplier->photo)
                );
            }
            $supplier->fill($requestData)->save();
            session()->flash('message', 'Supplier Update Successfully!');
            return redirect()->back();
        } catch (\Throwable $e) {
            session()->flash('error', 'Something Went Wrong!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {

        return redirect()->back();
    }
}
