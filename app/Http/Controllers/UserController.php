<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    function StoreUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'mobile' => 'required|unique:users',
            'password' => 'required|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);
        if ($user) {
            return response()->json([
                'data' => $user,
                'status' => 201,
                'message' => 'User created successfull'
            ]);
        } else {
            return response()->json([
                'data' => $user,
                'status' => 500,
                'message' => 'User creation failed'
            ]);
        }
    }

    public function AllUser()
    {
        $users = User::get();
        return response()->json(['data' => $users, 200]);
    }
    public function UpdateUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' =>
            [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'mobile' =>
            [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'password' => 'required|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json([$validator->messages(), 401]);
        }

        $data = User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'user updated successfully'
        ]);
    }
    public function DeleteUser($id)
    {
        $user = User::find($id);
        $response = $user->delete();
        if ($response) {
            return response()->json([
                'status' => 201,
                'message' => 'user deleted successfully',
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'user not deleted',
            ]);
        }
    }
}
