<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    //these are fillable input
    protected $fillable = [
        'user_id',
        'bio_data',
        'fav',
        'status',
    ];

    //state this is belong to user table
    public function user(){
        return $this->belongsTo(User::class);
    }
}
