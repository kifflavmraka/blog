<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use App\Category;
use Storage;
//use Illuminate\Contracts\Session\Session;  <-not the right one, was automatically added
use Mews\Purifier\Facades\Purifier;
use Session;
use Illuminate\Http\Request;
use Image;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // fetch blog posts in a var - pagination
        $posts = Post::orderBy('id', 'desc')->paginate(5);

        //return a view and pass variable
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create')->withCategories($categories)->withTags($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate data
        $this->validate($request, array(
            'title'         => 'required|max:255',
            'slug'          => 'required|min:5|alpha_dash|max:255|unique:posts,slug',
            'category_id'   => 'required|integer',
            'featured_image'=> 'sometimes|image|size:2048',
            'body'          => 'required'
            ));

        // store in db
        $post = new Post;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->body = Purifier::clean($request->body);

//        dd($request->file('featured_image'));
        //handling image upload
        if($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800,400)->save($location);
            $post->image = $filename;
        }

        $post->save();

        $post->tags()->sync($request->tags, false);   // false = not override existing assossiations !!
                                                      // true/omit = polzva se pri update

        //flash variable means it can be used only once-gets deleted afterwards.
        Session::flash('success', 'The blog post was successfully saved!');

        // redirect
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // fetch the post to be edited
        $post = Post::find($id);
        $dump = Category::all();
        $categories = array();
        foreach ($dump as $row)
            $categories[$row->id] = $row->name;

        $tags = Tag::all();
        $tags2 = array();
        foreach ($tags as $tag) {
            $tags2[$tag->id] = $tag->name;
        }

        // return a view
        return view('posts.edit')->withPost($post)->withCategories($categories)->withTags($tags2);
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
        // validate data
        $post = Post::find($id);


        $this->validate($request, array(
            'title'         => 'required|max:255',
            'slug'          => "required|min:5|alpha_dash|max:255|unique:posts,slug,$id",
            'category_id'   => 'required|integer',
            'body'          => 'required',
            'featured_image'=> 'image'
        ));


        // save the data to db
        $post = Post::find($id);

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->category_id = $request->category_id;
        $post->body = Purifier::clean($request->body);

        if($request->hasFile('featured_image')) {
            // add the new photo
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800,400)->save($location);
            $old_filename = $post->image;
            // update db
            $post->image = $filename;
            // delete the old image
            Storage::delete($old_filename);

        }
        $post->save();

        $post->tags()->sync($request->tags, true);

        //flash variable means it can be used only once-gets deleted afterwards.
        Session::flash('success', 'The post was successfully edited!');

        // redirect
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->tags()->detach();
        Storage::delete($post->image);

        $post->delete();

        Session::flash('success', 'The post was successfully deleted!');
        return redirect()->route('posts.index');
    }
}
