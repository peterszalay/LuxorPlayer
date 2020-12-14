<?php
use PHPUnit\Framework\TestCase;
use LuxorPlayer\LuxorFileDownloader;

class LuxorFileDownloaderTest extends TestCase
{
    public function testDownloadCsv() :void
    {
        $fileDownloader = new LuxorFileDownloader();
        
        $this->assertIsBool($fileDownloader->downloadCsv());
    }
    
    public function testLocalLuxorCsvExistsAfterDownloadCsv() :void
    {
        $this->assertFileExists(__DIR__ . '/../files/luxor.csv');
    }
}