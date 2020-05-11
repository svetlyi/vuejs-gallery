<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class Created extends Event
{
    public const NAME = 'image.created';
    private int $imgId;

    public function __construct(int $imgId)
    {
        $this->imgId = $imgId;
    }

    public function getImgId(): int
    {
        return $this->imgId;
    }
}