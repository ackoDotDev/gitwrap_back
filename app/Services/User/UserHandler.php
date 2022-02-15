<?php

namespace App\Services\User;

use App\Notifications\NewLogin;
use App\Notifications\RegistrationSuccess;
use App\Repositories\Contracts\GitTokenRepository;
use App\Repositories\Contracts\UserBrowserRepository;
use App\Repositories\Contracts\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UserHandler
{
    /**
     * @var null
     */
    private $userBrowser = null;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var GitTokenRepository
     */
    private GitTokenRepository $gitTokenRepository;

    /**
     * @var UserBrowserRepository
     */
    private UserBrowserRepository $userBrowserRepository;

    /**
     * @param UserRepository $userRepository
     * @param GitTokenRepository $gitTokenRepository
     * @param UserBrowserRepository $userBrowserRepository
     */
    public function __construct(
        UserRepository $userRepository,
        GitTokenRepository $gitTokenRepository,
        UserBrowserRepository $userBrowserRepository
    ) {
        $this->userRepository = $userRepository;
        $this->gitTokenRepository = $gitTokenRepository;
        $this->userBrowserRepository = $userBrowserRepository;
    }

    /**
     * @param $githubUser
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function handleUser($githubUser): mixed
    {
        try {
            DB::beginTransaction();
            $user = $this->userRepository->firstOrCreate(
                ['github_id' => $githubUser->getId()],
                [
                    'uuid' => Str::uuid()->toString(),
                    'name' => $githubUser->getName(),
                    'username' => $githubUser->user['login'],
                    'email' => $githubUser->getEmail(),
                    'avatar' => $githubUser->getAvatar(),
                    'company' => $githubUser->user['company']
                ]
            );

            $this->gitTokenRepository->firstOrCreate(
                ['user_id' => $user->id],
                [
                    'token' => $githubUser->token
                ]
            );

            $this->userBrowser = $this->userBrowserRepository->firstOrCreate(
                [
                    'user_id' => $user->id,
                    'browser_id' => request()?->get('browser_id')
                ]
            );
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception("Error occurred while working with user");
        }

        return $user;
    }

    /**
     * @param $user
     */
    public function handleMail($user): void
    {
        if ($user->wasRecentlyCreated) {
            $user->notify(new RegistrationSuccess());
        } elseif ($this->userBrowser->wasRecentlyCreated) {
            $user->notify(new NewLogin());
        }
    }
}