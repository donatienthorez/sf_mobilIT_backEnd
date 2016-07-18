<?php

namespace MainBundle\Service;

class UploadService
{

  public function deleteFile($filePath){
    if (file_exists($filePath)) {
      unlink($filePath);
    }
  }

  public function uploadFile($file, $fileName, $filePath) {
    $file->move($filePath, $fileName);
  }

}
