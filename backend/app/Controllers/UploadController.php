<?php

namespace App\Controllers;

use Core\BaseController;
use Middleware\Security;
use App\Models\UploadModel;

class UploadController extends BaseController
{
    const MAX_FILE_SIZE = 10485760; // 10 MB

    private $uploadModel;

    public function __construct()
    {
        $this->uploadModel = new UploadModel();
    }


    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->jsonResponse(['error' => 'Method not allowed'], 405);
        }

        if (isset($_FILES['file']) && isset($_POST['user_id'])) {
            $userId = $_POST['user_id'];
            $file = $_FILES['file'];

            $validationResult = Security::validatePdfFormat($file);
            if ($validationResult !== true) {
                return $this->jsonResponse($validationResult, 400);
            }

            $uploadDir = __DIR__ . '/../../public/storage/';

            $fileName = uniqid() . '_' . basename($file['name']);
            $uploadPath = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                
                $insertResult = $this->uploadModel->insertUpload($userId, $fileName);

                if ($insertResult) {
                    return $this->jsonResponse(['message' => 'File uploaded successfully']);
                } else {
                    unlink($uploadPath); 
                    return $this->jsonResponse(['error' => 'Failed to save file details'], 500);
                }
            } else {
                return $this->jsonResponse(['error' => 'Error uploading file'], 500);
            }
        } else {
            return $this->jsonResponse(['error' => 'Invalid request parameters'], 400);
        }
    }

    public function getAllCvsAction()
    {
        $cvs = $this->uploadModel->getAllCvsWithUserDetails();
        if (!$cvs) {
            return $this->jsonResponse(['error' => 'CVs not found'], 404);
        }
        return $this->jsonResponse($cvs);
    }

    public function getCountOfCVs()
    {
        $count = $this->uploadModel->getCVsCount();

        return $this->jsonResponse(['count' => $count]);
    }

    public function download()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->jsonResponse(['error' => 'Method not allowed'], 405);
        }

        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true);

        if (!isset($data['filename'])) {
            return $this->jsonResponse(['error' => 'Filename is required'], 400);
        }

        $fileName = $data['filename'];

        $fileDetails = $this->uploadModel->getFileByFileName($fileName);

        if (!$fileDetails) {
            return $this->jsonResponse(['error' => 'File not found'], 404);
        }

        $filePath = __DIR__ . '/../../public/storage/' . $fileDetails['file'];

        if (!file_exists($filePath)) {
            return $this->jsonResponse(['error' => 'File not found on server'], 404);
        }

        if (ob_get_length()) {
            ob_end_clean();
        }

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        readfile($filePath);
        exit;
    }
}
