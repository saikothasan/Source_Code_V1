<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Model\Branch;
use App\Model\CashDrawer;
use App\Model\Section;
use App\Model\Stock;
use App\Model\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {

        $branches = Branch::withCount(['stocks as available' => function ($query) {
            $query->where('stock_status', Stock::STATUS['Stock'])
                ->whereNull('sale_id')
                ->whereNull('sale_detail_id')
                ->whereNull('transfer_id');
        }])
            ->withSum(['costs as today_expenses' => function ($query) {
                $query->whereDate('created_at', today());
            }], 'amount')
            ->withSum(['sales as today_sales' => function ($query) {
                $query->whereDate('date', today());
            }], 'final_total')
            ->get();
        //        return $branches;
        return view('admin.branch.list', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $mainBranchCount = Branch::query()->where('is_main_branch', 1)->count();
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('admin.branch.add', compact('mainBranchCount', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BranchRequest $request
     * @return RedirectResponse
     */
    public function store(BranchRequest $request, Branch $branch)
    {
        
        try {
            DB::beginTransaction();
            $role = Section::where('name', 'Admin')->first();
            if ($role) {
                $user = new User();
                $user->status = User::STATUS['Active'];
                $user->name = $request->name;
                $user->username = $request->branch_id;
                $user->email = $request->email;
                $user->section_id = $role->id;
                $user->password = Hash::make($request->password);
                $user->save();
                $branch->user_id = $user->id;
                $branch->date = date('Y-m-d');
                $branch->fill($request->all())->save();
                $user->branch_id = $branch->id;
                $user->save();
                $user->assignRole($role->id);
                $user->syncPermissions($request->permission_id);
                session()->flash('message', 'Branch create Successfully!');
                DB::commit();
                return redirect()->route('branch.index');
            }
        } catch (\Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            session()->flash('error', 'Something Went Wrong!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Branch $branch
     * @return Application|Factory|View
     */
    public function show(Branch $branch)
    {
        return view('admin.branch.view');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Branch $branch
     * @return Application|Factory|View
     */
    public function edit(Branch $branch)
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('admin.branch.edit', compact('branch', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BranchRequest $request
     * @param Branch $branch
     * @return string
     */
    public function update(BranchRequest $request, Branch $branch): string
    {
        // return $request->all();
        try {
            $branch->fill($request->all())->save();
            session()->flash('message', 'Branch update Successfully!');
            return redirect()->route('branch.index');
        } catch (\Throwable $e) {
            return $e->getMessage();
            session()->flash('error', 'Something Went Wrong!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Branch $branch
     * @return RedirectResponse
     */
    public function destroy(Branch $branch): RedirectResponse
    {
        try {
            $branch->delete();
            session()->flash('message', 'Branch delete Successfully!');
            return redirect()->back();
        } catch (\Throwable $e) {
            session()->flash('error', 'Something Went Wrong!');
            return redirect()->back();
        }
    }
}
