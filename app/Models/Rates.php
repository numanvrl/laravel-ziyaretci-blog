<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rates extends Model
{
    use HasFactory;


    protected $fillable = [
        'rate',
        'user_id',
        'blog_id',
        'rate_status',
    ];
}
