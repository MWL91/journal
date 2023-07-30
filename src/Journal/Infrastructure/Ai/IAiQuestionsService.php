<?php

namespace Journal\Infrastructure\Ai;

interface IAiQuestionsService
{
    public function getQuestions(string $content): string;
}