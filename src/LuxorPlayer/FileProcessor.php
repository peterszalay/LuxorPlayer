<?php
namespace LuxorPlayer;

interface FileProcessor
{
    public function readFileIntoArray(int $drawCount) :void;
    public function getDrawResults() :array;
}