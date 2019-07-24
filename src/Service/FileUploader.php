<?php

namespace App\Service;

use Doctrine\Migrations\Tools\Console\Exception\DirectoryDoesNotExist;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Filesystem\Filesystem;
use App\Service\Toolbox;


class FileUploader
{
    private $targetDirectory;
    private $toolbox;

    public function __construct($targetDirectory, Toolbox $toolbox)
    {
        $this->targetDirectory = $targetDirectory;
        $this->toolbox = $toolbox;
    }

    public function upload(UploadedFile $file, $directoryhandler)
    {
        $fileName = $file->getClientOriginalName();
        try {
//            $file->move($this->getTargetDirectory(), $fileName);
            $file->move($directoryhandler, $fileName);

        } catch (FileException $e) {

            // ... handle exception if something happens during file upload
            if ($e instanceof RequestExceptionInterface) {
                $e = new BadRequestHttpException($e->getMessage(), $e);
            }
        }
        return $fileName;
    }

    /**
     * @param string $artistbandName
     * @param array $directory
     * @param string $project
     * @return bool|null|string
     */
    public function directoryHandler(string $artistbandName, Array $directory, string $project = null)
    {
        $filesystem = new Filesystem();
        $response = null;

        $projectdir = isset($project) ? '/' . $this->toolbox->formatString($project) : null;
        $filepath = $this->getTargetDirectory() . '/' . $this->toolbox->formatString($artistbandName) . $projectdir . '/' . $directory[0];

        try {
            if (!is_dir($filepath)) {
                $filesystem->mkdir($filepath, 0777);

                $response = $filepath;
            }
        } catch (DirectoryDoesNotExist $e) {

            echo "An error occurred while creating your directory at " . $e->getMessage();
            $response = false;
        }
        return $response;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}