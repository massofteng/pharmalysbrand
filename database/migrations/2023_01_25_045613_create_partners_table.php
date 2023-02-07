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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->integer('continent_id');
            $table->integer('parent_id')->default(0);
            $table->integer('country_id');
            $table->integer('language_id');
            $table->string('title', 255);
            $table->string('image_one');
            $table->string('image_two');
            $table->text('description');
            $table->text('link');
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
        Schema::dropIfExists('partners');
    }
};
