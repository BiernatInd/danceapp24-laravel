<?php

namespace App\Http\Controllers\Main\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewSchool;


class SchoolController extends Controller
{
    public function newSchool(Request $request) {
        $validatedData = $request->validate([
          'user_name' => 'required|max:255',
          'email' => 'required|email|max:255|unique:users',
          'role' => 'required',
        ]);
      
        $password = Str::random(10);
      
        $user = User::create([
            'user_name' => $validatedData['user_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($password),
            'role' => $validatedData['role'],
            'created_at' => $now = Carbon::now(),
            'updated_at' => $now,
            'update_role' => $now->copy()->addDays(30),
          ]);
      
          Mail::to($user->email)->send(new NewSchool($user, $password));
      
          return response()->json(['password' => $password]);
      }
}
