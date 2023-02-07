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
        Schema::create('page_blocks', function (Blueprint $table) {
            $table->id();
            $table->integer('country_id');
            $table->integer('language_id');
            $table->string('page_id', 100);
            $table->string('title', 255);
            $table->string('block_type', 150);
            $table->integer('display_order')->default(0);
            $table->string('lang', 50);
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
        Schema::dropIfExists('page_blocks');
    }
};
