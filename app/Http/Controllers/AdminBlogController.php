<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use App\Blogcategory;
use App\Blogtag;
use Auth;
use DB;
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
        $this->validate($request, [
            'title' => 'required',
            'post' => 'required',
            'post_excerpt' => 'required',
            'metaDescription' => 'required',
            'jsonData' => 'required',
            'category_id' => 'required',
            'tag_id' => 'required',
        ]);
        $categories = $request->category_id;
        $tags = $request->tag_id;

        $blogCategories = [];
        $blogTags = [];
        DB::beginTransaction();
        try {
            $blog = Blog::create([
                'title' => $request->title,
                'slug' => $request->title,
                'post' => $request->post,
                'post_excerpt' => $request->post_excerpt,
                'user_id' => Auth::user()->id,
                'metaDescription' => $request->metaDescription,
                'jsonData' => $request->jsonData,
            ]);
            // insert blog categories
            foreach ($categories as $c) {
                array_push($blogCategories, ['category_id' => $c, 'blog_id' => $blog->id]);
            }
            Blogcategory::insert($blogCategories);
            // insert blog tags
            foreach ($tags as $t) {
                array_push($blogTags, ['tag_id' => $t, 'blog_id' => $blog->id]);
            }
            Blogtag::insert($blogTags);
            DB::commit();
            return 'done';
        } catch (\Throwable $th) {
            DB::rollback();
            return 'not done';
        }
    }
    public function blogdata(Request $request)
    {
        return Blog::with(['tag', 'category'])->orderBy('id', 'desc')->paginate($request->total);
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
        return Blog::with(['tag', 'category'])->where('id', $id)->first();

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
        $this->validate($request, [
            'title' => 'required',
            'post' => 'required',
            'post_excerpt' => 'required',
            'metaDescription' => 'required',
            'jsonData' => 'required',
            'category_id' => 'required',
            'tag_id' => 'required',
        ]);
        $categories = $request->category_id;
        $tags = $request->tag_id;

        $blogCategories = [];
        $blogTags = [];
        DB::beginTransaction();
        try {
            $blog = Blog::where('id', $id)->update([
                'title' => $request->title,
                'slug' => $request->title,
                'post' => $request->post,
                'post_excerpt' => $request->post_excerpt,
                'user_id' => Auth::user()->id,
                'metaDescription' => $request->metaDescription,
                'jsonData' => $request->jsonData,
            ]);

            // insert blog categories
            foreach ($categories as $c) {
                array_push($blogCategories, ['category_id' => $c, 'blog_id' => $id]);
            }
            //delete the previous categories && insert the new ones
            Blogcategory::where('blog_id', $id)->delete();
            Blogcategory::insert($blogCategories);

            // insert blog tags
            foreach ($tags as $t) {
                array_push($blogTags, ['tag_id' => $t, 'blog_id' => $id]);
            }
            //delete the previous tags && insert the new ones
            Blogtag::where('blog_id', $id)->delete();           
            Blogtag::insert($blogTags);
            DB::commit();
            return 'done';
        } catch (\Throwable $th) {
            DB::rollback();
            return 'not done';
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
        return Blog::where('id', $request->id)->delete();
    }
}
