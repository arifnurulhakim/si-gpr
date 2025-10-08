<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        // Check if it's resident login (block only, password is NIK)
        if ($request->filled('block') && !$request->filled('login')) {
            $request->validate([
                'block' => 'required|string',
                'password' => 'required|string|size:16',
            ], [
                'password.size' => 'NIK harus 16 digit.',
            ]);

            return $this->attemptResidentLogin($request);
        }

        // Otherwise, use flexible login (email or NIK)
        $this->validateLogin($request);

        if ($this->attemptFlexibleLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application using flexible login.
     */
    protected function attemptFlexibleLogin(Request $request)
    {
        $user = User::findByEmailOrNik($request->login);

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->filled('remember'));
            return true;
        }

        return false;
    }

    /**
     * Attempt to log the user into the application using block and NIK.
     * For resident login, the password field contains the NIK.
     */
    protected function attemptResidentLogin(Request $request)
    {
        // Password is the NIK for resident login
        $nik = $request->password;

        $user = User::findByBlockAndNik($request->block, $nik);

        if ($user && Hash::check($nik, $user->password)) {
            Auth::login($user, $request->filled('remember'));

            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'login';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
