<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderService
{
    /**
     * @var ContainerInterface
     */
    private $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function save(UploadedFile $file): string
    {
        $webDir = DIRECTORY_SEPARATOR . 'uploads';
        $dir = $this->container->getParameter('kernel.project_dir') . DIRECTORY_SEPARATOR . 'public' . $webDir;
        $fileName = uniqid() . '.' . $file->guessExtension();
        $file->move($dir, $fileName);

        return $webDir . DIRECTORY_SEPARATOR . $fileName;
    }
}
