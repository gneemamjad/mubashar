<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function show()
    {
        $title = "My Profile";
        return view('admin.profile.show',compact('title'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => 'nullable|min:6|confirmed',
        ]);
        
        $this->adminService->updateProfile(auth()->guard('admin')->user()->id, $request->all());

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
} 