<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    use HasFactory;

    public $timestamps = false; //Need to disable it because of Eloquent
    protected $fillable = [
        'parcel_number',
        'size',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
