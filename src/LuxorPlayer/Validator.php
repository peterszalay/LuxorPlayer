<?php
namespace LuxorPlayer;

trait Validator
{
    /**
     * Checks if element contains the correct type and value above or equals to $minValue
     * If yes it returns $element, if not it returns $returnValue
     *
     * @param $element
     * @param int $minValue
     * @param int $returnValue
     * @return int
     */
    private function getIntValue($element, int $minValue, int $returnValue) :int
    {
        return (isset($element) && is_int($element) && $element >= $minValue) ? $element : $returnValue;
    }

    /**
     * Checks if $element is of type array, if yes it returns $element, else it returns array given as $returnValue
     *
     * @param $element
     * @param array $returnValue
     * @return array
     */
    private function getArrayValues($element, array $returnValue) :array
    {
        return (isset($element) && is_array($element)) ? $element : $returnValue;
    }

    /**
     * Checks if $element is of type string, if yes it returns $element, else it returns string given as $returnValue
     *
     * @param $element
     * @param string $returnValue
     * @return string
     */
    private function getStringValue($element, string $returnValue) :string
    {
        return (isset($element) && is_string($element)) ? $element : $returnValue;
    }
}