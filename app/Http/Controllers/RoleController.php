<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::latest()->get();

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
            'roleName' => 'required|string|max:191'
        ]);
        return Role::create([
            'roleName' => $request->roleName
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         //
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
            'roleName' => 'required|string|max:191',
            'id'  => 'required'
        ]);
        return Role::where('id', $request->id)->update([
            'roleName'=> $request->roleName
        ]);
    }

    public function assignRole(Request $request){
        $this->validate($request, [
            'permission' => 'required',
            'id' => 'required|integer   ',
        ]);
        return Role::where('id', $request->id)->update([
            'permission' => $request->permission
        ]);
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
        return Role::where('id', $request->id)->delete();
    }
}
