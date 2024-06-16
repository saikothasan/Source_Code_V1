<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory ,CreatedUpdatedBy;

    protected $primaryKey = 'id';
    protected $table = 'news';
    protected $fillable = [
    'title',
    'date',
    'photo',
    'description',
    'status',
    ];

    public function scopeActive($query){
        return $query->where('status', 1);
    }
    
}
