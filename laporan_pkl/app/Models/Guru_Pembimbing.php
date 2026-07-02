<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru_Pembimbing extends Model
{
    protected $fillable=[
        'nama',
        'nip',
        'email',
        'password',
    ];
}
