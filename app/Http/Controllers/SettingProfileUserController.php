<?php

namespace App\Http\Controllers;

use App\Models\SettingProfileUser;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingProfileUserController extends Controller
{

    public function show(Request $request)
    {

        if ($this->getSettingUser($request)) {
            return $this->getSettingUser($request);
        }

        return redirect()->route('profile.notFound');
    }
    private function getSettingUser($request)
    {
        $slug = Str::slug(last(explode('/', parse_url($request->fullUrl(), PHP_URL_PATH))));
        return SettingProfileUser::where('slug', $slug)->with('user.address', 'user.rating', 'user.image')->first();
    }
    public function notFound(): View
    {
        return view('profile.404');
    }
}
