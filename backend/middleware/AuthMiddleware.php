<?php

namespace Middleware;

use Core\JWTHandler;

class AuthMiddleware {
    public static function handle() 
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $matches = [];
            if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
                $token = $matches[1];
                $decoded = JWTHandler::decodeToken($token);
                if ($decoded) {
                    return $decoded;
                }
            }
        }
        
        http_response_code(401);
        echo json_encode(['message' => 'Unauthorized']);
        exit;
    }
}
