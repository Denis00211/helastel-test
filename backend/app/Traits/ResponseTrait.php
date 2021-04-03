<?php

namespace App\Traits;

use App;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait ResponseTrait
{
    /**
     * @param string $message
     * @param array|string|bool|int|JsonResource|null $data
     * @param int $errorCode
     * @param string $status
     * @param array $trace
     * @return JsonResponse
     */
    public function response(string $message, $data = null, int $errorCode = 0, string $status = 'success', array $trace = []): JsonResponse
    {
        $response = [
            'error_code'    =>  $errorCode,
            'status'        =>  $status,
            'message'       =>  $message,
            'data'          =>  $data,
        ];

        if (! App::isProduction() && App::environment() !== 'testing') {
            $response['trace'] = $trace;
        }

        return response()->json($response);
    }
}
