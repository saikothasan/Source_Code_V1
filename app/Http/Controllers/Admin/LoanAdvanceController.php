<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Department;
use App\Model\Loan_advance;
use Illuminate\Http\Request;

class LoanAdvanceController extends Controller
{
    private $loan_advance_object;

    public function __construct()
    {
        $this->loan_advance_object = new Loan_advance;
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $loan_advances = $this->loan_advance_object->get_all_loan_or_advanced();
        return view('admin.loanadvance.list', compact('loan_advances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $departments = Department::select('id', 'name')->get();
        return view('admin.loanadvance.add', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Loan_advance::$validateRule);

        $this->loan_advance_object->store_loan_advance($request);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->loan_advance_object->delete_loan_advance($id);

        return redirect()->back();
    }
}
