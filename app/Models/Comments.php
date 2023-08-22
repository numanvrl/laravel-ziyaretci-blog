<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = [
        'comment_content',
        'comment_status',
        'user_id',
        'blog_id',
        'guest_name',
    ];

    protected $hidden = [
        'user_id',
        'blog_id',
    ];
}
