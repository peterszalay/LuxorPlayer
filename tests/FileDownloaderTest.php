<?php
use PHPUnit\Framework\TestCase;
use LuxorPlayer\FileDownloader;

class FileDownloaderTest extends TestCase
{
    public function testDownloadCsv()
    {
        $fileDownloader = new FileDownloader;
        
        $this->assertIsBool($fileDownloader->downloadCsv());
    }
    
    public function testLocalLuxorCsvExistsAfterDownloadCsv()
    {
        $this->assertFileExists(__DIR__ . '/../files/luxor.csv');
    }
}