<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\BankTransfer;
use App\Model\BranchPaymentMethod;
use App\Model\BranchPaymentMethodHistory;
use App\Model\MoneyTransfer;
use App\Model\PaymentMethod;
use App\Services\FileService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View|Application
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter');
        $paymentMethods = PaymentMethod::query()
            ->when($filter, function ($query) {
                $query->withSum('toDayPayment as total_balance', 'pay_amount');
            })
            ->when(!isset($filter), function ($query) {
                $query->withSum('methodBalance as total_balance', 'total_balance');
            })
            ->whereNotIn('name', ['Bank'])
            ->get();

        return view('admin.payment_method.list', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.payment_method.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $paymentMethod = new PaymentMethod();
        $requestData = $request->all();
        $image = $request->file('photo');

        if ($image) {
            $requestData = Arr::set(
                $requestData,
                'photo',
                FileService::imageStore($image, 'images/paymentMethod/', rand(1, 1000))
            );
        }
        $paymentMethod->fill($requestData)->save();

        if ($paymentMethod) {
            Session::flash('message', 'Payment Method Created Successfully!');
        } else {
            Session::flash('message', 'Payment Method Create Failed!');
        }
        return redirect()->route('payment-method.index');
    }

    /**
     * Display the specified resource.
     *
     * @param PaymentMethod $paymentMethod
     * @return
     */
    public function show(PaymentMethod $paymentMethod)
    {

        $payment_method_data = BranchPaymentMethod::query()
            ->where('payment_method_id', $paymentMethod->id)
            ->where('branch_id', auth()->user()->branch_id)
            ->firstOrFail();

        $paymentHistory = BranchPaymentMethodHistory::query()
            ->where('payment_method_id', $paymentMethod->id)
            ->where('branch_id', auth()->user()->branch_id)
            ->with('sale.customer:id,name,phone')
            ->latest('date');

        $paymentHistory = $paymentHistory->paginate(100);
        return view('admin.payment_method.paymentHistory', [
            'payment_method_data' => $payment_method_data,
            'paymentHistory' => $paymentHistory,
            'paymentMethod' => $paymentMethod,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PaymentMethod $paymentMethod
     * @return Response
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment_method.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PaymentMethod $paymentMethod
     * @return RedirectResponse
     */
    public function update(Request $request, PaymentMethod $paymentMethod): RedirectResponse
    {
        $requestData = $request->all();
        $image = $request->file('photo');

        if ($image) {
            $requestData = Arr::set(
                $requestData,
                'photo',
                FileService::imageStore($image, 'images/paymentMethod/', rand(1, 1000), $paymentMethod->photo)
            );
        }
        $paymentMethod->fill($requestData)->save();

        if ($paymentMethod) {
            Session::flash('message', 'Payment Method Update Successfully!');
        } else {
            Session::flash('message', 'Payment Method Update Failed!');
        }
        return redirect()->route('payment-method.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PaymentMethod $paymentMethod
     * @return RedirectResponse
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        if ($paymentMethod) {
            Session::flash('message', 'Payment Method Delete Successfully!');
        } else {
            Session::flash('message', 'Payment Method Delete Failed!');
        }
        return redirect()->route('payment-method.index');
    }

    public function paymentMethodHistory($id)
    {
        $bankTransfers = MoneyTransfer::query()
            ->where('payment_method_id', $id)
            ->where('current_branch_id', auth()->user()->branch_id)
            ->with('cashDrawer:id,name',
                'branch:id,name',
                'bank:id,name,account_no',
                'paymentMethod:id,name',
                'bankTransfer')
            ->latest()
            ->paginate(100);
        return view('admin.payment_method.transferHistory', compact('bankTransfers'));
    }
}
