<?php

declare(strict_types=1);

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\LoginActivity;
use App\Services\Admin\NotificationService; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class AdminAuthController extends Controller
{


    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService){
        $this->notificationService = $notificationService;
    }


    public function showLogin(){
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !$admin->status) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'email' => ['Account is inactive or not found.'],
                ],
            ], 403);
        }

        if (!Hash::check($request->password, $admin->password)) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'password' => ['Incorrect password.'],
                ],
            ], 401);
        }

        Auth::guard('admin')->login($admin, $request->boolean('remember'));
        $request->session()->regenerate();
        LoginActivity::recordLogin($admin, $request);

        $admin->update(['last_login_at' => now()]);

        $this->notificationService->sendLoginAlert($admin, $request->ip(), $request->userAgent());

        return response()->json([
            'success' => true,
            'message' => 'Login successful!',
            'redirect' => route('admin.dashboard'),
        ]);
    }


    public function logout(Request $request){
         LoginActivity::where('admin_id', Auth::guard('admin')->id())
        ->whereNull('logout_at')
        ->latest('login_at')
        ->first()
        ?->update(['logout_at' => now()]);
        
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }


    public function showProfile(){
        return view('admin.profile.update_profile', [
            'admin' => Auth::guard('admin')->user(),
        ]);
    }

 
    public function updateProfile(Request $request){
        $admin = Auth::guard('admin')->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('image')) {
            if ($admin->image) {
                Storage::disk('public')->delete($admin->image);
            }

            $data['image'] = $request->file('image')->store('admin-avatars', 'public');
        }

        $admin->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated!',
            'data' => $admin->fresh(),
        ]);
    }

  
    public function showChangePassword(){
        return view('admin.profile.update_password', [
            'admin' => Auth::guard('admin')->user(),
        ]);
    }

  
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'current_password:admin'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $admin = Auth::guard('admin')->user();
        $admin->update(['password' => Hash::make($request->password)]);
        $this->notificationService->sendPasswordChangedEmail($admin);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully!',
        ]);
    }
}