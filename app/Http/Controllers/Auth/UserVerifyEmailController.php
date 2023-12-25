<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

class UserVerifyEmailController extends Controller
{
  public function __invoke($id, $hash)
  {
    $user = User::findOrFail($id);

    if ($user->hasVerifiedEmail()) {
      return redirect()->route('login')->with('success', 'Email already verified');
    }

    if ($user->markEmailAsVerified()) {
      event(new Verified($user));
    }

    return redirect()->route('login')->with('success', 'Email verified');
  }
}
