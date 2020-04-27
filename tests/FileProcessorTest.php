<?php
use PHPUnit\Framework\TestCase;
use LuxorPlayer\FileProcessor;

class FileProcessorTest extends TestCase
{
    
    protected $fileProcessor;
    
    protected function setUp(): void 
    {
        $this->fileProcessor = new FileProcessor;
    }
    
    public function testGetDrawResultsIsEmptyWhenFileNotReadYet()
    {     
        $this->assertEmpty($this->fileProcessor->getDrawResults());

    }
    
    public function testGetDrawResultsIsNotEmptyWhenFileIsReadIn()
    {
        $this->fileProcessor->readFileIntoArray();
        
        $this->assertNotEmpty($this->fileProcessor->getDrawResults());
    }
}
    