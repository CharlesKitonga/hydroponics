<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\str;

class Blog extends Model
{
    protected $fillable = ['title', 'post_excerpt', 'slug', 'user_id', 'featuredImage', 'metaDescription', 'views'];

    public function setSlugAttribute($title){
        $this->attributes['slug'] = $this->uniqueSlug($title);
    }

    private function uniqueSlug($title){
        $slug = Str::slug($title, '-');
        $count = Blog::where('slug', 'LIKE', "{$slug}%")->count();
        $newCount = $count > 0 ? ++$count : '';
        return $newCount > 0 ? "$slug-$newCount" : $slug;
    }

    public function tag(){
        return $this->belongsToMany('App\Tag', 'blogtags');
    }
    public function category(){
        return $this->belongsToMany('App\Category', 'blogcategories');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
