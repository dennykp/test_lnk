<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Session;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('disablepreventback');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
       public function send(Request $request){
        try{
            Mail::send('isiemail', array('pesan' => $request->pesan) , function($pesan) use($request){
                $pesan->to($request->penerima,'Verifikasi')->subject('Form Registrasi');
                $pesan->from(env('MAIL_USERNAME','dejavadeveloper@gmail.com'),'Registrasi dengan Email anda');
               
            });
            return redirect()->back()->with('message', 'Success Send Email!');
        }catch (Exception $e){
            return response (['status' => false,'errors' => $e->getMessage()]);
        }
    }
}
