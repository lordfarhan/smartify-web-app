<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendshipsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('friendships', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreignId('friend_id')->nullable()->references('id')->on('users')->onDelete('set null');
      $table->tinyInteger('status')->default(0);
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
    Schema::dropIfExists('friendships');
  }
}
