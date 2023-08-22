<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_title',
        'blog_content',
        'blog_slug',
        'blog_status',
        'blog_file',
        'user_id',
    ];

    protected $hidden = [
        'user_id',
    ];
}
