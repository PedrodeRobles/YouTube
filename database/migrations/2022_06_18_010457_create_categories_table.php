<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;

return new class extends Migration
{

    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('category');
            $table->timestamps();
        });

        Category::factory()->create([
            'category' => 'Gaming',
        ]);
        Category::factory()->create([
            'category' => 'Music',
        ]);
        Category::factory()->create([
            'category' => 'News',
        ]);
        Category::factory()->create([
            'category' => 'Sports',
        ]);
        Category::factory()->create([
            'category' => 'Learning',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
