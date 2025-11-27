<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class EmailJsPasswordResetController extends Controller
{
    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Return success even if user not found (security best practice)
            return response()->json([
                'success' => true,
                'message' => 'If that email exists, a reset code has been sent.'
            ]);
        }

        // Generate 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Delete old codes for this email
        DB::table('password_reset_codes')
            ->where('email', $request->email)
            ->delete();

        // Store new code (expires in 15 minutes)
        DB::table('password_reset_codes')->insert([
            'email' => $request->email,
            'code' => $code,
            'expires_at' => now()->addMinutes(15),
            'created_at' => now()
        ]);

        // Return data for EmailJS to send
        return response()->json([
            'success' => true,
            'to_email' => $request->email,
            'user_name' => $user->name,
            'reset_code' => $code,
        ]);
    }

    public function verifyCodeAndReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Check if code exists and is valid
        $resetCode = DB::table('password_reset_codes')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$resetCode) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired code.'
            ], 400);
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            // Delete used code
            DB::table('password_reset_codes')
                ->where('email', $request->email)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not found.'
        ], 404);
    }
}
