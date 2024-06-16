<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Model\Customer;
use App\Model\Sale;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CustomerController extends Controller
{
    private $customer_object;

    public function __construct()
    {
        $this->customer_object = new Customer;
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        $sorting = $request->get('sorting');
        $customers = Customer::query()
            ->search($request->get('search'))
            ->filterByBranch($request->get('branch'))
            ->filterByDate($request->get('from-date'), $request->get('to-date'))
            ->withSum('saleDetails as sale_quantity_total', 'quantity')
            ->withSum('sales as sale_total', 'final_total')
            ->withSum('exchangeProducts as exchange_quantity_total', 'quantity')
            ->withSum('saleReturnProducts as return_quantity_total', 'quantity');

        $this->sorting($customers, $sorting);
        $customers = $customers->paginate(100);

        return view('admin.customer.list', compact('customers'));
    }

    private function sorting($data,$sorting)
    {
        if ($sorting == 'high-sell') {
            $data->orderBy('sale_quantity_total', 'desc');
        }
        if ($sorting == 'low-sell') {
            $data->orderBy('sale_quantity_total', 'asc');
        }
        if ($sorting == 'high-exchange') {
            $data->orderBy('exchange_quantity_total', 'desc');
        }
        if ($sorting == 'low-exchange') {
            $data->orderBy('exchange_quantity_total', 'asc');
        }
        if ($sorting == 'high-return') {
            $data->orderBy('return_quantity_total', 'desc');
        }
        if ($sorting == 'low-return') {
            $data->orderBy('return_quantity_total', 'asc');
        }
        if (!isset($sortin)) {
            $data->latest();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customer.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function store(CustomerRequest $request, Customer $customer)
    {
        try {
            $requestData = $request->validated();
            $image = $request->file('photo');

            if ($image) {
                $requestData = Arr::set(
                    $requestData,
                    'photo',
                    FileService::imageStore($image, 'images/customer/', rand(1, 1000))
                );
            }
            $customer->fill($requestData)->save();
            session()->flash('message', 'Customer create Successfully!');
            return redirect()->route('customers.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Something Went Wrong!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $customer
     * @return
     */
    public function show(Request $request,Customer $customer)
    {
        $sorting = $request->get('sorting');
        $sales = Sale::query()
            ->where('customer_id',$customer->id)
            ->search($request->get('search'))
            ->filterByDate($request->get('from-date'), $request->get('to-date'))
            ->with(['branch:id,name'])
            ->withSum('saleProducts as sale_quantity_total', 'quantity')
            ->withSum('exchangeProducts as exchange_quantity_total', 'quantity')
            ->withSum('returnProducts as return_quantity_total', 'quantity');

        $this->sorting($sales, $sorting);

        $total_calculate = $sales->newQuery()->get();
        $total_sell = collect($total_calculate)->sum('sale_quantity_total');
        $total_return = collect($total_calculate)->sum('return_quantity_total');
        $total_exchange = collect($total_calculate)->sum('exchange_quantity_total');
        $total_amount = collect($total_calculate)->sum('final_total');

        $sales = $sales->paginate(100);

        return view('admin.customer.view', [
            'sales' => $sales,
            'customer' => $customer,
            'total_sell' => $total_sell,
            'total_return' => $total_return,
            'total_exchange' => $total_exchange,
            'total_amount' => $total_amount,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * //     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        try {
            $requestData = $request->validated();
            $image = $request->file('photo');

            if ($image) {
                $requestData = Arr::set(
                    $requestData,
                    'photo',
                    FileService::imageStore($image, 'images/customer/', rand(1, 1000))
                );
            }
            $customer->fill($requestData)->update();
            session()->flash('message', 'Customer Updated Successfully!');
            return redirect()->route('customers.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Something Went Wrong!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->customer_object->delete_customer($id);

        return redirect()->back();
    }
}
