<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\NewUserNotification;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->paginate(10);
        return view('backend.users.index', compact('users'));
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User status updated successfully');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|string',
            'status' => 'required|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
            'photo' => $request->photo
        ]);

        // Send welcome email
        $user->notify(new NewUserNotification());

        return redirect()->route('admin.users.index')->with('success', 'User successfully created');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $status = $user->delete();
        
        if($status) {
            return redirect()->route('admin.users.index')->with('success', 'User successfully deleted');
        } else {
            return redirect()->route('admin.users.index')->with('error', 'Error occurred while deleting user');
        }
    }
}