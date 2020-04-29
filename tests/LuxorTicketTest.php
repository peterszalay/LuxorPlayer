<?php
use PHPUnit\Framework\TestCase;
use LuxorPlayer\LuxorTicket;

class LuxorTicketTest extends TestCase
{
    protected $luxorTicket;
    
    
    protected function setUp(): void
    {
        $this->luxorTicket = LuxorTicket::create([],[]);
    }
    
    
    public function testClassHasPictureAndFrameAttributes()
    {
        $this->assertClassHasAttribute('picture', LuxorTicket::class);
        
        $this->assertClassHasAttribute('frame', LuxorTicket::class);
    }
    
    public function testCreateWithEmptyValues()
    {
        
        $this->assertEquals($this->luxorTicket->picture, []);
        
        $this->assertEquals($this->luxorTicket->frame, []);
    }
    
    
    
    public function testCreateWithNonEmptyValues()
    {
        
        $this->luxorTicket = LuxorTicket::create([25,20,45,38,48,46],[12,2,11,8,19,22,43,36,57,59,70,69,73,72]);
        
        $this->assertEquals($this->luxorTicket->picture, [25,20,45,38,48,46]);
        
        $this->assertEquals($this->luxorTicket->frame, [12,2,11,8,19,22,43,36,57,59,70,69,73,72]);
        
    }
}