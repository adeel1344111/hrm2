<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ZkApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $expected = (string) env('ZK_INGEST_API_KEY', '');
        $header = $request->header('Authorization', '');
        $token = str_starts_with($header, 'Bearer ')
            ? trim(substr($header, 7))
            : (string) $request->query('key', '');

        if ($expected === '' || !hash_equals($expected, $token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
