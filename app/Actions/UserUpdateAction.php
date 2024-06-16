<?php

namespace App\Actions;

use App\Http\Requests\UserRequest;
use App\Model\Branch;
use App\Model\User;
use App\Services\FileService;
use Illuminate\Support\Facades\Hash;

class UserUpdateAction
{
    public function handle(UserRequest $request, User $user): User
    {
        $image = $request->file('photo');
        if ($image) {
            $image_name = rand();
            $upload_path = 'images/users/';
            $user->photo = FileService::imageStore($image, $upload_path, $image_name, $user->photo);
        }

        if ($request->branch_id) {
            $branch = Branch::where('id', $request->branch_id)->first();
            $user->is_main_branch = $branch->is_main_branch;
        } else {
            $user->is_main_branch = 0;
        }

        $user->section_id = $request->section;
        $user->designation_id = $request->designation;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->branch_id = $request->branch_id;
        $user->status = User::STATUS['Active'];
//        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole($request->section);
        $user->syncPermissions($request->permission_id);

        return $user;
    }
}
