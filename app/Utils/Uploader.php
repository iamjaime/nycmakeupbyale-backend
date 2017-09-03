<?php

namespace App\Utils;

use Illuminate\Http\UploadedFile;


trait Uploader
{
    private function getFileExtension(UploadedFile $file)
    {
        return $file->getClientOriginalExtension();
    }

    private function getFileMimeType(UploadedFile $file)
    {
        // return $file->getMimeType();
        return \File::mimeType($file);
    }

    private function getRandomFileName($file)
    {
        return $this->generateGuid() . '.' . $this->getFileExtension($file);
    }

    private function getImageStoragePath($file, $directory=null)
    {
        if(!$directory){
            return $this->getRandomFileName($file);
        }
        return $directory . '/' . $this->getRandomFileName($file);
    }

    public function uploadFile($file, $directory=null)
    {
        $fileName = $this->getImageStoragePath($file, $directory);
        $s3 = \Storage::disk('s3');
        $s3->getDriver()->put($fileName, fopen($file, 'r+'), ['ContentType' => $this->getFileMimeType($file)]);

        return $s3->url($fileName);
    }

    public function generateGuid() {

        $s = strtoupper(md5(uniqid(rand(),true)));
        $guidText =
            substr($s,0,8) . '-' .
            substr($s,8,4) . '-' .
            substr($s,12,4). '-' .
            substr($s,16,4). '-' .
            substr($s,20) . '-' . time();

        return $guidText;
    }
}
