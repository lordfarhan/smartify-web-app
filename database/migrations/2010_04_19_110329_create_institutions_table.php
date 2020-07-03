<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('institutions', function (Blueprint $table) {
      $table->id();
      $table->string('name', 60);
      $table->text('image')->nullable();
      $table->text('description')->nullable();
      $table->enum('join_by', ['phone', 'code']);
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
    Schema::dropIfExists('institutions');
  }
}
