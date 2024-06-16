<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserBranch extends Model
{
    use HasFactory;

    protected $table = "user_branches";
    protected  $primaryKey ="id";
    protected $fillable = ['user_id','branch_id'];

    public $timestamps = false;


    public function branchName()
    {
        return $this->hasOne(Branch::class, 'id','branch_id');
    }

}
