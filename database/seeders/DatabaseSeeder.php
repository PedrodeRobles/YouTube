<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Subscriber;
use App\Models\Video;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        // Category::factory(4)->create();
        Video::factory(20)->create();
        Comment::factory(40)->create();
        Subscriber::factory(1)->create();
    }
}
