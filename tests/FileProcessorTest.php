<?php
use PHPUnit\Framework\TestCase;
use LuxorPlayer\FileProcessor;

class FileProcessorTest extends TestCase
{
    public function testGetDrawResultsIsEmptyWhenFileNotReadYet()
    {
        $fileProcessor = new FileProcessor;
        
        $this->assertEmpty($fileProcessor->getDrawResults());
        
        return $fileProcessor;
    }
    
    /**
     * @depends testGetDrawResultsIsEmptyWhenFileNotReadYet
     */
    public function testGetDrawResultsIsNotEmptyWhenFileIsReadIn(FileProcessor $fileProcessor)
    {
        $fileProcessor->readFileIntoArray();
        
        $this->assertNotEmpty($fileProcessor->getDrawResults());
    }
}
    