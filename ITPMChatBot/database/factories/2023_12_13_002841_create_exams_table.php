<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('exam_name');
            $table->unsignedBigInteger('subject_id');
            $table->string('time');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->integer('attempt')->default(0);
            $table->float('marks')->default(0);
            $table->float('carry_marks')->default(0);
            $table->string('enterance_id');
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
        Schema::dropIfExists('exams');
    }
};
