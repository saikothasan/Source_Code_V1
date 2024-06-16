<?php

namespace App\Http\Controllers\Admin;

use App\Actions\UserStoreAction;
use App\Actions\UserUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Model\Branch;
use App\Model\User;
use App\Model\UserBranch;
use App\Services\FileService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    private $user_object;

    public function __construct()
    {
        $this->user_object = new User;
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->when(!auth()->user()->is_main_branch, function ($q) {
                $q->where('branch_id', auth()->user()->branch_id);
            })
            ->filterBySection($request->get('section'))
            ->with(['section:id,name', 'designation:id,name', 'branch:id,name'])
            ->paginate(100);
        return view('admin.user.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('admin.user.add', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request, UserStoreAction $action)
    {
        try {
            $action->handle($request);
            Session::flash('message', 'New User Created Successfully!');
        } catch (\Throwable $exception) {
            Session::flash('error', 'User Create Failed!');
        }
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        $permissions = Permission::orderBy('name', 'asc')->get();

        $userPermission = DB::table('model_has_permissions')
            ->where('model_id', $user->id)
            ->pluck('permission_id')
            ->toArray();

        return view('admin.user.edit', compact('user', 'permissions', 'userPermission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user, UserUpdateAction $action)
    {
        try {
            $action->handle($request, $user);
            Session::flash('message', 'User Update Successfully!');
        } catch (\Throwable $exception) {
            return $exception->getMessage();
            Session::flash('error', 'User Update Failed!');
        }
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
//        $this->user_object->delete_user($id);

        return redirect()->back();
    }
}
