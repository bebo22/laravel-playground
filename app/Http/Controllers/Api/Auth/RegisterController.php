<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
  public function store(Request $request)
  {
    $rules = [
      'name' => ['required', 'string', 'max:255'],
      'first_name' => ['required', 'string', 'max:255'],
      'last_name' => ['required', 'string', 'max:255'],
      'phone' => ['nullable', 'string', 'max:255'],
      'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ];
    $validator = validator($request->all(), $rules);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors' => $validator->errors()
      ], 422);
    }

    $user = User::create([
      'name' => $request->name,
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email' => $request->email,
      'phone' => $request->phone ?? null,
      'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    return response()->json([
      'message' => 'User created successfully',
      'user' => $user
    ], 201);
  }
}
