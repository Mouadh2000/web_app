<?php

namespace App\Controllers;

use App\Models\UserModel;
use Core\BaseController;
use Core\JWTHandler;

class LoginController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        $rawInput = file_get_contents('php://input');
        
        $data = json_decode($rawInput, true);
        if (!isset($data['email']) || !isset($data['password'])) {
            $this->jsonResponse(['error' => 'Email and password are required.'], 400);
        }

        $email = $data['email'];
        $password = $data['password'];

        $user = $this->getUserFromDatabase($email, $password);

        if ($user) {
            $userId = $user;

            $accessToken = JWTHandler::generateAccessToken(['user_id' => $userId]);
            $refreshToken = JWTHandler::generateRefreshToken(['user_id' => $userId]);

            $this->jsonResponse([
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken
            ]);
        } else {
            $this->jsonResponse(['error' => 'Invalid email or password.'], 401);
        }
    }

    private function getUserFromDatabase($email, $password)
    {
        return $this->userModel->checkLogin($email, $password);
    }
}
