<?php

namespace App\Service;

use App\Dto\ImageDto;
use App\Entity\Image as ImageEntity;
use App\Event\Created;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Image
{
    private ImageRepository $imageRepository;
    private EntityManagerInterface $em;
    private ContainerInterface $container;
    private FileUploader $fileUploader;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        ImageRepository $imageRepository,
        EntityManagerInterface $em,
        ContainerInterface $container,
        FileUploader $fileUploader,
        EventDispatcherInterface $dispatcher
    )
    {
        $this->imageRepository = $imageRepository;
        $this->em = $em;
        $this->container = $container;
        $this->fileUploader = $fileUploader;
        $this->dispatcher = $dispatcher;
    }


    public function create(ImageDto $imageDto): ImageEntity
    {
        $imageEntity = new ImageEntity();
        $imageEntity->setName($imageDto->getName());
        $imageEntity->setPath($this->fileUploader->save($imageDto->getFile()));

        $this->em->persist($imageEntity);
        $this->em->flush();
        $this->dispatcher->dispatch(new Created($imageEntity->getId()), Created::NAME);

        return $imageEntity;
    }
}
