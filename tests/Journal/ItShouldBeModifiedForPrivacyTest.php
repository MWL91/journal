<?php

namespace Tests\Journal;

use Journal\DomainModel\Commands\CreateJournalEntry;
use Journal\DomainModel\Commands\ModifyEntryForPrivacy;
use Journal\DomainModel\Dtos\EntryDto;
use Journal\DomainModel\Entry;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class ItShouldBeModifiedForPrivacyTest extends TestCase
{
    private Entry $entry;
    private UuidInterface $entryId;
    private UuidInterface $authorId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->entryId = \Ramsey\Uuid\Uuid::uuid4();
        $this->authorId = \Ramsey\Uuid\Uuid::uuid4();
        $this->date = '2021-01-01 00:00:00';
        $this->content = 'Hello world!';

        $payload = [
            'id' => $this->entryId->toString(),
            'authorId' => $this->authorId->toString(),
            'date' => $this->date,
            'content' => $this->content,
        ];

        $entryDto = EntryDto::fromPayload($payload);

        $this->entry = new Entry();
        $this->entry->load($entryDto);
    }

    public function testItShouldPrepareEntryForPublish()
    {
        // Given:
        $publishableContent = 'Hello Poland!';

        // When:
        $this->entry->modifyForPrivacy(new ModifyEntryForPrivacy(
            $this->entryId,
            $publishableContent
        ));

        // Then:
        $this->assertEquals([
            'id' => $this->entryId->toString(),
            'authorId' => $this->authorId->toString(),
            'date' => $this->date,
            'content' => $this->content,
            'publishableContent' => $publishableContent,
        ], $this->entry->getPayload());
    }
}