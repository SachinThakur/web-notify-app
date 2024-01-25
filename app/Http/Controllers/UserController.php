<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Rules\PhoneNumberValidateUsingApi;

class UserController extends Controller
{
	
    public function __construct()
	{
        $this->middleware('auth');
    }
	
	// Show all users
    public function index()
    {
        $users = User::all();
        $user_list = [];
        foreach($users as $user){
            $user_list[] = [
                'id'  => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'read' => $user->readNotifications()->count(),
                'unread' => $user->unreadNotifications()->count(),
                'total' => $user->notifications->count(),
                'created_at' => $user->created_at,
            ];
        }

		return view('user.index', compact('user_list'));
    }
	
	// Show the form to create new user
    public function create()
    {
        $user = new User();
        return $this->edit($user);
    }
	
    // Show the form for editing the specified user
    public function edit(User $user){
        return view('user.edit', compact('user'));
    }
	
    // Save a newly created user
    public function store(Request $request){
        $user = new User();
        return $this->update($request, $user);
    }
    // Update the specified website
    public function update(Request $request, User $user){
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => ['required',new PhoneNumberValidateUsingApi()]
        ]);
		
		if($user->id){
			$request->validate([
				'name' => 'required',
				'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => ['required',new PhoneNumberValidateUsingApi()]
			]);
		}
		
		if(!$user->id){
			$request->validate([
				'password' => 'required|string|min:6|confirmed',
			]);
		}

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        $send_notification = false;
        if(isset($request->send_notification)){
			$send_notification = true;
		}
        $user->send_notification =  $send_notification;

		if($request->input('password')){
			$user->password = bcrypt($request->input('password'));
		}
		
        $message = $user->id ? 'User has been updated successfully' : 'User has been created successfully';
        $user->save();
		
        return redirect()
            ->route('user.index')
            ->with('status', $message);
    }
	
    // Delete the specified user
    public function destroy(User $user)
    {
        if($user->id == auth()->user()->id){
            return abort(401);
        }
		
        $user->delete();
        return redirect()
            ->route('user.index')->with('status', 'User has been deleted successfully');
    }
	
}
