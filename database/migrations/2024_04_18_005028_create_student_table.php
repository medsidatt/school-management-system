<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('rim')->unique();
            $table->string('first_name');
            $table->string('last_name');

            $table->bigInteger('parent')->unsigned();
            $table->foreign('parent')->references('id')->on('parents');

            $table->bigInteger('class')->unsigned();
            $table->foreign('class')->references('id')->on('classes');


            $table->char('sex');
            $table->date('date_of_birth');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
