<?php

declare(strict_types=1);

namespace App\Support;

final class FileUploader
{
    /**
     * @var array
     */
    private array $documents = [];

    /**
     * @var string
     */
    private string $targetDirectory = '';

    /**
     * The constructor
     *
     * @param string $targetDirectory
     */
    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * Upload files
     *
     * @param array $uploadedFiles  List of uploaded files
     */
    public function upload(array $uploadedFiles = []): string
    {
        foreach ($uploadedFiles['documents'] as $document) {
            if ($document->getError() === UPLOAD_ERR_OK) {
                $target = $this->targetDirectory . '/' .$document->getClientFilename();
                $document->moveTo($target);

                $this->documents[] = $document->getClientFilename();
            }
        }

        return $this->getUploadedDocuments();
    }

    /**
     * Get target directory
     *
     * @return string
     */
    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    /**
     * Get a list of uploaded document names
     *
     * @return string
     */
    private function getUploadedDocuments(): string
    {
        $str = '';
        foreach ($this->documents as $document) {
            $str .= $document . ', ';
        }

        $str = substr($str, 0, -2);

        return $str;
    }
}
