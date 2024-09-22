<?php namespace yourname\contentmanager\controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;
use Flash;
use ValidationException;
use yourname\contentmanager\models\user;

class Registration extends Controller
{
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('YourName.ContentManager', 'main-menu-item');
    }

    public function onRegister()
    {
        $data = post();

        // Validate input
        $this->validateRegistration($data);

        // Create user
        $user = new User;
        $user->fill($data);
        $user->password = bcrypt($data['password']); // Hash the password
        $user->save();

        Flash::success('User registered successfully!');
        return redirect('your-redirect-url'); // Change to your desired URL
    }

    protected function validateRegistration($data)
    {
        $rules = [
            'email' => 'required|email|unique:backend_users',
            'login' => 'required|unique:backend_users',
            'password' => 'required|confirmed|min:6',
        ];

        $validator = validator($data, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
