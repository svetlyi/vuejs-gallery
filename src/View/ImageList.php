<?php

namespace App\View;

class ImageList
{
	/** @var Image[]  */
    private array $images = [];
    private array $labels = [];

    public function __construct(array $images, array $labels)
    {
        $this->images = $images;
        $this->labels = $labels;
    }

    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return $this->labels;
    }
}
