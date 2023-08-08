<?php

namespace Journal\DomainModel;

use Journal\Commands\CreateJournalEntry;
use Journal\Commands\ModifyEntryForPrivacy;
use Journal\Commands\SyncWithAi;
use Journal\Dtos\EntryDto;
use Journal\Infrastructure\Ai\IAiQuestionsService;
use Ramsey\Uuid\UuidInterface;
use Shared\StaticAggregateRoot;

final class Entry extends StaticAggregateRoot
{
    private UuidInterface $aggregateId;
    private UuidInterface $authorId;
    private \DateTimeInterface $date;
    private string $content;
    private string $publishableContent;
    private string $aiQuestions;

    public function create(CreateJournalEntry $command): void
    {
        $this->aggregateId = $command->getId();
        $this->authorId = $command->getAuthorId();
        $this->date = $command->getDate();
        $this->content = $command->getContent();
    }

    public function modifyForPrivacy(ModifyEntryForPrivacy $command): void
    {
        if($this->aggregateId <=> $command->getId()) {
            return;
        }

        if($this->content === '') {
            return;
        }

        $this->publishableContent = $command->getContent();
    }

    public function syncWithAI(SyncWithAi $command, IAiQuestionsService $aiService): void
    {
        if($this->aggregateId <=> $command->getId()) {
            return;
        }

        if(empty($this->publishableContent)) {
            return;
        }

        $this->aiQuestions = $aiService->getQuestions($this->publishableContent);
    }

    public function load(EntryDto $dto): self
    {
        $this->aggregateId = $dto->getId();
        $this->authorId = $dto->getAuthorId();
        $this->date = $dto->getDate();
        $this->content = $dto->getContent();

        if($dto->getPublishableContent() !== null) {
            $this->publishableContent = $dto->getPublishableContent();
        }

        if ($dto->getAiQuestions() !== null) {
            $this->aiQuestions = $dto->getAiQuestions();
        }

        return $this;
    }

    public function getPayload(): array
    {
        return [
            'id' => $this->aggregateId->toString(),
            'authorId' => $this->authorId->toString(),
            'date' => $this->date->format('Y-m-d H:i:s'),
            'content' => $this->content,
            'publishableContent' => $this->publishableContent ?? null,
            'aiQuestions' => $this->aiQuestions ?? null,
        ];
    }
}