<?php

namespace App\Entity;

class Event
{
    private $id;
    private $name;
    private $props;

    public function __construct(int $id, string $name, string $props)
    {
        $this->id = $id;
        $this->name = $name;
        $this->props = $props;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProps(): string
    {
        return $this->props;
    }
} 