<?php namespace yourname\imageuploader\components;

use Cms\Classes\ComponentBase;
use Input;
use Validator;
use ValidationException;
use System\Models\File;

class ImageUploader extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Image Uploader',
            'description' => 'Allows users to upload images'
        ];
    }

    public function onUploadImage()
    {
        // Get the uploaded file
        $uploadedFile = Input::file('image');

        // Validation rules for the image
        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max size 2MB
        ];

        // Validate the image file
        $validator = Validator::make(['image' => $uploadedFile], $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Create a new file record and save the uploaded file
        $file = new File();
        $file->fromPost($uploadedFile);
        $file->save();

        // Return the file path or URL for use in the frontend
        return ['#result' => '<p>Image uploaded successfully: <img src="' . $file->getPath() . '" /></p>'];
    }
}
