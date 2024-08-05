<?php

namespace App\Helpers;

class MediaHelper
{
    // Upload image on local system project folder
    public function uploadImage($file) 
    {
        // Handle the file upload
        $extension = $file->getClientOriginalExtension();
        // Generate a unique name for the file
        $uniqueName = time() . '-' . uniqid() . '.' . $extension;
        // Define the directory path
        $directoryPath = public_path('images');

        // Check if the directory exists, and create it if it does not
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }
        // Move the file to the 'public/images' directory
        $file->move($directoryPath, $uniqueName);
        // Return the file path relative to the public path
        return $uniqueName;
    }
}
