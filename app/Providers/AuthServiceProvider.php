<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
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

        // tag delete update gate, will only allow the user with the same user_id on the tag
        Gate::define('delete-update-tag', function (User $user, Tag $tag) {
            return $user->id === $tag->user_id;
        });

        // aritcle delete and update, only allow the owner of the article and super admin
        Gate::define('delete-update-article', function (User $user, Article $article) {
            return $user->id === $article->user_id;
        });

        // check if the password is the same as the one from the logined user
        Gate::define('password-auth', function (User $user, $password) {
            return Hash::check($password, $user->password);
        });
    }
}
