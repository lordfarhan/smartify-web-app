<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('quotes', function (Blueprint $table) {
      $table->id();
      $table->foreignId('quote_category_id')->references('id')->on('quote_categories')->onDelete('cascade');
      $table->text('quote');
      $table->string('author', 60);
      $table->text('image');
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
    Schema::dropIfExists('quotes');
  }
}
