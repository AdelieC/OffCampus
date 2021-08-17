<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader
{
    private string $targetDirectory;

    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file, string $baseForName): ?string
    {
        // TODO : check file size!
        try {
            $newFileName = $this->getSafeFileName($file, $baseForName);

            // Deleting existing file with the same name
            if(file_exists($this->targetDirectory.'/'.$newFileName)) {
                unlink($this->targetDirectory.'/'.$newFileName);
            }

            $file->move($this->targetDirectory, $newFileName);
            return $newFileName;
        } catch (FileException $e) {
            return null;
        }
    }

    public function getSafeFileName(UploadedFile $file, string $baseForName): string
    {
        // TODO : check if extension is an image extension
        $newImageName = preg_replace("/[^a-z1-9]/", '-', strtolower($baseForName));
        return $newImageName.'.'.$file->guessExtension();
    }
}