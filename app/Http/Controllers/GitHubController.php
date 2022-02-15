<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\RepositoriesRequest;
use App\Http\Requests\RepositoryRequest;
use App\Services\Github\Repositories;
use App\Services\Github\Users;
use App\Services\User\UserHandler;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class GitHubController extends Controller
{
    /**
     * @var Repositories
     */
    private Repositories $repositories;

    /**
     * @var Users
     */
    private Users $users;

    /**
     * @var UserHandler
     */
    private UserHandler $userHandler;

    /**
     * @param UserHandler $userHandler
     * @param Repositories $repositories
     * @param Users $users
     */
    public function __construct(
        UserHandler $userHandler,
        Repositories $repositories,
        Users $users,
    ) {
        $this->repositories = $repositories;
        $this->users = $users;
        $this->userHandler = $userHandler;
    }

    /**
     * @return JsonResponse
     */
    public function gitRedirect(): JsonResponse
    {
        return response()->json(
            [
                'url' => Socialite::driver('github')->stateless()->redirect()->getTargetUrl()
            ]
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function gitCallback(Request $request): JsonResponse
    {
        $githubUser = Socialite::driver('github')->stateless()->user();

        $user = $this->userHandler->handleUser($githubUser);

        $token = $user->createToken($request->get('browser_id'));

        $this->userHandler->handleMail($user);

        return response()->json(
            [
                'user' => $user,
                'token' => $token->plainTextToken
            ]
        );
    }

    /**
     * @param ProfileRequest $request
     * @return Response
     */
    public function profile(ProfileRequest $request): Response
    {
        return $this->users->getUserData($request->get("name"));
    }

    /**
     * @param RepositoriesRequest $request
     * @return Response
     */
    public function repositories(RepositoriesRequest $request): Response
    {
        return $this->repositories->getRepositoriesForUser($request->get("name"));
    }

    /**
     * @param RepositoryRequest $request
     * @return JsonResponse
     */
    public function repository(RepositoryRequest $request): JsonResponse
    {
        return $this->repositories->getRepositoryForUser($request->get("name"));
    }

}
