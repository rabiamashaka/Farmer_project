<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

use App\Models\Crop;
use App\Models\Farmer;
use App\Services\NotifyAfricanService;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration form.
     */
   public function create(): View
    {
         app()->setLocale(session('locale', config('app.locale')));
        $crops = Crop::orderBy('name')->get();
        return view('auth.register', compact('crops'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
 public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'phone' => 'required|digits_between:9,15',
        'region_id' => 'required|exists:regions,id',
        'farming_type' => 'required|in:Crops,Livestock,Mixed',
        'password' => 'required|string|confirmed|min:8',
        'crops'   => 'nullable|array',
        'crops.*' => 'integer|exists:crops,id',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user',
    ]);

    $farmer = Farmer::create([
        'user_id' => $user->id,
        'name' => $user->name,
        'phone' => $request->phone,
        'region_id' => $request->region_id,
        'farming_type' => $request->farming_type,
    ]);

    if ($request->has('crops')) {
    $farmer->crops()->sync($request->input('crops'));
}
        event(new Registered($user));

        // Flash success message
        session()->flash('success', __('Registration successful!'));


        auth()->login($user);   // or Auth::login($user);
        $notify = new NotifyAfricanService();
        $notify->sendSms($user->phone, __('Welcome to our platform! Your registration is successful.'));

        return redirect()->route('userdashboard');  // adjust to your post-register route
    }
}


