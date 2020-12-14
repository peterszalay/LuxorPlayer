<?php
namespace LuxorPlayer;

trait Validator
{

    /**
     * Checks if $element is of type array, if yes it returns $element, else it returns array given as $returnValue
     *
     * @param $element
     * @param array $returnValue
     * @return array
     */
    protected static function getArrayValues($element, array $returnValue) :array
    {
        return (is_array($element)) ? $element : $returnValue;
    }

    /**
     * Checks if $element is of type string, if yes it returns $element, else it returns string given as $returnValue
     *
     * @param $element
     * @param string $returnValue
     * @return string
     */
    protected static function getStringValue($element, string $returnValue) :string
    {
        return (is_string($element)) ? $element : $returnValue;
    }
}