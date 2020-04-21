<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->references('id')->on('tests')->onDelete('cascade');
            $table->tinyInteger('order');
            $table->enum('type', ['0', '1']);
            $table->text('question');
            $table->text('question_image')->nullable();
            $table->text('question_audio')->nullable();
            $table->text('correct_answer');
            $table->text('incorrect_answers');
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
        Schema::dropIfExists('questions');
    }
}
