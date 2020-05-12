<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Patient::class => PatientPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /* define a admin user role */
        Gate::define('isAdmin', function($user) {
           return $user->role->name == 'admin'| $user->role->name == 'super_admin';
        });
       
        /* define a user role */
        Gate::define('isUser', function($user) {
            return $user->role->name == 'user' | $user->role->name == 'admin' | $user->role->name == 'super_admin';
        });
      
        /* define a new role */
        Gate::define('isNew', function($user) {
            return $user->role->name == 'new';
        });

        Gate::define('isNotNew', function($user) {
            return $user->role->name != 'new';
        });
    }
}
