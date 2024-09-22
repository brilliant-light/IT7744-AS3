Route::get('user/images', 'YourName\ImageUploader\Controllers\ImageFetcher@fetchUserImages');
Route::get('other-users/images', 'YourName\ImageUploader\Controllers\ImageFetcher@fetchOtherUsersImages');
Route::get('latest/images', 'YourName\ImageUploader\Controllers\ImageFetcher@fetchLatestImages');
