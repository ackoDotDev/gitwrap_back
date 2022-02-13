<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GitHubController extends Controller
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return JsonResponse
     */
    public function gitRedirect(): JsonResponse
    {
        return response()->json([
            'url' => Socialite::driver('github')->stateless()->redirect()->getTargetUrl()
        ]);
    }

    public function gitCallback()
    {
        try {

            $githubUser = Socialite::driver('github')->stateless()->user();

            $user = $this->userRepository->firstOrCreate(
                ['github_id' =>  $githubUser->getId()],
                [
                    'uuid' => Str::uuid()->toString(),
                    'name' => $githubUser->getName(),
                    'avatar' => $githubUser->getAvatar()
                ]
            );

            $token = $user->createToken("auth");

            return response()->json([
                'user' => $user,
                'token' => $token->plainTextToken
            ]);

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }}
