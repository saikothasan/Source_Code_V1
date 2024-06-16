<?php

namespace App\Http\Controllers\Admin\RBAC;

use App\Http\Controllers\Controller;
use App\Model\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    private function getDepartments()
    {
        return Department::paginate(10);
    }

    public function index()
    {
        $departments = $this->getDepartments();
        return view('admin.Department.index', compact('departments'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:departments,name|max:255',
        ]);
        $department = new Department();
        $department->fill($validated)->save();

        Session::flash('message', 'Department Created Successfully!');
        return redirect()->back();
    }

    public function edit(Department $department)
    {
        $departments = $this->getDepartments();
        return view('admin.Department.index', compact('department', 'departments'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|unique:departments,name,' . $department->id,
        ]);

        $department->fill($validated)->save();
        Session::flash('message', 'Department Updated Successfully!');
        return redirect()->route('departments.index');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        Session::flash('message', 'Department Deleted Successfully!');
        return redirect()->back();
    }
}
