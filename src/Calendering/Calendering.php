<?php

namespace Calendering;

use Calendering\Iterable\IterableTrait;
use Calendering\Iterable\IterableInterface;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Iterator;
use Exception;

class Calendering implements Iterator, IterableInterface
{
    use IterableTrait;

    private array $calender;

    public function __construct(
        readonly private int $year,
        readonly private int $month,
    ) {
        $this->calender = $this->generate();
    }

    private static function inputNormalizer(mixed $first_arg, ?int $second_arg = null): array
    {
        $carbon = match (true) {
            is_carbon($first_arg)  => $first_arg,
            \is_string($first_arg) => CarbonImmutable::parse($first_arg),
            \is_array($first_arg)  => CarbonImmutable::create(...$first_arg),
            default                => CarbonImmutable::create($first_arg, $second_arg),
        };

        return [
            $carbon->year,
            $carbon->month,
        ];
    }

    public static function make(mixed $first_arg, mixed $second_arg = null): self
    {
        [$year, $month] = self::inputNormalizer(...func_get_args());

        return new self($year, $month);
    }

    public static function now(): self
    {
        return self::make(
            CarbonImmutable::now()
        );
    }


    public function nextMonth(int $month = 1): self
    {
        return self::make(
            CarbonImmutable::create($this->year, $this->month)->addMonths($month)
        );
    }

    public function prevMonth(int $month = 1): self
    {
        return $this->nextMonth($month * -1);
    }

    public function get(): array
    {
        return $this->calender;
    }


    private function generate(): array
    {
        $base_date = $this->fetchBaseDate();
        $last_date = $this->fetchLastDate();

        $current_date = $base_date;

        $buff = [];
        while ($current_date->ne($last_date)) {
            $current_date = $base_date->addDays(count($buff));
            $buff[] = new Day(
                $current_date,
                $current_date->month === $this->month,
                [],
            );
        }

        return array_chunk($buff, 7);
    }


    private function fetchBaseDate(): CarbonImmutable
    {
        return CarbonImmutable::create($this->year, $this->month)
            ->startOfWeek();
    }

    private function fetchLastDate(): CarbonImmutable
    {
        return $this->fetchBaseDate()
            ->addWeek()
            ->endOfMonth()
            ->endOfWeek()
            ->startOfDay();
    }


    public function iterateTarget(): array
    {
        return $this->calender;
    }
}
