<?php

if (!function_exists('is_carbon')) {
    function is_carbon(mixed $var): bool
    {
        return $var instanceof \Carbon\CarbonInterface;
    }
}
