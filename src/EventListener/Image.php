<?php

namespace App\EventListener;

use App\Event\Created;
use App\Service\ImageView;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

class Image
{
    private LoggerInterface $logger;
    private CacheItemPoolInterface $cache;

    public function __construct(
        LoggerInterface $logger,
        CacheItemPoolInterface $cache
    )
    {
        $this->logger = $logger;
        $this->cache = $cache;
    }

    public function onImageCreated(Created $created): void
    {
        $this->cache->deleteItem(ImageView::CACHE_KEY);
        $this->logger->debug($created::NAME . 'event');
    }
}