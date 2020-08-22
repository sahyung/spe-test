<?php

namespace App\Http\Middleware;

use App\Models\Request;
use Illuminate\Support\Facades\Log;

class LogAfterRequest
{
    public function handle($request, \Closure $next)
    {
        return $next($request);
    }
    public function terminate($request, $response)
    {
        $url = $request->fullUrl();
        $ip = $request->ip();
        $r = new Request();
        $r->ip = $ip;
        $r->url = $url;
        $r->method = $request->method();
        $r->request = json_encode([
            'headers' => $request->header(),
            'body' => $request->all(),
        ]);
        $r->response = json_encode([
            $response->status() => $response->getData(),
        ]);
        $r->save();
    }
}
