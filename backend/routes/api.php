<?php

use Core\Router;
use App\Controllers\LoginController;
use App\Controllers\UserController;
use App\Controllers\UploadController;
use App\Controllers\RegisterController;


$router = new Router();

$router->post('/api/login/', [LoginController::class, 'login']);
$router->get('/api/users/details/', [UserController::class, 'getUserDetails']);
$router->get('/api/users/', [UserController::class, 'getAllUsers']);
$router->post('/api/upload/', [UploadController::class, 'upload']);
$router->get('/api/getAllCvs/', [UploadController::class, 'getAllCvsAction']);
$router->post('/api/download/', [UploadController::class, 'download']);
$router->post('/api/register/', [RegisterController::class, 'register']);
$router->get('/api/getCvCount/', [UploadController::class, 'getCountOfCVs']);
$router->get('/api/userCount/', [UserController::class, 'getUserCount']);



$router->dispatch();
