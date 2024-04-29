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
        Schema::create('class_subjects', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('subject')->unsigned();
            $table->foreign('subject')->references('id')->on('subjects');

            $table->bigInteger('class')->unsigned();
            $table->foreign('class')->references('id')->on('classes');


            $table->string('coef');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
