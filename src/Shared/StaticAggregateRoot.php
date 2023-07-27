<?php

namespace Shared;

use Journal\DomainModel\Dtos\EntryDto;

abstract class StaticAggregateRoot
{
    abstract public function load(EntryDto $dto): self;
    abstract public function getPayload(): array;
}