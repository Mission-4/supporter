<?php

namespace Mission4\Supporter;

use Zttp\Zttp;
use Mission4\Supporter\Jobs\SupporterAnomaly;

class Supporter
{
    public static function handleException($exception, $request, $user)
    {
        $baseUrl = env('SUPPORTER_BASE_URL', 'https://supporter.mission-4.com');
        
        $data = [
            'api_key' => env('SUPPORTER_KEY'),
            'exception' => $exception,
            'request' => $request,
            'user' => $user
        ];

        $response = Zttp::withHeaders([
            "X-Supporter-Signature" => hash_hmac('sha256', json_encode($data), env('SUPPORTER_SECRET', null))
        ])->post($baseUrl . '/api/track', $data);
    }

    public static function send($exception, $request)
    {
        dispatch(new SupporterAnomaly($exception, $request));
    }
}
