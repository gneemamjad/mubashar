<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

class AuthController extends Controller
{
    /**
     * Admin login
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        // Check if admin exists and is active
        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin) {
            return back()->withErrors([
                'error' => 'The provided credentials do not match our records.',
            ])->withInput();
        }

        if ($admin && !$admin->is_active) {
            return back()->withErrors([
                'email' => 'Your account is inactive. Please contact administrator.',
            ])->withInput();
        }

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    /**
     * Admin registration
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Admin registered successfully');
    }

    /**
     * Admin logout
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')
            ->with('success', 'Successfully logged out');
    }

    /**
     * Get authenticated admin profile
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function profile(Request $request)
    {
        return view('admin.profile', [
            'admin' => Auth::guard('admin')->user()
        ]);
    }

    /**
     * Show the admin login page
     *
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }
}
