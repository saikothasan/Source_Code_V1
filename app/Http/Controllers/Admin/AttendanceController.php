<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Attendance;
use App\Model\Department;
use App\Model\Employee;
use App\Model\Loan_advance;
use App\Model\Month;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    private $attendance_object;

    public function __construct()
    {
        $this->attendance_object = new Attendance;
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        //$employees = Employee::select('id', 'name', 'employee_id')->get();
        $departments = Department::select('id', 'name')->get();
        $months    = Month::select('id', 'name')->get();

        $month    = $request->month;
        $employee = $request->employee_id;

        if ($month != '' || $employee != '') {

            $request->validate(Attendance::$validateSearchRule);
            $attendances = $this->attendance_object->get_employee_attendance_by_month($month, $employee);

            return view('admin.attendance.list', compact('departments', 'months', 'attendances'));
        } else {

            return view('admin.attendance.list', compact('departments', 'months'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $employees = Employee::select('id', 'name', 'employee_id')->get();
        $months    = Month::select('id', 'name')->get();
        $attendances = $this->attendance_object->get_todays_attendances();
        return view('admin.attendance.add', compact('employees', 'months', 'attendances'));
    }

    public function store(Request $request)
    {
        $today      = date('Y-m-d');
        $yester_day = '2021-09-30';

        if ($today > $yester_day) {

            return redirect()->back();
        }

        $request->validate(Attendance::$validateRule);

        $this->attendance_object->store_attendance($request);

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $request->validate(Attendance::$validateUpdateRule);

        $this->attendance_object->update_attendance($request);

        return redirect()->back();
    }

    public function employee()
    {
        //$employees = Employee::select('id', 'name', 'employee_id')->get();
        $departments = Department::select('id', 'name')->get();
        $months    = Month::select('id', 'name')->get();
        return view('admin.attendance.search', compact('departments', 'months'));
    }

    public function employee_attend(Request $request)
    {

        $loan_advance = new Loan_advance;

        $month    = $request->month;
        $employee = $request->employee_id;

        $request->validate(Attendance::$validateSearchRule);

        $employee_info = Employee::findOrFail($employee);

        $attendances = $this->attendance_object->get_employee_attendance_by_month($month, $employee);

        $loan_advances = $loan_advance->get_loan_or_advance_by_employee_and_month($month, $employee);

        return view('admin.attendance.attendances', compact('attendances', 'employee_info', 'loan_advances', 'month'));
    }
}
