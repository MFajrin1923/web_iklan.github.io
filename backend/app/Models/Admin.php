<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'email', 'no_telp', 'jumlah_topUp', 'status_iklan', 'feedback'];
}
