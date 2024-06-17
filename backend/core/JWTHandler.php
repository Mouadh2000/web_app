<?php

namespace Core;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHandler {
    private static $secret_key = 'your_secret_key';
    private static $refresh_key = 'your_refresh_key';
    private static $algorithm = 'HS256'; 

    public static function generateAccessToken($data) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  
        $payload = array(
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $data
        );
        return JWT::encode($payload, self::$secret_key, self::$algorithm); 
    }

    public static function generateRefreshToken($data) {
        $issuedAt = time();
        $expirationTime = $issuedAt + (7 * 24 * 3600);  
        $payload = array(
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $data
        );
        return JWT::encode($payload, self::$refresh_key, self::$algorithm); 
    }

    public static function decodeToken($token) {
        try {
            return JWT::decode($token, new Key(self::$secret_key, self::$algorithm)); 
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function decodeRefreshToken($token) {
        try {
            return JWT::decode($token, new Key(self::$refresh_key, self::$algorithm)); 
        } catch (\Exception $e) {
            return null;
        }
    }
}
