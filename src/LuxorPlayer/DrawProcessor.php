<?php
namespace LuxorPlayer;

interface DrawProcessor
{
    public function getMostDrawnNumbers(array $draws, int $numberOfMostDrawn) :array;
    public function getLeastDrawnNumbers(array $draws, int $numberOfLeastDrawn) :array;
}