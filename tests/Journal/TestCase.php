<?php

namespace Tests\Journal;

use Journal\DomainModel\Entry;
use Journal\Dtos\EntryDto;
use Ramsey\Uuid\UuidInterface;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected Entry $entry;
    protected UuidInterface $entryId;
    protected UuidInterface $authorId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->entryId = \Ramsey\Uuid\Uuid::uuid4();
        $this->authorId = \Ramsey\Uuid\Uuid::uuid4();
        $this->date = '2021-01-01 00:00:00';
        $this->content = 'Hello world!';

        $this->payload = [
            'id' => $this->entryId->toString(),
            'authorId' => $this->authorId->toString(),
            'date' => $this->date,
            'content' => $this->content,
        ];

        $this->reloadEntry([]);
    }

    protected function reloadEntry(array $payload): void
    {
        $this->payload = $payload + $this->payload;

        $entryDto = EntryDto::fromPayload($this->payload);
        $this->entry = new Entry();
        $this->entry->load($entryDto);
    }
}