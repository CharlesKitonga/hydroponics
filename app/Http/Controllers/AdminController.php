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
        return $this->checkForPermission($user, $request);
    }

    public function checkForPermission($user, $request){
        $permission = json_decode($user->role->permission);
        $hasPermission = false;
        if(!$permission) return view('welcome');
        foreach($permission as $p){
            if ($p->name == $request->path()) {
                if ($p->read) {
                    $hasPermission = true;
                }
            }
        }
        if($hasPermission) return view('welcome');
        return view('notfound');

    }

    public function Logout(){
        Auth::logout();
        return redirect('/login');

    }
}
