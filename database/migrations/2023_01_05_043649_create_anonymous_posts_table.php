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
        Schema::create('anonymous_posts', function (Blueprint $table) {
            $table->id();
            $table->integer('country_id');
            $table->integer('language_id');
            $table->integer('post_position')->default(1);
            $table->string('title', 255);
            $table->text('description');
            $table->text('link');
            $table->integer('author_id');
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anonymous_posts');
    }
};
