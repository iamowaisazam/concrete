<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;


class AppServiceProvider extends ServiceProvider
{
  
    public function register(): void
    {
      
    }


    public function boot(): void
    {
        
        View::share('_s', [
            'primary' => '',
        ]);

      
        View::composer('*', function ($view) {
            $user = Auth::user();

            $isAdmin = null;
            $permissions = [];
            $notifications = collect(); 

            if ($user) {
           
                $roleId = $user->user_type ?? null;
                $role = Role::find($roleId);

                if ($role && $role->permissions) {
                    $permissions = $role->permissions;
                }

                $isAdmin = $roleId;

          
            }

            $view->with('isAdmin', $isAdmin);
            $view->with('Permissions', $permissions);
            $view->with('UserNotifications', $notifications); 
        });
    }
}
