<?php
namespace LuxorPlayer;

trait Comparator
{
    private static function evenComparator(int $number) :bool
    {
        return !($number & 1);
    }

    private static function oddComparator(int $number) :bool
    {
        return ($number & 1);
    }

    private function filterArray(array $numbers, array $funcName) :array
    {
        return array_values(array_filter($numbers, $funcName));
    }
}
