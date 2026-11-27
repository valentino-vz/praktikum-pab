<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;

//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        // tanpa pagging
        $posts = User::all();

        // response sesuai format API RESOURCE (status, message, data)
        return new PostResource(true, 'List Data Posts', $posts);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'         => 'required',
            'email'        => 'required',
            'password'     => 'required',
            'address'      => 'required',
            'house_number' => 'required',
            'phone_number' => 'required',
            'city'         => 'required',
            'roles'        => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create user
        $post = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => $request->password,
            'address'      => $request->address,
            'house_number' => $request->house_number,
            'phone_number' => $request->phone_number,
            'city'         => $request->city,
            'roles'        => $request->roles,
        ]);

        //return response
        return new PostResource(true, 'Data Post Berhasil Ditambahkan.', $post);
        
    }
    
    public function show($id)
    {
        //find user by ID
        $post = User::find($id);

        //return single post as a resource
        return new PostResource(true, 'Detail Data Post', $post);
    }
    
    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'         => 'required',
            'email'        => 'required',
            'password'     => 'required',
            'address'      => 'required',
            'house_number' => 'required',
            'phone_number' => 'required',
            'city'         => 'required',
            'roles'        => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find user by ID
        $post = User::find($id);
        $post->update([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => $request->password,
            'address'      => $request->address,
            'house_number' => $request->house_number,
            'phone_number' => $request->phone_number,
            'city'         => $request->city,
            'roles'        => $request->roles,
        ]);

        //return response
        return new PostResource(true, 'Data Post Berhasil Diubah!', $post);
    }
    
    public function destroy($id)
    {
        //find post by ID
        $post = User::find($id);
        $post->delete();

        //return response
        return new PostResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}