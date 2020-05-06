<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->foreignId('forum_post_id')->references('id')->on('forum_posts')->onDelete('cascade');
            $table->foreignId('forum_reply_id')->nullable()->references('id')->on('forum_replies')->onDelete('cascade');
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
        Schema::dropIfExists('forum_replies');
    }
}
