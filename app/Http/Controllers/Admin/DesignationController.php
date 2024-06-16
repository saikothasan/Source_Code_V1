<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    private function getDepartments()
    {
        return Designation::paginate(10);
    }

    public function index()
    {
        $designations = $this->getDepartments();
        return view('admin.designations.index', compact('designations'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:designations,name|max:255',
        ]);
        $designation = new Designation();
        $designation->fill($validated)->save();

        Session::flash('message', 'Designation Created Successfully!');
        return redirect()->back();
    }

    public function edit(Designation $designation)
    {
        $designations = $this->getDepartments();
        return view('admin.designations.index', compact('designation', 'designations'));
    }

    public function update(Request $request, Designation $designation)
    {
        $validated = $request->validate([
            'name' => 'required|unique:designations,name,' . $designation->id,
        ]);

        $designation->fill($validated)->save();
        Session::flash('message', 'Designation Updated Successfully!');
        return redirect()->route('designations.index');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();
        Session::flash('message', 'Designations Deleted Successfully!');
        return redirect()->back();
    }
}
