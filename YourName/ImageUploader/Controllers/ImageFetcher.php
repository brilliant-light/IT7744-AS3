<?php namespace YourName\ImageUploader\Controllers;

use YourName\ImageUploader\Models\Image;
use RainLab\User\Facades\Auth;

class ImageFetcher
{
    // Fetch user's own images
    public function fetchUserImages()
    {
        $user = Auth::getUser();
        return Image::where('user_id', $user->id)->get();
    }

    // Fetch images from other users
    public function fetchOtherUsersImages()
    {
        $user = Auth::getUser();
        return Image::where('user_id', '!=', $user->id)->get();
    }

    // Fetch the latest images
    public function fetchLatestImages()
    {
        return Image::orderBy('created_at', 'desc')->take(10)->get(); // Fetch the latest 10 images
    }
}
