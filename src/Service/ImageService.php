<?php

namespace App\Service;

use App\Dto\ImageDto;
use App\Entity\ImageEntity;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImageService
{
    /**
     * @var ImageRepository
     */
    private $imageRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var FileUploaderService
     */
    private $fileUploader;


    public function __construct(
        ImageRepository $imageRepository,
        EntityManagerInterface $em,
        ContainerInterface $container,
        FileUploaderService $fileUploader
    )
    {
        $this->imageRepository = $imageRepository;
        $this->em = $em;
        $this->container = $container;
        $this->fileUploader = $fileUploader;
    }


    public function create(ImageDto $imageDto): ImageEntity
    {
        $imageEntity = new ImageEntity();
        $imageEntity->setName($imageDto->getName());
        $imageEntity->setPath($this->fileUploader->save($imageDto->getFile()));

        $this->em->persist($imageEntity);
        $this->em->flush();

        return $imageEntity;
    }
}
