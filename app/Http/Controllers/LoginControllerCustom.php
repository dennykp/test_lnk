<?php

namespace App\Http\Controllers;
use Validator,Redirect,Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
Use App\User;
use Mail;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
class LoginControllerCustom extends Controller
{
	use AuthenticatesUsers;
   public function index()
    {

        return view('login');
    }  
 	protected function authenticated() {
	if (Auth::check()) {
		return redirect()->route('dashboard');
	}
	}
    public function registration()
    {
        return view('registration');
    }
    public function link_login(){
        return view('login');
    }
    public function postLogin(Request $request)
    {
        request()->validate([
        'name' => 'required',
        'password' => 'required',
        ]);
 
        $credentials = $request->only('name', 'password');
        if (Auth::attempt($credentials)) {
            	return redirect()->intended('dashboard');

            // Authentication passed...
        }
        return Redirect::to("/")->withSuccess('Oppes! You have entered invalid credentials');
        alert('error');
    }

 
    public function postRegistration(Request $request)
    {  
        request()->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        ]);
         
        $data = $request->all();
 
        $check = $this->create($data);
        Mail::send('isiemail', array('pesan' => 'Username: '.$request->name, 'pesan2' => 'Password: '.$request->password) , function($pesan) use($request){
                    $pesan->to($request->email,'Verifikasi')->subject('Form Registrasi');
                    $pesan->from(env('MAIL_USERNAME','dejavadeveloper@gmail.com'),'Registrasi dengan Email anda');
                   
                });
       
        return redirect()->back()->with('message', 'Silakan check email untuk Login!');
    }
     
    public function dashboard()
    {
 
      if(Auth::check()){
        return view('dashboard');
      }
       return Redirect::to("login2")->withSuccess('Opps! You do not have access');
    }
    public function dashboard_siswa()
    {
 
      if(Auth::check()){
        return view('dashboard_siswa');
      }
       return Redirect::to("login2")->withSuccess('Opps! You do not have access');
    }
 
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }
     
    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
}
