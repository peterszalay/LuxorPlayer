<?php
use PHPUnit\Framework\TestCase;
use LuxorPlayer\FileProcessor;

class FileProcessorTest extends TestCase
{
    
    protected FileProcessor $fileProcessor;
    
    protected function setUp(): void 
    {
        $this->fileProcessor = new FileProcessor;
    }
    
    public function testGetDrawResultsIsEmptyWhenFileNotReadYet()
    {     
        $this->assertEmpty($this->fileProcessor->getDrawResults());

    }
    
    public function testGetDrawResultsReturnCorrectSizeArray() :void
    {
        $this->fileProcessor->readFileIntoArray(50);
        
        $this->assertEquals(50, sizeof($this->fileProcessor->getDrawResults()));
    }
}
    