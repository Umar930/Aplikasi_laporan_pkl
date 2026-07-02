<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observasi extends Model
{
    protected $fillable = ['tujuan_pembelajaran', 'ketercapaian', 'deskripsi'];
}
