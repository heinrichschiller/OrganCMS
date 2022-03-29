<?php

/**
 * MIT License
 *
 * Copyright (c) 2022 Heinrich Schiller
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

declare(strict_types=1);

namespace App\Domain\Donation\Service;

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
