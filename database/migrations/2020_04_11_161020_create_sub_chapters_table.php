<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
            $table->string('sub_chapter', 6);
            $table->string('title', 60);
            $table->string('attachment_title', 60)->nullable();
            $table->text('attachment')->nullable();
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
        Schema::dropIfExists('sub_chapters');
    }
}
