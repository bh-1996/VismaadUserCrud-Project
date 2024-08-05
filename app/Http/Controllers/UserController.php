<?php

namespace App\Http\Controllers;

use App\Helpers\MediaHelper;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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

    public function users(){
        $users = User::all();

        return view('user.index',compact('users'));
    }
    

    public function profile(Request $request)
    {
        // Get the authenticated user
        $id = Crypt::decryptString($request->id);
        $user = User::findOrFail($id);

        // Return the profile view with user data
        return view('user.profile', compact('user'));
    }

    public function editProfile(Request $request)
    {
        $id = Crypt::decryptString($request->id);
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $id = Crypt::decryptString($request->id);
        $user = User::findOrFail($id);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            return redirect()->route('editProfile', ['id' => Crypt::encryptString($user->id)])->withErrors($validator)->withInput();
        }

        try {
            $imagePath = $user->image;
            if ($request->hasFile('image')) {
                $path = public_path('images/');
                // Delete old image if it exists
                if ($user->image && file_exists($path . $user->image)) {
                    unlink($path . $user->image);
                }
                // Upload new image
                $image = $request->file('image');
                $imagePath = $this->imageUpload->uploadImage($image, 'images');
            }

            // Update user details
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'image' => $imagePath,
            ]);

            return redirect()->route('profile', ['id' => Crypt::encryptString($user->id)])->with('success', 'Profile updated successfully.');

        } catch (Exception $e) {
            // Log the exception and return an error response
            Log::error('Profile update failed: ' . $e->getMessage());
            return redirect()->route('editProfile', ['id' => Crypt::encryptString($user->id)])->withErrors(['error' => 'An error occurred while updating the profile.'.$e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        $id = Crypt::decryptString($request->product_id);
        $user = User::findOrFail($id);
        dd($user);
        try {
            // Delete the user's image file if it exists
            $imagePath = public_path('images/' . $user->image);
            if ($user->image && file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Delete the user record
            $user->delete();

            // Redirect to the login page with a success message
            return redirect()->back()->with('success', 'Account deleted successfully.');
            
        } catch (Exception $e) {
            // Log the exception and return an error response
            Log::error('User deletion failed: ' . $e->getMessage());
            return redirect()->route('profile', ['id' => Crypt::encryptString($user->id)])->withErrors(['error' => 'An error occurred while deleting the account.']);
        }
    }

}
