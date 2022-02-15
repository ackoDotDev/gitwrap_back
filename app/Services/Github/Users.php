<?php

namespace App\Services\Github;

use Illuminate\Http\Client\Response;

class Users extends RequestHandler
{
    /**
     * @param string $username
     * @return Response
     */
    public function getUserData(string $username): Response
    {
        $url = "https://api.github.com/users/$username";

        return $this->getRequest($url);
    }
}