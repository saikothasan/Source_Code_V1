<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Bank;
use App\Model\User;
use Illuminate\Http\Request;

class NewBankController extends Controller
{
    private $bankObject;

    public function __construct()
    {
        $this->bankObject = new Bank();
    }

    public function index()
    {
        $banks = Bank::orderBy('name', 'asc')->get();
        return view('admin.bank.list', compact('banks'));
    }

    public function create(){
        $users = User::orderBy('name', 'asc')->get();
        return view('admin.bank.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate(Bank::$validateRule);
        $this->bankObject->storeBank($request);
        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate(Bank::$validateRule);
        $this->bankObject->updateBank($request, $request->id);
        return back();
    }

    public function destroy($id)
    {
        $this->bankObject->deleteBank($id);
        return back();
    }
}
