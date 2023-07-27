<?php

namespace Journal\DomainModel;

use Journal\DomainModel\Commands\CreateJournalEntry;
use Journal\DomainModel\Dtos\EntryDto;
use Ramsey\Uuid\UuidInterface;
use Shared\StaticAggregateRoot;

final class Entry extends StaticAggregateRoot
{
    private UuidInterface $aggregateId;
    private UuidInterface $authorId;
    private \DateTimeInterface $date;
    private string $content;

    public function create(CreateJournalEntry $command): void
    {
        $this->aggregateId = $command->getId();
        $this->authorId = $command->getAuthorId();
        $this->date = $command->getDate();
        $this->content = $command->getContent();
    }

    public function load(EntryDto $dto): self
    {
        $this->aggregateId = $dto->getId();
        $this->authorId = $dto->getAuthorId();
        $this->date = $dto->getDate();
        $this->content = $dto->getContent();

        return $this;
    }

    public function getPayload(): array
    {
        return [
            'id' => $this->aggregateId->toString(),
            'authorId' => $this->authorId->toString(),
            'date' => $this->date->format('Y-m-d H:i:s'),
            'content' => $this->content,
        ];
    }
}