<?php

namespace Calendering;

use Carbon\CarbonImmutable;

class Day
{
    private CarbonImmutable $date;
    private bool $is_current_month;

    public function __construct(
        CarbonImmutable $date,
        bool $is_current_month,
        public mixed $schedules = null,
    ) {
        $this->date = $date;
        $this->is_current_month = $is_current_month;
    }

    public function __get(string $name): mixed
    {
        return $this->{$name};
    }
}
