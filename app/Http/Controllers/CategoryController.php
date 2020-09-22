<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::latest()->get();

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
    public function uploadImage(Request $request){

        //validate request
        $this->validate($request, [
            'file' => 'required|mimes:jpg,jpeg,png,svg'
        ]);
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('images/categories'), $picName);
        return $picName;
    }
    public function store(Request $request)
    {
        //validate request
        $this->validate($request, [
            'category_name' =>'required',
            'iconImage'=> 'required'
        ]);
        return Category::create([
            'category_name' => $request->category_name,
            'iconImage' => $request->iconImage
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
            'iconImage'=> 'required',
            'category_name' => 'required|string|max:191',
            'id'  => 'required'
        ]);
        return Category::where('id', $request->id)->update([
            'category_name'=> $request->category_name,
            'iconImage' => $request->iconImage

        ]);
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

    public function deleteImage(Request $request){
        $fileName = $request->imageName;
        $this->deleteFIleFromServer($fileName);
    }

    public function deleteFIleFromServer($fileName){
        $filePath = public_path().'images/categories'.$fileName;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return;
    }
}
