<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactUs extends Model
{
    use HasFactory;
    protected $table = 'contact_us';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
    ];

    public function scopeSearch($query, $request)
    {
        return $query->where('name', 'LIKE', '%'.$request->search.'%')
                     ->orWhere('email', 'LIKE', '%'.$request->search.'%')
                     ->orWhere('phone', 'LIKE', '%'.$request->search.'%')
                     ->orWhere('message', 'LIKE', '%'.$request->search.'%');
    }
}
