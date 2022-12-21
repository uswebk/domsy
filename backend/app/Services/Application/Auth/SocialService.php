<?php

declare(strict_types=1);

namespace App\Services\Application\Auth;

use App\Constants\CompanyConstant;
use App\Constants\RoleConstant;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use function now;

final class SocialService
{
    private $userRepository;

    private $userLatestCodeRepository;

    private $socialAccountRepository;

    private $socialAccountQueryService;

    /**
     * @param \App\Repositories\User\UserRepositoryInterface $userRepository
     * @param \App\Repositories\User\UserLatestCodeRepositoryInterface $userLatestCodeRepository
     * @param \App\Repositories\SocialAccount\SocialAccountRepositoryInterface $socialAccountRepository
     * @param \App\Queries\SocialAccount\EloquentSocialAccountQueryServiceInterface $socialAccountQueryService
     */
    public function __construct(
        \App\Repositories\User\UserRepositoryInterface $userRepository,
        \App\Repositories\User\UserLatestCodeRepositoryInterface $userLatestCodeRepository,
        \App\Repositories\SocialAccount\SocialAccountRepositoryInterface $socialAccountRepository,
        \App\Queries\SocialAccount\EloquentSocialAccountQueryServiceInterface $socialAccountQueryService
    ) {
        $this->userRepository = $userRepository;
        $this->userLatestCodeRepository = $userLatestCodeRepository;
        $this->socialAccountRepository = $socialAccountRepository;
        $this->socialAccountQueryService = $socialAccountQueryService;
    }

    /**
     * @param string $provider
     * @return void
     * @throws Exception
     */
    public function handle(string $provider): void
    {
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $provider_id = $userSocial->id;

        DB::beginTransaction();
        try {
            $socialAccount = $this->socialAccountQueryService->firstByProviderIdProvider($provider_id, $provider);

            // FIXME: Throws an exception if the user has been deleted
            $user = $socialAccount->user;
            $user->last_login_at = now();
            $this->userRepository->save($user);

            DB::commit();
        } catch (ModelNotFoundException $e) {
            $code = $this->userLatestCodeRepository->next();

            $user = $this->userRepository->store([
                'name' => $userSocial->name,
                'company_id' => CompanyConstant::INDEPENDENT_COMPANY_ID,
                'role_id' => RoleConstant::DEFAULT_ROLE_ID,
                'code' => $code,
                'email' => $userSocial->email,
                'emoji' => '',
                'password' => Hash::make(Str::random(32)),
                'email_verify_token' => '',
                'last_login_at' => now(),
                'email_verified_at' => now()->toDateTimeString(),
            ]);

            $this->socialAccountRepository->store([
                'user_id' => $user->id,
                'provider_id' => $provider_id,
                'provider_name' => $provider,
                'avatar_path' => $userSocial->avatar,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception('Failed registration');
        }

        Auth::login($user);
    }
}
