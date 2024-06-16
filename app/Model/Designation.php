<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Designation extends Model
{
    use HasFactory;

    protected $table = "designations";
    protected $primaryKey = "id";
    protected $fillable = ['name'];
}
