<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Department name mapping
    private $departmentNames = [
        'CS' => 'Computer Science',
        'IT' => 'Information Technology',
        'CDF' => 'Costume Design & Fashion',
        'CA' => 'Computer Application',
        'ENG' => 'English',
        'COM' => 'Commerce',
        'COM(pa)' => 'Commerce Professional Accounting',
        'COM(ba)' => 'Business Analytics',
        'BBA' => 'Business Administration',
        'STAT' => 'Statistics',
        'ELEC' => 'Electronics',
    ];

    // Show the password change form
    public function showPasswordForm()
    {
        return view('pass.change-password');  // Adjust this to your actual path if necessary
    }

    // Handle the password change process
    public function updatePassword(Request $request)
    {
        // Log form data for debugging
        \Log::info('Form submitted', $request->all());

        // Validate the incoming request
        $request->validate([
            'user_type' => 'required|in:hod,staff,security',  // Validate user type
            'department' => 'nullable|in:CS,IT,CDF,CA,ENG,COM,COM(pa),COM(ba),BBA,STAT,ELEC',  // Validate department options
            'new_password' => 'required|min:6|confirmed|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/', // Password validation
        ]);

        // Get the user type and department (for HOD)
        $userType = $request->input('user_type');
        $department = $request->input('department');  // Department is passed directly from the form
        $user = null;

        // Check if the user is HOD and validate department
        if ($userType === 'hod' && $request->has('department')) {
            $user = User::where('user_type', 'hod')
                        ->where('department', $department)
                        ->first();
        } else {
            // For staff and security, just find by user type
            $user = User::where('user_type', $userType)->first();
        }

        // If no user found, create a new user (if that's your requirement)
        if (!$user) {
            // Create a new user, department will be null for staff and security
            $user = User::create([
                'user_type' => $userType,
                'department' => $userType === 'hod' ? $department : null,  // Only HOD gets a department
                'password' => Hash::make($request->input('new_password')),  // Hash the password
            ]);

            // Return a success message
            return redirect()->route('change-password')->with('success', 'New user created and password updated successfully.');
        }

        // Update the existing user's password if found
        $user->password = Hash::make($request->input('new_password'));  // Hash and update the password
        
        // Only update department for HOD if provided
        if ($userType === 'hod' && $request->has('department')) {
            $user->department = $department;
        }

        // Save the user data
        $user->save();

        // Redirect with success message
        return redirect()->route('change-password')->with('success', 'Password updated successfully.');
    }

    // Get user details with full department name and password
    public function getUserDetails(Request $request)
    {
        // Authentication check (API version)
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401); // Unauthorized
        }

        // If user is authenticated, fetch the user details
        return response()->json([
            'user_type' => $user->user_type,
            'department' => $user->getDepartmentNameAttribute(), // Assuming you have a getDepartmentNameAttribute in the model
            // Note: Do NOT return passwords in production
            // For debugging purposes, it's shown here, but avoid in live applications
            'password' => '********',  // For security purposes, do not expose passwords
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString(),
        ]);
    }
}
