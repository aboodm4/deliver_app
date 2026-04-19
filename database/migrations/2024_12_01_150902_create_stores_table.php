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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('arname')->unique()->nullable();
            $table->text('location')->nullable();
            $table->text('arlocation')->nullable();
            $table->text('description')->nullable();
            $table->text('ardescription')->nullable();
            $table->string('rate')->nullable();
            $table->text('img')->nullable();
            $table->unsignedBigInteger('storehead_id');
            $table->foreign('storehead_id')->references('id')->on('users')->onDelete('Cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
