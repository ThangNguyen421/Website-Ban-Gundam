<?php
function handleFileUpload(array $fileInfo, string $targetDir, array $allowedTypes, int $maxSize = 5000000) {
    if ($fileInfo['error'] !== UPLOAD_ERR_OK) {
        return false; 
    }

    if ($fileInfo['size'] > $maxSize) {
        return false;
    }
    
    $validExtensions = [
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'gif'  => 'image/gif'
    ];
    
    $extension = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);
    $extension = strtolower($extension);
    
    $fileMimeType = $validExtensions[$extension] ?? null;

    if (!in_array($fileMimeType, $allowedTypes)) {
        return false; 
    }
    $newFileName = uniqid('gundam_') . '_' . time() . '.' . $extension;
    $targetPath = $targetDir . $newFileName;

    if (!move_uploaded_file($fileInfo['tmp_name'], $targetPath)) {
        return false;
    }

    return $newFileName;
}
?>
