<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UsersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')->get();
        return view('users.index',compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create')->with('isUpdate',false);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $admin = $request->input('admin')==1 ? 1 : 2;
        $role = $request->input('department') . $admin;
        $fullname = $request->input('fullname');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $active = $request->input('active');
        $description = $request->input('description');
        DB::table('users')->insert([
            'userName' => $username,
            'password' => $password,
            'role' => $role,
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'active' => $active,
            'description' => $description
        ]);
        if($request->all()){
            return redirect()->route('users.index')->with('success',"Created new user successfully!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = DB::table('users')->where(['userID'=>$id])->first();
        return view('users.create')->with([
            'isUpdate' => 'Profile',
            'users' => $users
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = DB::table('users')
            ->where(['userID'=>$id])->first();
        return view('users.create')->with([
            'isUpdate' => 'Update',
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request)
    {
        $userID = $request->input('userID');
        $username = $request->input('username');
        $admin = $request->input('admin')==1 ? 1 : 2;
        $role = $request->input('department') . $admin;
        $fullname = $request->input('fullname');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $active = $request->input('active');
        $description = $request->input('description');
        DB::table('users')
        ->where('userID', intval($userID))
        ->update([
            'userName' => $username,
            'role' => $role,
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'active' => $active,
            'description' => $description
        ]);
        if($request->all()){
            return redirect()->route('users.index')->with('success',"Update user successfully!");
        }
    }

    public function updatePassword(ChangePasswordRequest $request, $id)
    {
        // $this->validate($request, [
        //     'oldPassword' => 'required',
        //     'password' => 'required|confirmed|min:6',
        //     'password_confirmation' => 'min:6'
        // ]);
        $oldPassword = $request->input('oldPassword');
        $password = $request->input('password');

        $users = DB::table('users')->where('userID', intval($id));
        if($oldPassword == $users->first()->password){
            $users->update(['password' => $password]);
        }else{
            return back()->withInput()->withErrors("Wrong old password! Please input old password again!");
        }
        if($request->all()){
            return redirect()->route('users.index')->with('success',"Update user successfully!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('users')->where('userID', intval($id))->delete();
        return redirect()->route('users.index')->with('success',"Delete user successfully!");
    }
}
