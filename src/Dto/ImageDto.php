<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ImageDto
 */
class ImageDto
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    protected $name;

    /**
     * @var UploadedFile
     *
     * @Assert\NotBlank()
     * @Assert\Image()
     */
    protected $file;

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * Set file.
     *
     * @param UploadedFile $path
     */
    public function setFile(UploadedFile $path)
    {
        $this->file = $path;
    }
}