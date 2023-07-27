<?php

namespace Tests\Journal;

use Journal\DomainModel\Commands\CreateJournalEntry;
use Journal\DomainModel\Dtos\EntryDto;
use Journal\DomainModel\Entry;
use PHPUnit\Framework\TestCase;

class ItShouldBeModifiedForPrivacyTest extends TestCase
{
    private Entry $entry;

    protected function setUp(): void
    {
        parent::setUp();

        $entryId = \Ramsey\Uuid\Uuid::uuid4();
        $authorId = \Ramsey\Uuid\Uuid::uuid4();
        $payload = [
            'id' => $entryId->toString(),
            'authorId' => $authorId->toString(),
            'date' => '2021-01-01 00:00:00',
            'content' => 'Hello world!',
        ];

        $entryDto = EntryDto::fromPayload($payload);

        $this->entry = new Entry();
        $this->entry->load($entryDto);
    }

    public function testItShouldPrepareEntryForPublish()
    {
    }
}