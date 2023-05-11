<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

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
    protected $redirectTo = RouteServiceProvider::FTPLogin;

    public function login(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if ($user && $user->approve != "0") {
            if ($user->enddate != null && $user->enddate < Date::now()) {
                $approveUpdate = [
                    'approve' => "0"
                ];
                User::where('id', $user->id)->update($approveUpdate);
                return redirect('/login')->with('message', "You're expired.");
            }

            $this->validateLogin($request);

            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            if (method_exists($this, 'hasTooManyLoginAttempts') &&
                $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }

            if ($this->attemptLogin($request)) {
                if ($request->hasSession()) {
                    $request->session()->put('auth.password_confirmed_at', time());
                }
                if (json_decode($user->last_login) == null) $old = null;
                else $old = json_decode($user->last_login);
                $user->last_login = json_encode([
                    'current_login' => [
                        "PC" => gethostname(),
                        "IP" => $_SERVER['REMOTE_ADDR']
                    ],
                    'last_login' => $old != null? $old->current_login: null,
                    'ftp' => $old != null? $old->ftp: null
                ]);
                $user->save();
                return $this->sendLoginResponse($request);
            }

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);


            return redirect('/login')->with('message', 'Password Incorrect');
        } else if (!$user)
            return redirect('/login')->with('message', 'Do not Exist');
        else
            return redirect('/login')->with('message', 'Your membership has expired');


    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
