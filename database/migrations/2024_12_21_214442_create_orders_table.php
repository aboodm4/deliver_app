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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['storeconfirm', 'transconfirm', 'userconfirm', 'shipped'])->default('storeconfirm'); // Cart status
            $table->enum('payment', ['cash', 'bank', 'syriatelcash', 'mtncash'])->default('cash'); // Cart status
            $table->string('total');
            $table->string('place');
            $table->string('mainphone');
            $table->string('street')->nullable();
            $table->string('buildingfloor')->nullable();
            $table->string('phone')->nullable();
            $table->text('description')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('delivery_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
