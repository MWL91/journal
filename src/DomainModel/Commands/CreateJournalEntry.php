<?php

namespace Journal\DomainModel\Commands;

use Ramsey\Uuid\UuidInterface;

final class CreateJournalEntry
{
    public function __construct(
        private UuidInterface $id,
        private UuidInterface $authorId,
        private \DateTimeInterface $date,
        private string $content
    )
    {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getAuthorId(): UuidInterface
    {
        return $this->authorId;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}