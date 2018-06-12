<?php

namespace App\Service;

use App\Entity\ImageEntity;
use App\Repository\ImageRepository;
use App\View\ImageListView;
use App\View\ImageView;
use Symfony\Component\Translation\TranslatorInterface;

class ImageViewService
{
    /**
     * @var ImageRepository
     */
    private $imageRepository;
    /**
     * @var TranslatorInterface
     */
    private $translator;


    public function __construct(ImageRepository $imageRepository, TranslatorInterface $translator)
    {
        $this->imageRepository = $imageRepository;
        $this->translator = $translator;
    }


    public function getList(): ImageListView
    {
        $images = $this->imageRepository->findBy([], ['id' => 'DESC']);

        $imageList = new ImageListView();
        $imageList->images = [];

        foreach ($images as $image) {
            $imageList->images[] = $this->singleImage($image);
        }

        $imageList->labels['entity.image.name'] = $this->translator->trans('entity.image.name');
        $imageList->labels['entity.image.name_description'] = $this->translator->trans('entity.image.name_description');
        $imageList->labels['entity.image.file'] = $this->translator->trans('entity.image.file');
        $imageList->labels['entity.image.labels.choose_file'] = $this->translator->trans('entity.image.labels.choose_file');
        $imageList->labels['entity.image.labels.save'] = $this->translator->trans('entity.image.labels.save');

        return $imageList;
    }

    public function singleImage(ImageEntity $image): ImageView
    {
        $imageView = new ImageView();
        $imageView->id = $image->getId();
        $imageView->name = $image->getName();
        $imageView->path = $image->getPath();

        return $imageView;
    }
}
