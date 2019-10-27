<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AesCipher;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();

            if ($request->is('api/*')) {
                //write your logic for api call
                $user->generateToken();

                // encrypt token
                $secretKey = '26kozQaKwRuNJ24t';
                $user->api_token = enc($secretKey, $user->api_token);

                return response()->json([
                    'data' => $user->toArray(),
                ]);
            } else {

            }
        }

        if ($request->is('api/*')) {
            return response()->json([
                'data' => ['success' => false, 'message' => 'Access Denied. Invalid Username and / or password'],
            ]);
        } else {
            return $this->sendFailedLoginResponse($request);
        }


    }

    public function logout(Request $request)
    {
        //$user = Auth::guard('api')->user();
        $guard = $request->has('api_token') ? 'api' : 'web';
        $user = Auth::guard($guard)->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        Auth::logout();
        if ($request->is('api/*')) {
            //write your logic for api call
            return response()->json(['data' => 'User logged out.'], 200);
        } else {
            redirect($this->redirectTo)->send();
        }


    }

}
