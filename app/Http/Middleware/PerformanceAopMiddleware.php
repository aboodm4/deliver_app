<?php

namespace App\Http\Middleware;

use App\Models\PerformanceMetric;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PerformanceAopMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $requestId = (string) Str::uuid();

        $startTime = hrtime(true);
        $startMemory = memory_get_usage(true);

        /*
        |--------------------------------------------------------------------------
        | Database query measurement
        |--------------------------------------------------------------------------
        | نستخدم Query Log لكل طلب بدلاً من تسجيل Listener جديد في كل مرة.
        */
        DB::flushQueryLog();
        DB::enableQueryLog();

        try {
            $response = $next($request);
        } catch (Throwable $exception) {
            DB::disableQueryLog();

            Log::error('AOP_REQUEST_FAILED', [
                'request_id' => $requestId,
                'method' => $request->method(),
                'uri' => $request->path(),
                'instance' => config('app.instance'),
                'error' => $exception->getMessage(),
            ]);

            throw $exception;
        }

        $queries = DB::getQueryLog();
        DB::disableQueryLog();

        $durationNanoseconds = hrtime(true) - $startTime;
        $durationMilliseconds = $durationNanoseconds / 1_000_000;

        $memoryUsedBytes = max(
            memory_get_usage(true) - $startMemory,
            0
        );

        $databaseTimeMilliseconds = collect($queries)->sum(
            static fn (array $query): float => (float) ($query['time'] ?? 0)
        );

        $apiVersion = str_starts_with($request->path(), 'api/v2/')
            ? 'v2'
            : 'old';

        $metric = [
            'request_id' => $requestId,
            'api_version' => $apiVersion,
            'method' => $request->method(),
            'uri' => $request->path(),
            'status_code' => $response->getStatusCode(),
            'duration_ms' => round($durationMilliseconds, 3),
            'database_time_ms' => round($databaseTimeMilliseconds, 3),
            'database_queries_count' => count($queries),
            'memory_used_bytes' => $memoryUsedBytes,
            'instance_name' => config('app.instance'),
            'client_ip' => $request->ip(),
            'user_id' => $request->user()?->id,
            'measured_at' => now()->timezone('+03:00'),
        ];

        $request->attributes->set('performance_metric', $metric);

        date_default_timezone_set('Asia/Riyadh');
        Log::channel('daily')->info('AOP_PERFORMANCE', $metric);
        date_default_timezone_set(config('app.timezone'));

        $response->headers->set('X-Request-Id', $requestId);
        $response->headers->set(
            'X-AOP-Duration-ms',
            (string) round($durationMilliseconds, 3)
        );
        $response->headers->set(
            'X-AOP-DB-Queries',
            (string) count($queries)
        );
        $response->headers->set(
            'X-AOP-DB-Time-ms',
            (string) round($databaseTimeMilliseconds, 3)
        );
        $response->headers->set(
            'X-App-Instance',
            (string) config('app.instance')
        );

        return $response;
    }

    /*
    |--------------------------------------------------------------------------
    | Terminable Middleware
    |--------------------------------------------------------------------------
    | Laravel يستدعي terminate بعد معالجة الاستجابة.
    | نحفظ القياس هنا حتى لا يدخل INSERT الخاص بالقياس في عدد استعلامات API.
    */
    public function terminate(Request $request, Response $response): void
    {
        if (!config('performance.enabled')) {
            return;
        }

        $metric = $request->attributes->get('performance_metric');

        if ($metric === null) {
            return;
        }

        try {
            PerformanceMetric::create($metric);
        } catch (Throwable $exception) {
            Log::error('PERFORMANCE_METRIC_SAVE_FAILED', [
                'request_id' => $metric['request_id'] ?? null,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
