<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\user;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $req): JsonResponse
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|string|min:8',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return ApiResponse::error('Validation Error', $validator->errors());
        }

        $profileImage = null;
        if ($req->hasFile('profile')) {
            $image = $req->file('profile');
            $profileImage = $image->storeAs('public/profile', $image->hashName());

        }

        $user = new User([
            'name' => $req->get('name'),
            'email' => $req->get('email'),
            'password' => Hash::make($req->get('password')),
            'profile' => $profileImage
        ]);
        if ($user->save()) {
            return ApiResponse::success($user, 'User registered successfully');
        } else {
            return ApiResponse::error('Error When Register A user');
        }
    }

    public function edit(Request $request): JsonResponse
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|min:3',
            'email' => 'nullable|exists:users,email',
            'password' => 'nullable|string|min:5',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation Error', $validator->errors());
        }

        $user->update($request->only('name', 'email', 'password'));


        if ($request->hasFile('profile')) {
            if ($user->profile != null) {
                Storage::delete($user->profile);
            }

            $image = $request->file('profile');
            $profileImage = $image->storeAs('public/profile', $image->hashName());
            $user->profile = $profileImage;
        }
        $user->save();

        return ApiResponse::success($user, 'User updated successfully');
    }


    public function logout(Request $req): JsonResponse
    {
        $req->user()->currentAccessToken()->delete();

        return ApiResponse::success(null, 'Logged out successfully');
    }

    public function login(Request $req): JsonResponse
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return ApiResponse::error('Validation Error', $validator->errors(), 422);
        }

        $credentials = $req->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::where('id', Auth::user()->id)->first();
            $token = $user->createToken('user-token')->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => 'login successfully',
                'data' => $user,
                'token' => $token,
            ]);
        } else {
            return ApiResponse::error('Unauthorized email or password wrong', [], 401);
        }
    }

    public function show($id = null): JsonResponse
    {
        if ($id === null) {
            $authUser = auth()->user();

            if (!$authUser) {
                return ApiResponse::error('Unauthorized', [], 401);
            }

            $user = User::with('reviews')->find($authUser->id);

        } else {
            $user = User::with('reviews')->find($id);

        }
        if (!$user) {
            return ApiResponse::error('User not found');
        }
        return ApiResponse::success($user, 'Success get user profile with reviewed destinations');
    }
}
