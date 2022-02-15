<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvalidateRequest;
use App\Repositories\Contracts\UserBrowserRepository;
use App\Repositories\Contracts\UserTokenRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class AuthController extends Controller
{
    /**
     * @var UserTokenRepository
     */
    private UserTokenRepository $userTokenRepository;

    /**
     * @var UserBrowserRepository
     */
    private UserBrowserRepository $userBrowserRepository;

    /**
     * @param UserTokenRepository $userTokenRepository
     * @param UserBrowserRepository $userBrowserRepository
     */
    public function __construct(
        UserTokenRepository $userTokenRepository,
        UserBrowserRepository $userBrowserRepository
    )
    {
        $this->userTokenRepository = $userTokenRepository;
        $this->userBrowserRepository = $userBrowserRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $status = $request->user()->currentAccessToken()->delete();

        return response()->json(['status' => $status]);
    }

    /**
     * @param InvalidateRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function invalidate(InvalidateRequest $request)
    {
        $this->userTokenRepository->deleteWhere(['name' => $request->get('token')]);
        $this->userBrowserRepository->deleteWhere(['browser_id' => $request->get('token')]);

        return redirect(env('FRONT_APP_URL'));
    }
}
