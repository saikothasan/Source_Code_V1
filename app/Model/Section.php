<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Section extends Model
{
    protected $table = "roles";
    protected $primaryKey = "id";
    protected $fillable = ['guard_name', 'name'];

}
