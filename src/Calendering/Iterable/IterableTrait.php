<?php

namespace Calendering\Iterable;

trait IterableTrait
{
    private int $index = 0;

    public function rewind(): void
    {
        $this->index = 0;
    }

    public function current(): mixed
    {
        return $this->iterateTarget()[$this->index];
    }

    public function key(): int
    {
        return $this->index;
    }

    public function next(): void
    {
        $this->index++;
    }

    public function valid(): bool
    {
        return isset($this->iterateTarget()[$this->index]);
    }
}
