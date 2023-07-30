<?php

namespace Journal\Commands;

use Ramsey\Uuid\UuidInterface;

final class SyncWithAi
{
    public function __construct(private UuidInterface $id)
    {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}