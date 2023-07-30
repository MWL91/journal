<?php

namespace Tests\Journal;

use Journal\Commands\SyncWithAi;
use Journal\Infrastructure\Ai\IAiQuestionsService;

class ItShouldBeSendToAITest extends TestCase
{
    public function testItShouldPrepareEntryForPublish()
    {
        // Given:
        $publishableContent = 'Hello Poland!';
        $answer = 'answer';
        $this->reloadEntry([
            'publishableContent' => $publishableContent
        ]);
        $aiQuestionsServiceMock = $this->createStub(IAiQuestionsService::class);
        $aiQuestionsServiceMock->method('getQuestions')
            ->willReturn($answer);

        // When:
        $this->entry->syncWithAI(new SyncWithAi(
            $this->entryId
        ), $aiQuestionsServiceMock);

        // Then:
        $this->assertEquals([
            'id' => $this->entryId->toString(),
            'authorId' => $this->authorId->toString(),
            'date' => $this->date,
            'content' => $this->content,
            'publishableContent' => $publishableContent,
            'aiQuestions' => $answer
        ], $this->entry->getPayload());
    }
}