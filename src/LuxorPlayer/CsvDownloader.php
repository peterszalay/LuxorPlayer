<?php
namespace LuxorPlayer;

interface CsvDownloader
{
    public function downloadCsv() :bool;
    public function saveCsv(array $file, int $remoteTimeStamp) :bool;
}
