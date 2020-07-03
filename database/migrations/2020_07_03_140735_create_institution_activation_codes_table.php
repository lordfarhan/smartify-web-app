<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutionActivationCodesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('institution_activation_codes', function (Blueprint $table) {
      $table->id();
      $table->foreignId('institution_id')->references('id')->on('institutions')->onDelete('cascade');
      $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('set null');
      $table->string('code', 60);
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
    Schema::dropIfExists('institution_activation_codes');
  }
}
