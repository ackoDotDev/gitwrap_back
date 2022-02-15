<?php

namespace App\Services\Github;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class RequestHandler
{
    /**
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return Response
     */
    public function getRequest(string $url, array $params = [], array $headers = []): Response
    {
        $sendHeaders = [];
        $user = auth('sanctum')->user();
        if($user){
            $token = $user->gitTokens()->first()->token;
            $sendHeaders['Authorization'] = "token $token";
        }

        $sendHeaders = array_merge($sendHeaders, $headers);
        return Http::withHeaders($sendHeaders)->get($url, $params);
    }
}