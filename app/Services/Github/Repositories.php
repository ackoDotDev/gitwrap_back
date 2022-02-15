<?php

namespace App\Services\Github;

use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;

class Repositories extends RequestHandler
{
    /**
     * @param string $username
     * @return Response
     */
    public function getRepositoriesForUser(string $username): Response
    {
        $url = "https://api.github.com/users/$username/repos";

         return $this->getRequest($url);
    }


    /**
     * @param string $fullName
     * @param int $commitsCount
     * @return JsonResponse
     */
    public function getRepositoryForUser(string $fullName, int $commitsCount = 10): JsonResponse
    {
        $url = "https://api.github.com/repos/$fullName";

        $repoData = $this->getRequest($url);

        $branches = $this->getRequest($repoData['url'] . "/branches")->json();
        $commits= $this->getRequest($repoData['url'] . "/commits")->json();

        $responseData = [
            'languages' => $this->getRequest($repoData['languages_url'])->json(),
            'commits' => $commits,
            'branches' => $branches,
            'created_at' => $repoData['created_at'],
            'default_branch' => $repoData['default_branch'],
            'description' => $repoData['description'],
            'full_name' => $repoData['full_name'],
            'name' => $repoData['name'],
            'license' => $repoData['license'],
            'html_url' => $repoData['html_url'],
            'stars' => $repoData['stargazers_count'],
            'subs' => $repoData['subscribers_count'],
        ];
        return response()->json($responseData);
    }
}