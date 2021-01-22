<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate request
        $this->validate($request, [
            'fullName' => 'required|string',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:8',
            'role_id' => 'required|integer'
        ]);

        $password = bcrypt($request->password);

        $user = User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => $password,
            'role_id' => $request->role_id,
        ]);

        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //validate request
        $this->validate($request, [
            'fullName' => 'required|string',
            'email' => "bail|required|email|unique:users,email,$request->id",
            'password' => 'min:8',
            'role_id' => 'required|integer'
        ]);
        $data = [
                'fullName' => $request->fullName,
                'email' => $request->email,
                'role_id' => $request->role_id,
        ];
        if ($request->password) {
            $password = bcrypt($request->password);
            $data['password'] = $password;
        }

        $user = User::where('id', $request->id)->update($data);

        return $user;
    }

    public function adminLogin(Request $request){
        //validate request
        $this->validate($request, [
            'email' => "bail|required|email",
            'password' => 'bail|required|min:8'
        ]);
        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password])) {
            $user = Auth::user();
            if ($user->role->isAdmin == 0) {
                Auth::logout();
                return response()->json([
                    'msg' => 'Incorrect login details',
                ],401);
            }
            return response()->json([
                'msg' => 'You are logged in',
                'user' => $user
            ]);
        }else{
            return response()->json([
                'msg' => 'Incorrect login details',
            ],401);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        //validate request
        $this->validate($request, [
            'id'  => 'required'
        ]);
        return User::where('id', $request->id)->delete();
    }
}
