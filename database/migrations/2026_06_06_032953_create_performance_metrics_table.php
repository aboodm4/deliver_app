<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_metrics', function (Blueprint $table) {
            $table->id();

            $table->uuid('request_id')->index();

            $table->string('api_version', 30)->nullable()->index();
            $table->string('method', 10);
            $table->string('uri', 255)->index();

            $table->unsignedSmallInteger('status_code')->index();

            $table->decimal('duration_ms', 12, 3);
            $table->decimal('database_time_ms', 12, 3)->default(0);
            $table->unsignedInteger('database_queries_count')->default(0);

            $table->bigInteger('memory_used_bytes')->default(0);

            $table->string('instance_name', 100)->nullable()->index();
            $table->string('client_ip', 45)->nullable();

            $table->unsignedBigInteger('user_id')->nullable()->index();

            $table->timestamp('measured_at')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_metrics');
    }
};
