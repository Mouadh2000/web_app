<?php

namespace Middleware;

class Security
{
    const MAX_FILE_SIZE = 10485760; // 10 MB

    public static function validatePdfFormat($file)
    {
        // Check file size
        if ($file['size'] > self::MAX_FILE_SIZE) {
            return ['error' => 'File size exceeds the limit'];
        }

        // Check file type using magic bytes
        if (!self::isValidPdfFile($file['tmp_name'])) {
            return ['error' => 'Invalid file format. Only PDF files are allowed.'];
        }

        return true;
    }

    private static function isValidPdfFile($filePath)
    {
        // Read the first few bytes of the file
        $file = fopen($filePath, 'rb');
        $bytes = fread($file, 4);
        fclose($file);

        // Check if the file signature matches PDF (ASCII values: %PDF)
        return strpos($bytes, '%PDF') === 0;
    }
}
