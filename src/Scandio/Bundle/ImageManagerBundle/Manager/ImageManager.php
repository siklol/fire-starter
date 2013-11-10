<?php
namespace Scandio\Bundle\ImageManagerBundle\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Validator;

class ImageManager
{
    private $imageDir;
    private $documentRoot;

    /**
     * @var Validator
     */
    private $validator;

    public function __construct($imageDir, $documentRoot, Validator $validator)
    {
        $this->imageDir = $imageDir;
        $this->validator = $validator;
        $this->documentRoot = $documentRoot;

        if (!is_dir($imageDir)) {
            @mkdir($imageDir, 0777, true);
        }

        if (!is_dir($imageDir)) {
            throw new \Exception(sprintf("Image Dir could not be created: %s", $imageDir));
        }
    }

    /**
     * @param UploadedFile $file
     * @return string
     * @throws \Exception
     */
    public function upload(UploadedFile $file)
    {
        $path = null;

        $fileConstraint = new File();
        $fileConstraint->maxSize = '5000k';
        $errors = $this->validator->validateValue($file, $fileConstraint);

        if (count($errors) > 0) {
            throw new \Exception("Could not upload image file. Please check your image file");
        }

        $fileName = md5($file->getClientOriginalName().uniqid()).'.'.$file->guessClientExtension();

        $file->move($this->imageDir, $fileName);

        return $this->documentRoot.'/'.$fileName;
    }

    /**
     * @param $imageName
     */
    public function removeImage($imageName)
    {
        if (is_file($this->imageDir.'/'.$imageName)) {
            unlink($this->imageDir.'/'.$imageName);
        }
    }
}