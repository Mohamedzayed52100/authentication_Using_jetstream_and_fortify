<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\CreateNewUser2;
use App\Actions\Fortify\LoginUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Middleware\LoginLog;
// use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Fortify;

use App\Models\User;
//  use App\Actions\Fortify\LoginUser;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Route;
// use App\Actions\Fortify\CreateNewUser;
// use App\Actions\Fortify\CreateNewUser2;
// use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
// use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\ResetUserPassword2;
// use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserPassword2;
// use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
// use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Actions\Fortify\UpdateUserProfileInformation2;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
// use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Fortify::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        $this->configureRoutes();
 
        
        Fortify::registerView('auth.register2');
        Fortify::createUsersUsing(CreateNewUser2::class);
        Fortify::loginView('auth.login2');


        Fortify::authenticateUsing([new LoginUser, '__invoke']);

        //create my pipline 
        Fortify::authenticateThrough(function (Request $request) {
            return array_filter([
                config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
                RedirectIfTwoFactorAuthenticatable::class,
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class,
                LoginLog::class,
            ]);
        });

        Fortify::verifyEmailView('auth.verify-email2');

        Fortify::requestPasswordResetLinkView('auth.forgot-password2');
        Fortify::resetPasswordView('auth.reset-password2');
        Fortify::resetUserPasswordsUsing(ResetUserPassword2::class);

        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation2::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword2::class);

        Fortify::confirmPasswordView('auth.confirm-password2');
        // Fortify::confirmPasswordsUsing();


    }

    protected function configureRoutes()
    {
             Route::group([
                'namespace' => 'Laravel\Fortify\Http\Controllers',
                'domain' => config('fortify.domain', null),
                'prefix' => config('fortify.prefix'),
            ], function () {
                $this->loadRoutesFrom(base_path('routes/fortify.php'));
            });
        
    }
    
}
