<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\Model;
use App\Models\Murid;

class Guru_Pembimbing extends Authenticatable
{

    protected $table = 'guru_pembimbings';
    protected $fillable=[
        'nama',
        'nip',
        'email',
        'password',
    ];
 
    public function murid(){
        return $this->hasMany(Murid::class);
    }
} 