<?php

namespace App\Service;

use App\Entity\Image as ImageEntity;
use App\Repository\ImageRepository;
use App\View\ImageList;
use App\View\Image as ImageViewDto;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ImageView
{
    public const CACHE_KEY = 'image.list';

    private ImageRepository $imageRepository;
    private TranslatorInterface $translator;
    private CacheItemPoolInterface $cache;
    private LoggerInterface $logger;

    public function __construct(
        ImageRepository $imageRepository,
        TranslatorInterface $translator,
        CacheItemPoolInterface $cache,
        LoggerInterface $logger
    )
    {
        $this->imageRepository = $imageRepository;
        $this->translator = $translator;
        $this->cache = $cache;
        $this->logger = $logger;
    }

    public function getList(): ImageList
    {
        $item = $this->cache->getItem(self::CACHE_KEY);
        if ($item->isHit()) {
            $this->logger->debug('image list from cache');
            return $item->get();
        }
        $images = $this->imageRepository->findBy([], ['id' => 'DESC']);

        $imagesViews = [];
        foreach ($images as $image) {
            $imagesViews[] = $this->singleImage($image);
        }
        $labelsViews = [];

        $labelsViews['entity.image.name'] = $this->translator->trans('entity.image.name');
        $labelsViews['entity.image.name_description'] = $this->translator->trans('entity.image.name_description');
        $labelsViews['entity.image.file'] = $this->translator->trans('entity.image.file');
        $labelsViews['entity.image.labels.choose_file'] = $this->translator->trans('entity.image.labels.choose_file');
        $labelsViews['entity.image.labels.save'] = $this->translator->trans('entity.image.labels.save');

        $imageList = new ImageList($imagesViews, $labelsViews);
        $item->set($imageList);
        $this->cache->save($item);

        return $imageList;
    }

    public function singleImage(ImageEntity $image): ImageViewDto
    {
        return new ImageViewDto(
            $image->getId(),
            $image->getName(),
            $image->getPath()
        );
    }
}
