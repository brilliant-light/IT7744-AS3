<?php namespace YourName\ImageUploader\Controllers;

use YourName\ImageUploader\Models\Image;
use Illuminate\Http\Request;

class ImageController
{
    public function getUserImages(Request $request)
    {
        // Validate the user input (if applicable)
        $request->validate([
            'user_id' => 'integer|exists:users,id',  // Example validation if filtering by user
        ]);

        // Fetch the user's images, ensuring proper sanitization
        $images = Image::where('user_id', $request->user()->id)->get();

        // Return JSON response
        return response()->json($images);
    }

    public function getOtherUsersImages(Request $request)
    {
        // Fetch images from other users
        $images = Image::where('user_id', '!=', $request->user()->id)->get();

        return response()->json($images);
    }

    public function getLatestImages(Request $request)
    {
        // Fetch the latest uploaded images (limit to a certain number)
        $images = Image::orderBy('created_at', 'desc')->take(20)->get();  // Limit to 20 latest images

        return response()->json($images);
    }
}
