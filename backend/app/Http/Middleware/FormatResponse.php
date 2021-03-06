<?php

namespace App\Http\Middleware;

use Closure;

class FormatResponse
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        switch ($response->status()) {
            case 500:
                $data = $response->getOriginalContent();
                break;
            case 204:
                $data = [];
                $response->setStatusCode(200);
                break;
            default:
                $data = $response->getData();
                break;
        }

        return response()->json($data, $response->status());
    }
}
