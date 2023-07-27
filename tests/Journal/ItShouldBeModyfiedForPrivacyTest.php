<?php

namespace Tests\Journal;

use Journal\DomainModel\Commands\CreateJournalEntry;
use Journal\DomainModel\Entry;
use PHPUnit\Framework\TestCase;

class ItShouldBeModyfiedForPrivacyTest extends TestCase
{
    public function testItShouldBeCreated()
    {
        $entryId = \Ramsey\Uuid\Uuid::uuid4();
        $authorId = \Ramsey\Uuid\Uuid::uuid4();
        $date = new \DateTimeImmutable();
        $content = 'Hello world!';

        $entry = new Entry();
        $entry->create(new CreateJournalEntry(
            $entryId,
            $authorId,
            $date,
            $content
        ));

        $this->assertEquals([
            'id' => $entryId->toString(),
            'authorId' => $authorId->toString(),
            'date' => $date->format('Y-m-d H:i:s'),
            'content' => $content,
        ], $entry->getPayload());
    }
}