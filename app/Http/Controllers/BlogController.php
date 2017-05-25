<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function getIndex() {
        $posts = Post::paginate(5);
        return view('blog.index')->withPosts($posts);
    }

    public function getSingle($slug) {
        // fetch from db by slug
        $post = Post::where('slug', '=', $slug)->first();   // first = stop after the first obj you find
        //return the view and pass the post obj
        return view('blog.single')->withPost($post);
    }
}
