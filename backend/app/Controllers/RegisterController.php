<?php

namespace App\Controllers;

use App\Models\UserModel;
use Core\BaseController;

class RegisterController extends BaseController 
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function register()
    {
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true);
        if (!isset($data['first_name']) || !isset($data['last_name']) || !isset($data['email']) || !isset($data['password'])) {
            return $this->jsonResponse(['error' => 'All fields are required.'], 400);
        }

        $firstName = $data['first_name'];
        $lastName = $data['last_name'];
        $email = $data['email'];
        $password = $data['password'];

        // Register the user
        $registrationResult = $this->userModel->getRegistration($firstName, $lastName, $email, $password);

        if ($registrationResult) {
            return $this->jsonResponse(['message' => 'User registered successfully.']);
        } else {
            return $this->jsonResponse(['error' => 'Failed to register user.'], 500);
        }
    }
}
