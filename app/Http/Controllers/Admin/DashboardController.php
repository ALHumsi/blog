<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::count();
        $posts = Post::count();
        $users = User::where('role_as', '0')->count();
        $admins = User::where('role_as', '1')->count();
        return view('admin.dashboard')->with('categories', $categories)
        ->with('posts', $posts)
        ->with('users', $users)
        ->with('admins', $admins);
    }
}
