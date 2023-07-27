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
    private ?string $verifiedContent;

    public function __construct(
        string $id,
        string $authorId,
        string $date,
        string $content,
        ?string $verifiedContent
    )
    {
        $this->id = Uuid::fromString($id);
        $this->authorId = Uuid::fromString($authorId);
        $this->date = new \DateTimeImmutable($date);
        $this->content = $content;
        $this->verifiedContent = $verifiedContent;
    }

    public static function fromPayload(array $payload): self
    {
        return new self(
            $payload['id'],
            $payload['authorId'],
            $payload['date'],
            $payload['content'],
            $payload['verifiedContent'] ?? null
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
}