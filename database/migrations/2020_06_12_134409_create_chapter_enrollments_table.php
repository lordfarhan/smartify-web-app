<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapterEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_enrollment_id')->references('id')->on('course_enrollments')->onDelete('cascade');
            $table->foreignId('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
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
        Schema::dropIfExists('chapter_enrollments');
    }
}
