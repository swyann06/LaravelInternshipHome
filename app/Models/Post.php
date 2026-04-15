<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\PostImage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }
}