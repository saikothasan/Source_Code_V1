<?php

namespace App\Model;

use App\Services\FileService;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Session;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use Notifiable, HasRoles, CreatedUpdatedBy;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'phone', 'photo',
        'address', 'date', 'date_of_birth', 'id_card_number', 'note',
        'branch_id', 'is_main_branch', 'section_id', 'designation_id',
        'status', 'otp', 'previous_company', 'created_by', 'updated_by'
    ];

    const STATUS = [
        'Active' => 1,
        'Inactive' => 0,
        'Reject' => 2,
        'MainBranch' => 1,
        'Branch' => 0,
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFilterBySection(Builder $query, $section): Builder
    {
        return $query->when($section, function ($query) use ($section) {
            $query->where('section_id', $section);
        });
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function section(): HasOne
    {
        return $this->hasOne(Section::class, 'id', 'section_id');
    }

    public function designation(): HasOne
    {
        return $this->hasOne(Designation::class, 'id', 'designation_id');
    }

    public function branch(): HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id')->withDefault();
    }

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class, 'user_id', 'id')->withDefault();
    }


    public function update_user($request, $id)
    {

        $user = $this::findOrFail($id);

        $image = $request->file('photo');

        if ($image) {
            $image_name = $user->id . '_' . rand();
            $upload_path = 'images/users/';
            $user->photo = FileService::imageStore($image, $upload_path, $image_name, $user->photo);
        }


        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;

        $user_update = $user->save();
        $user->syncPermissions($request->permission_id);

        if ($user_update) {

            Session::flash('message', 'User Updated Successfully!');

        } else {

            Session::flash('message', 'User Update Failed!');
        }

    }

    public function delete_user($id)
    {
        $user_info = $this::findOrFail($id);

        if ($user_info) {

            if (file_exists($user_info->photo)) unlink($user_info->photo);

            $user_info->removeRole($user_info->roles->first());
        }

        $user_delete = $this::where('id', $id)->delete();

        if ($user_delete) {

            Session::flash('message', 'User Deleted Successfully!');

        } else {

            Session::flash('message', 'User Delete Failed!');
        }

    }


    public function update_user_photo($request, $id)
    {
        $user = $this::findOrFail($id);

        $image = $request->file('photo');

        if ($image) {

            if (file_exists($user->photo)) unlink($user->photo);

            $image_name = $id . '_' . time();
            $upload_path = 'images/users/';
            $user->photo = FileService::imageStore($image, $upload_path, $image_name, $user->photo);
        }

        $user_update = $user->save();

        if ($user_update) {
            Session::flash('message', 'User Photo Updated Successfully!');
        } else {
            Session::flash('message', 'User Photo Update Failed!');
        }
    }

    public function update_user_password($request, $id)
    {
        $user = User::findOrFail($id);

        if (Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();
            Session::flash('message', 'User Password Updated Successfully!');
        } else {
            Session::flash('message', 'User Password Updated Successfully!');
        }
    }


    public function update_user_info($request, $id)
    {
        try {

            $user = $this::findOrFail($id);

            $user->name = $request->name;
            $user->address = $request->address;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->phone = $request->phone;

            $user_update = $user->save();

            if ($user_update) {

                Session::flash('message', 'User Info Updated Successfully!');

            } else {

                Session::flash('message', 'User Info Update Failed!');
            }

        } catch (QueryException $exception) {

            Session::flash('message', 'Email Already Taken!');
        }

    }

}
