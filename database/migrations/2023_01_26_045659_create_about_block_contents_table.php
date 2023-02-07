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
        Schema::create('about_block_contents', function (Blueprint $table) {
            $table->id();
            $table->integer('block_id');
            $table->longText('content');
            $table->longText('image')->nullable();
            $table->integer('display_order')->default(0);
            $table->integer('author_id');
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
        Schema::dropIfExists('about_block_contents');
    }
};
