<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;

class AdminBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Upload an Image.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadImage(Request $request)
    {
         //validate request
         $this->validate($request, [
            'image' => 'required|mimes:jpg,jpeg,png,svg'
        ]);
        $picName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images/blogs'), $picName);
        return response()->json([
            'success' => 1,
            'file' => [
                'url' => "http://127.0.0.1:8000/images/blogs/$picName"
            ]
        ]);
        return $picName;
    }

    public function slug(){
        $title = "Example Title Case";
        return Blog::create([
            'title' => $title,
            'post' => 'some post',
            'post_excerpt' => 'let us read',
            'user_id' => 1,
            'metaDescription' => 'some post on very exciting news',
        ]);
        return $title;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
