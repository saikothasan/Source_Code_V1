<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Session;


class Employee extends Model
{
    protected $table = 'employees';
    protected $primaryKey='id';
    protected $fillable = [
        'department_id',
        'name',
        'employee_id',
        'join_date',
        'reference',
        'phone',
        'email',
        'address',
        'photo',
        'designation',
        'salary',
    ];


    public static $validateRule = [

        'photo'        => 'mimes:jpeg,jpg,png,gif|max:1999|nullable',
        'name'         => 'required|string|max:255',
        'employee_id'  => 'string|max:255|required',
        'designation'  => 'string|max:255|required',
        'department_id'=> 'numeric|required',
        'email'        => 'email|max:255|nullable',
        'phone'        => 'required|string|max:15',
        'reference'    => 'string|nullable|max:255',
        'address'      => 'string|nullable',
        'join_date'    => 'date|required',
    ];

    public function  scopeFilterByPhone(Builder $query,$phone): Builder
    {
        return $query->where('phone',$phone);
    }

    public function get_all_employee()
    {
        $employees = $this::leftJoin('departments', 'employees.department_id', '=', 'departments.id')
                            ->orderBy('employees.join_date', 'desc')
                            ->select('employees.*', 'departments.name as department')
                            ->get();
        return $employees;

    }

    public function store_employee($request)
    {
        $this->name          = $request->name;
        $this->employee_id   = $request->employee_id;
        $this->designation   = $request->designation;
        $this->department_id = $request->department_id;
        $this->email         = $request->email;
        $this->phone         = $request->phone;
        $this->reference     = $request->reference;
        $this->address       = $request->address;
        $this->salary        = $request->salary;
        $this->join_date     = date('Y-m-d', strtotime($request->join_date));

        $image = $request->file('photo');

        if ($image) {

            $image_name      = rand();
            $ext             = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path     = 'public/images/employee/';
            $image_url       = $upload_path . $image_full_name;
            $success         = $image->move($upload_path, $image_full_name);
            $this->photo     = $image_url;
        }

        $store_employee = $this->save();

        $store_employee ? Session::flash('message', 'Employee Created Successfully!') : Session::flash('message', 'Employee Create Failed!');
    }

    public function update_employee($request, $id)
    {
        $employee = $this::findOrFail($id);
        $employee->name          = $request->name;
        $employee->employee_id   = $request->employee_id;
        $employee->designation   = $request->designation;
        $employee->department_id = $request->department_id;
        $employee->email         = $request->email;
        $employee->phone         = $request->phone;
        $employee->reference     = $request->reference;
        $employee->address       = $request->address;
        $employee->salary        = $request->salary;
        $employee->join_date     = date('Y-m-d', strtotime($request->join_date));

        $image = $request->file('photo');

        if ($image) {

            if (file_exists($employee->photo)) unlink($employee->photo);

            $image_name      = rand();
            $ext             = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path     = 'public/images/employee/';
            $image_url       = $upload_path . $image_full_name;
            $success         = $image->move($upload_path, $image_full_name);
            $employee->photo = $image_url;
        }

        $update_employee = $employee->save();

        $update_employee ? Session::flash('message', 'Employee Updated Successfully!') : Session::flash('message', 'Employee Update Failed!');
    }

    public function delete_employee($id)
    {
        $employee = $this::findOrFail($id);

        if ($employee) {

            if (file_exists($employee->photo)) unlink($employee->photo);
        }

        $delete_employee = $this::where('id', $id)->delete();
        $delete_employee ? Session::flash('message', 'Employee Deleted Successfully!') : Session::flash('message', 'Employee Delete Failed!');
    }
}
