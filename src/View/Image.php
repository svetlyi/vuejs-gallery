<?php

namespace App\View;

class Image
{
    private int $id;
    private string $name;
    private string $path;

    public function __construct(int $id, string $name, string $path)
    {
        $this->id = $id;
        $this->name = $name;
        $this->path = $path;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
