<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Password::defaults(
            fn () =>
            Password::min(8)->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
        );

        // tag delete gate, will only allow the user with the same user_id on the tag
        Gate::define('delete-tag', function (User $user, Tag $tag) {
            return $user->id === $tag->user_id;
        });
    }
}
