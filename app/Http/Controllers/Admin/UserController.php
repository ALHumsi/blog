<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user.index')->with('users', $users);
    }

    public function edit($user_id)
    {
        $users = User::find($user_id);
        return view('admin.user.edit')->with('users', $users);
    }

    public function update(Request $request, $user_id)
    {
        $users = User::find($user_id);

        if ($users)
        {
            $users->role_as = $request->role_as;

            $users->update();

            return redirect('admin/users')->with('message', 'Updated Successfully');
        }

        return redirect('admin/users')->with('message', 'No User Found');
    }

    public function showUser()
    {
        $users = User::all();

    }
}
