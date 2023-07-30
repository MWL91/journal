<?php

namespace Tests\Journal;

use Journal\Commands\ModifyEntryForPrivacy;

class ItShouldBeModifiedForPrivacyTest extends TestCase
{
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
            'aiQuestions' => null
        ], $this->entry->getPayload());
    }
}