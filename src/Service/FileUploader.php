<?php
// src/Service/FileUploader.php
namespace App\Service;

use App\Repository\FileRepository;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file,FileRepository $fileRepository)
    {
        $hands = $this->readHandsFile($file);
        $fileName = $file->getFilename();
        
        $fileRepository->saveUploadedFile($fileName,$hands);
        var_dump($hands);
        die();
    }


    private function readHandsFile(UploadedFile $file):array{
        $result = array();

        $uploadedHandsFile = fopen($file->getPathname(), "r") or die("Unable to open file!");
        while(!feof($uploadedHandsFile)) {
            $line = fgets($uploadedHandsFile);
            $cardsInLine = explode(' ',$line);
            $result[] = $cardsInLine;
        }
        
        fclose($uploadedHandsFile);
        
        return $result;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}