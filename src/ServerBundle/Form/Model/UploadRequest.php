<?php

namespace ServerBundle\Form\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class UploadRequest
{
    /**
     * @Assert\All({
     *   @Assert\File(
     *     maxSize="500M",
     *     mimeTypes = {"audio/mpeg3", "audio/x-mpeg-3", "audio/mpeg", "audio/mp3", "audio/webm"},
     *     mimeTypesMessage = "Please upload valid song file(s)"
     *   )
     * })
     * @var UploadedFile[]
     */
    protected $files = null;

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param array $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }
}