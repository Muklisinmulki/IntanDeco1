<?php

// app/Models/SeoKeyword.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoKeyword extends Model
{
    use HasFactory;

    protected $fillable = [
        'keyword',
        'page_url',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'content',
        'priority'
    ];
}