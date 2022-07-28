<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|regex:/^[a-z A-Z.-]+$/',
                'phone' => 'required|digits:11|unique:users,phone',
                'email' => 'required|email|unique:users,email',       
                'verification' => 'required',                                
                'password' => 'required|min:3',                   
                'address' => 'required',
            ]
        );

        return User::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
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
        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (User::destroy($id))
        {
            return "Deleted!";
        }
        else{
            return "No user to delete!";
        }
    }

    
    public function search($name)
    {
        $formatted = '%'.implode('%',str_split($name)).'%'; 
        // return $formatted;
        $users = User::where('name', 'like', $formatted)
        ->orWhere('phone', 'like', $formatted)
        ->orWhere('email', 'like', $formatted)
        ->orWhere('address', 'like', $formatted)
        ->get();
        return $users;
    }
}
