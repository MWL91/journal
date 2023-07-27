<?php

namespace Journal\DomainModel\Dtos;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class EntryDto
{
    private UuidInterface $id;
    private UuidInterface $authorId;
    private \DateTimeInterface $date;
    private string $content;
    private ?string $publishableContent;

    public function __construct(
        string $id,
        string $authorId,
        string $date,
        string $content,
        ?string $publishableContent
    )
    {
        $this->id = Uuid::fromString($id);
        $this->authorId = Uuid::fromString($authorId);
        $this->date = new \DateTimeImmutable($date);
        $this->content = $content;
        $this->publishableContent = $publishableContent;
    }

    public static function fromPayload(array $payload): self
    {
        return new self(
            $payload['id'],
            $payload['authorId'],
            $payload['date'],
            $payload['content'],
            $payload['publishableContent'] ?? null
        );
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

    public function getPublishableContent(): ?string
    {
        return $this->publishableContent;
    }
}