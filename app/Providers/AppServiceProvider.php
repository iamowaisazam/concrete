<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\UserNotificationAlert; 

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

          
                $notifications = UserNotificationAlert::where('user_id', $user->id)
                    ->where('is_read', 0)
                    ->latest()
                    ->take(10) 
                    ->get();
            }

            $view->with('isAdmin', $isAdmin);
            $view->with('Permissions', $permissions);
            $view->with('UserNotifications', $notifications); 
        });
    }
}
