<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception; // Import the Exception class
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /** The MediaHelper instance for handling image uploads. */
    private $imageUpload;

    /**
     * Create a new controller instance.
     */
    public function __construct(MediaHelper $imageUpload)
    {
        $this->imageUpload = $imageUpload;
    }

    public function showLoginForm()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        // dd($request->all());
        try {
            $credentials = $request->only('email', 'password');
    
            if (Auth::attempt($credentials)) {
                // Successful login
                return redirect()->route('profile')->with('success', 'Successfully logged in!');
            }
    
            // Invalid credentials
            return redirect()->route('showLoginForm')->withErrors(['email' => 'Invalid credentials']);
        } catch (Exception $e) {
            // Log the exception and return an error response
            Log::error('Login failed: ' . $e->getMessage());
            return redirect()->route('showLoginForm')->withErrors(['email' => 'An error occurred during login: '. $e->getMessage()]);
        }
    }

    public function showRegistrationForm()
    {
        return view('user.register');
    }

    public function register(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'nullable|string|max:15',
                'address' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $this->imageUpload->uploadImage($image, 'images');
            }

            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'image' => $imagePath,
            ]);

            return redirect()->route('showLoginForm')->with('success', 'Registration successful. Please log in.');
        } catch (Exception $e) {
            // Log the exception and return an error response
            Log::error('Registration failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['registration' => 'An error occurred during registration: '.$e->getMessage()])->withInput();
        }
    }


    public function logout()
    {
        try {
            Auth::logout();
            return redirect()->route('showLoginForm');
        } catch (Exception $e) {
            // Log the exception and return an error response
            Log::error('Logout failed: ' . $e->getMessage());
            return redirect()->route('showLoginForm')->withErrors(['logout' => 'An error occurred during logout']);
        }
    }
}
