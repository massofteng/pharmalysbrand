<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->integer('continent_id');
            $table->integer('parent_id')->default(0);
            $table->integer('country_id');
            $table->integer('language_id');
            $table->integer('category_id');
            $table->string('title', 255);
            $table->string('image');
            $table->text('description');
            $table->text('link');
            $table->integer('display_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->integer('author_id')->default(0);
            $table->dateTimeTz('published_at')->default(now());
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stories');
    }
};
