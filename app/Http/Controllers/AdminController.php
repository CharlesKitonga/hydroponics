<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use Auth;

class AdminController extends Controller
{
    public function index(Request $request){
        //first check if you are logged in
        if(!Auth::check() && $request->path() != 'login' ) {
            return redirect('/login');
        }if(!Auth::check() && $request->path() == 'login') {
            return view('welcome');
        }
        //if logged in... check if you are an  Admin User
        $user = Auth::user();
        //dd($user);
        if($user->userType == 'User') {
            return redirect('/login');
        }
        if($request->path() == 'login') {
            return redirect('/');
        }

        return view('welcome');
    }

    public function Logout(){
        Auth::logout();
        return redirect('/login');

    }
}
