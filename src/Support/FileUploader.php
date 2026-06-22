<?php

declare(strict_types=1);

namespace App\Support;

final class FileUploader
{
    /**
     * @var array<mixed>
     */
    private array $documents = [];

    public function __construct(
        private string $targetDirectory
    ) {
    }

    /**
     * @param array<mixed> $uploadedFiles  List of uploaded files
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

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

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
