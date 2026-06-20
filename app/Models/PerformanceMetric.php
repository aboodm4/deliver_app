<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceMetric extends Model
{
    protected $fillable = [
        'request_id',
        'api_version',
        'method',
        'uri',
        'status_code',
        'duration_ms',
        'database_time_ms',
        'database_queries_count',
        'memory_used_bytes',
        'instance_name',
        'client_ip',
        'user_id',
        'measured_at',
    ];

    protected $casts = [
        'duration_ms' => 'float',
        'database_time_ms' => 'float',
        'database_queries_count' => 'integer',
        'memory_used_bytes' => 'integer',
        'status_code' => 'integer',
        'measured_at' => 'datetime',
    ];
}
