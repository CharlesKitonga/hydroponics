<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Category;
use App\Blog;
use App\User;
use Auth;
use Session;

class PagesController extends Controller
{
    public function Index(){
        
        $categories = Category::orderBy('id', 'desc')->limit(3)->get();
        $blogs = Blog::orderBy('id', 'desc')->with('category', 'tag', 'user')->limit(4)->get();
        
        //dd($blogs);
        return view('index', compact('categories','blogs'));
    }
    public function compose(View $view){

        $cat = Category::limit(2)->get();

        $view->with('category', $cat);
    }
    public function categoryBlogs(Request $request, $category_name, $id){
        $categoryBlogs = Blog::with('user')->whereHas('category', function($q) use($id){
            $q->where('category_id', $id);
        })->orderBy('id', 'desc')->select('id', 'title', 'slug', 'user_id', 'featuredImage')->paginate(1);
        //return $categoryBlogs;
        return view('category', compact('categoryBlogs', 'category_name'));
    }   
    public function tagBlogs(Request $request, $tag_name, $id){
        $tagBlogs = Blog::with('user')->whereHas('tag', function($q) use($id){
            $q->where('tag_id', $id);
        })->orderBy('id', 'desc')->select('id', 'title', 'slug', 'user_id', 'featuredImage')->paginate(5);

        return view('tag', compact('tagBlogs', 'tag_name'));
    }  

    public function show($slug){
        $blog = Blog::where('slug', $slug)->with('category', 'tag', 'user')->first();
        //dd($blog);
        $category_ids= [];
        foreach($blog->category as $cat){
            array_push($category_ids, $cat->id);
        }
        //return $category_ids;
        $relatedBlogs = Blog::with('user')->where('id', '!=', $blog->id)->whereHas('category', function($q) use($category_ids){
            $q->whereIn('category_id', $category_ids);
        })->limit(5)->orderBy('id', 'desc')->get();
        return view('singleblog', compact('blog', 'relatedBlogs'));
    }

    public function About(){

    	return view('about');
    }

    public function Contact(){

    	return view('contact');
    }

    public function login(Request $request){
        if ($request->isMethod('post')) {
			$data = $request ->input();
			if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])) {
				// echo "success";die;
				Session::put('userSession',$data['email']);
				return redirect('/');
			}else{
				// echo "Failed";die;
				return redirect('/user-login')->with('flash_message_error','Invlaid Username or Password');
			}
		}
        return view('login');
    }

    public function register(Request $request){
        if($request->isMethod('post')){
            $user = new User();
            $name = $request->name;
            $user->name = $request->name; 
            $user->email = $request->email; 
            $user->slug = Str::slug($name);
            $user->password = Hash::make($request->password);
            //dd($user);
            $user->save();

            return redirect('/');
        }
        return view('register');
    }
}
