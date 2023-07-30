<?php

namespace Journal\Commands;

use Ramsey\Uuid\UuidInterface;

final class ModifyEntryForPrivacy
{
    public function __construct(private UuidInterface $id, private string $content)
    {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}