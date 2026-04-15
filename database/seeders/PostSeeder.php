<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\PostImage;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::factory()
            ->count(30)
            ->create()
            ->each(function ($post) {
                PostImage::factory()->create([
                    'post_id' => $post->id,
                ]);
            });
    }
}