<?php

namespace App\Controllers;

use Core\BaseController;
use Middleware\AuthMiddleware;
use App\Models\UserModel;

class UserController extends BaseController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function getUserDetails() {
        // Use AuthMiddleware to check authentication
        $decoded = AuthMiddleware::handle();
        // Ensure decoded token contains expected structure
        if (!isset($decoded->data->user_id)) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid token structure']);
            exit;
        }

        // If authenticated, get user details
        $userId = $decoded->data->user_id;
        $user = $this->userModel->getUserById($userId);

        if (!$user) {
            return $this->jsonResponse(['error' => 'User not found'], 404);
        }

        return $this->jsonResponse($user);
    }

    public function getAllUsers()
    {
        $users = $this->userModel->getUsers();
        if (!$users) {
            return $this->jsonResponse(['error' => 'users not found'], 404);
        }
        return $this->jsonResponse($users);
    }
    public function getUserCount()
    {
        $count = $this->userModel->userCount();

        return $this->jsonResponse(['count' => $count]);
    }
}
