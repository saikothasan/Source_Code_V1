<?php

namespace App\Http\Controllers\Admin\Bank;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankRequest;
use App\Model\User;
use App\Model\Bank;
use App\Model\Bank_transaction;
use Arr;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $banks = Bank::with('user', 'user.branch')

            ->when(!auth()->user()->is_main_branch, function ($q) {
                $q->where('branch_id', auth()->user()->branch_id);
            })
            ->when(isSupplier(), function ($q) {
                $q->where('user_id', auth()->user()->id);
            })
            ->latest('is_main_bank')
            ->get();
        // return $banks;
        return view('admin.bank.list', compact('banks'));
    }

    public function create()
    {
        $users = User::with('branch')
            ->when(!auth()->user()->is_main_branch, function ($q) {
                $q->where('branch_id', auth()->user()->branch_id)
                    ->where('section_id', '!=', 1);
            })->where('section_id', '!=', 1)
            ->latest('name')
            ->get();
        return view('admin.bank.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BankRequest $request
     * @param Bank $bank
     * @return RedirectResponse
     */
    public function store(BankRequest $request, Bank $bank)
    {

        try {
            $data = $request->all();
            $branch_id = User::where('id', $request->user_id)->first();
            $branch_id = $branch_id->branch_id ?? null;
            if ($branch_id) {
                $data = Arr::set(
                    $data,
                    'branch_id',
                    $branch_id
                );
            }
            $bank->fill($data)->save();
            session()->flash('message', 'Bank create Successfully!');
            return redirect()->route('banks.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Something Went Wrong!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $bank = Bank_transaction::findOrFail($id);
        return view('admin.bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        return redirect()->back();
    }
}
