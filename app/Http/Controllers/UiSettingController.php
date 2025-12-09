<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\UserUiSetting;
use Illuminate\Support\Facades\Auth;

class UiSettingController extends Controller
{
    public function edit()
    {
        $setting = UserUiSetting::firstOrCreate(['user_id' => Auth::id()]);
        return view('user.settings.ui', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'primary_color' => 'nullable|string',
            'theme' => 'required|in:light,dark',
            'skin' => 'required|in:default,bordered,semi_dark',
            'semi_dark' => 'nullable|in:on,off',
            'menu' => 'required|in:expanded,collapsed',
            'navbar' => 'required|in:sticky,static,hidden',
            'content' => 'required|in:compact,wide',
            'direction' => 'required|in:ltr,rtl',
        ]);
    
        $settingsData = $request->only(['primary_color', 'theme', 'skin', 'menu', 'navbar', 'content', 'direction']);
    
        // Explicitly handle the semi_dark value
        $settingsData['semi_dark'] = $request->has('semi_dark') ? 'true' : 'false';
    
        $setting = UserUiSetting::updateOrCreate(
            ['user_id' => Auth::id()],
            $settingsData
        );
    
        return redirect()->back()->with('success', 'UI settings updated successfully!');
    }
}
