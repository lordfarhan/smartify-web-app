<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubChapterEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_chapter_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_enrollment_id')->references('id')->on('chapter_enrollments')->onDelete('cascade');
            $table->foreignId('sub_chapter_id')->references('id')->on('sub_chapters')->onDelete('cascade');
            $table->enum('status', ['0', '1'])->default('0');
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
        Schema::dropIfExists('sub_chapter_enrollments');
    }
}
