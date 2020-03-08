<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use App\Usuario;
use Google_Client;

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
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('adminlte::auth.login');
    }

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
        $this->middleware('guest', ['except' => 'logout']);
    }

    //public function redirectToProvider($provider)
    public function redirectToProvider()
    {
        //dd("OK");
        return Socialite::driver('google')->redirect();
        //return Socialite::driver('google')->stateless()->user();//redirect();
        //return Socialite::driver('google')->scopes(['openid', 'profile', 'rut'])->redirect();//->route('callback');
    }
    //public function handleProviderCallback($provider)
    public function handleProviderCallback()
    {
        //dd("no OK");
        //$user = Socialite::driver('google')->stateless()->user();
        $user = Socialite::driver('google')->stateless()->user();
        if(count($user) > 0){ 
            //return $user->rut;
            $authUser = Usuario::where('rut','=',$user->rut)->get();
            if(count($authUser) > 0){
                $rolesArreglo   = [];
                foreach ($authUser as $key => $value) {
                    $correo     = $value->rut;
                    $roles      = $value->rol;
                }
                if($roles != ''){
                    $cadenadividida = explode(',', $roles);
                }
                if(count($cadenadividida)>0){
                    foreach ($cadenadividida as $key => $value) {
                        array_push($rolesArreglo,$value);
                    }
                }                
                return view('auth.rol')->with('correo', $correo)->with('rolesArreglo', $rolesArreglo);
            }else{
                //dd("no esta registrado!!!");
                //return redirect('/login')->with('error','Correo no se encuentra en nuestros registros.');
                $error = 'Correo no se encuentra en nuestros registros.';
                return view('auth.reLogin')->with('error', $error);
            }
        }

/*
        dd($user);
        $authUser = $this->findOrCreateUser($user, $provider);
        dd($authUser);
        Auth::login($authUser, true);

        //return redirect($this->redirectTo);
*/
    }

/*
    public function findOrCreateUser($user, $provider)
    {
        dd($user);
        $authUser = User::where('rut', $user->rut)->first();
        if($authUser){
            return $authUser;
        }else{
            dd("no esta registrado!!!");
        }
    }

    public function prueba()
    {
        dd("ok");
    }
    */
}
