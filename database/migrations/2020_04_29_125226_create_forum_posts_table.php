<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->foreignId('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->string('slug');
            $table->string('title');
            $table->text('content');
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
        Schema::dropIfExists('forum_posts');
    }
}
