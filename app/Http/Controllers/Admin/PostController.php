<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\PostFormRequest;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('admin.post.index')->with('posts', $posts);
    }

    public function create()
    {
        $category = Category::where('status', '0')->get();
        return view('admin.post.create')->with('category', $category);
    }

    public function store(PostFormRequest $request)
    {
        $data = $request->validated();

        $posts = new Post;
        $posts->category_id = $data['category_id'];
        $posts->name = $data['name'];
        $posts->slug = Str::slug($data['slug']);
        $posts->description = $data['description'];
        $posts->yt_iframe = $data['yt_iframe'];
        $posts->meta_title = $data['meta_title'];
        $posts->meta_description = $data['meta_description'];
        $posts->meta_keyword = $data['meta_keyword'];
        $posts->status = $request->status == true ? '1':'0';
        $posts->created_by = Auth::user()->id;

        $posts->save();

        return redirect('admin/posts')->with('message', 'Post Added Successfully');

    }

    public function edit($post_id)
    {
        $category = Category::where('status', '0')->get();
        $posts = Post::find($post_id);
        return view('admin.post.edit')->with('posts', $posts)->with('category', $category);
    }

    public function update(PostFormRequest $request, $post_id)
    {
        $data = $request->validated();
        $posts = Post::find($post_id);

        $this->$post_id = $posts->id;

        $posts->category_id = $data['category_id'];
        $posts->name = $data['name'];
        $posts->slug = Str::slug($data['slug']);
        $posts->description = $data['description'];
        $posts->yt_iframe = $data['yt_iframe'];
        $posts->meta_title = $data['meta_title'];
        $posts->meta_description = $data['meta_description'];
        $posts->meta_keyword = $data['meta_keyword'];
        $posts->status = $request->status == true ? '1':'0';
        $posts->created_by = Auth::user()->id;

        $posts->update();

        return redirect('admin/posts')->with('message ', 'Post Updated Successfully');
    }

    public function destroy($post_id)
    {
        $post = Post::find($post_id);

        $post->delete();

        return redirect('admin/posts')->with('message', 'Post Deleted Successfully');
    }
}
