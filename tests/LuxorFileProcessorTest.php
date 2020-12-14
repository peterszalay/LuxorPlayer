<?php
use PHPUnit\Framework\TestCase;
use LuxorPlayer\LuxorFileProcessor;

class LuxorFileProcessorTest extends TestCase
{
    
    protected LuxorFileProcessor $fileProcessor;
    
    protected function setUp(): void 
    {
        $this->fileProcessor = new LuxorFileProcessor;
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
    