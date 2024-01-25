<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\UserNotification;
use Notification;

class NotificationController extends Controller
{
	
    public function __construct()
	{
        $this->middleware('auth');
    }
	
	// Show all users
    public function index()
    {
		$notifications = auth()->user()->unreadNotifications;
        //dd($notifications->toArray());
        //$notifications = auth()->user()->unreadNotifications;
		return view('notification.index', compact('notifications'));
    }
	
	// Show the form to create new user
    public function create()
    { 
        $users = User::where('send_notification',1)->get();
        return view('notification.create', compact('users'));
    }
	
    // Show the form for editing the specified user
    public function edit($notification){
        return view('notification.edit', compact('notification'));
    }
	
    // Save a newly created user
    public function store(Request $request){
        //dd($request->toArray());
        if(isset($request->sentToAll)){
            $members_to_notify = User::where('send_notification',1)->get();           
        }else{
            $members_to_notify = User::whereIn('id',$request->user_ids)->get();
        }
        // exclude users who disabled notification 

        Notification::send($members_to_notify, new UserNotification($request));
        return redirect()->route('notification.index')->with('status', 'Notification sent successfully.');
    }
    // Update the specified website
    public function update(Request $request, User $user){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => ['required', new PhoneNumberValidateUsingApi()],
        ]);
		
		if($user->id){
			$request->validate([
				'name' => 'required',
				'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => ['required', new PhoneNumberValidateUsingApi()],
			]);
		}
		
		if(!$user->id){
			$request->validate([
				'password' => 'required|string|min:6|confirmed',
			]);
		}

        $user->name = $request->input('name');
        $user->email = $request->input('email');

		if($request->input('password')){
			$user->password = bcrypt($request->input('password'));
		}
		
        $message = $user->id ? 'User has been updated successfully' : 'User has been created successfully';
        $user->save();
		
        return redirect()
            ->route('notification.index')
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
            ->route('notification.index')->with('status', 'User has been deleted successfully');
    }
	
    
    // mark as read notification for user
    public function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }
}
