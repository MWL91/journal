<?php

namespace Tests\Journal;

use Journal\DomainModel\Commands\CreateJournalEntry;
use Journal\DomainModel\Dtos\EntryDto;
use Journal\DomainModel\Entry;
use PHPUnit\Framework\TestCase;

class ItShouldBeCreatedTest extends TestCase
{
    public function testItShouldBeCreated()
    {
        // Given:
        $entryId = \Ramsey\Uuid\Uuid::uuid4();
        $authorId = \Ramsey\Uuid\Uuid::uuid4();
        $date = new \DateTimeImmutable();
        $content = 'Hello world!';

        // When:
        $entry = new Entry();
        $entry->create(new CreateJournalEntry(
            $entryId,
            $authorId,
            $date,
            $content
        ));

        // Then:
        $this->assertEquals([
            'id' => $entryId->toString(),
            'authorId' => $authorId->toString(),
            'date' => $date->format('Y-m-d H:i:s'),
            'content' => $content,
            'publishableContent' => null,
        ], $entry->getPayload());
    }

    public function testItShouldBeLoadedAfterCreate(): void
    {
        // Given:
        $entryId = \Ramsey\Uuid\Uuid::uuid4();
        $authorId = \Ramsey\Uuid\Uuid::uuid4();
        $payload = [
            'id' => $entryId->toString(),
            'authorId' => $authorId->toString(),
            'date' => '2021-01-01 00:00:00',
            'content' => 'Hello world!',
            'publishableContent' => null,
        ];
        $entryDto = EntryDto::fromPayload($payload);

        // When:
        $entry = new Entry();
        $entry->load($entryDto);

        // Then:
        $this->assertEquals($payload, $entry->getPayload());
    }
}