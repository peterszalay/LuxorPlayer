<?php
use PHPUnit\Framework\TestCase;
use LuxorPlayer\LuxorTicket;

class LuxorTicketTest extends TestCase
{
    
    public function testLuxorTicketClassHasPictureAndFrameAttributes()
    {
        $this->assertClassHasAttribute('picture', LuxorTicket::class);
        
        $this->assertClassHasAttribute('frame', LuxorTicket::class);
    }
    
    public function testCreateWithEmptyValues() :void
    {
        $luxorTicket = new LuxorTicket([],[]);
        
        $this->assertEquals([], $luxorTicket->getPicture());
        
        $this->assertEquals([], $luxorTicket->getFrame());
    }
      
    public function testCreateWithNonEmptyValues() :void
    {
        $luxorTicket = new LuxorTicket([25,20,45,38,48,46],[12,2,11,8,19,22,43,36,57,59,70,69,73,72]);
        
        $this->assertEquals([25,20,45,38,48,46], $luxorTicket->getPicture());
        
        $this->assertEquals([12,2,11,8,19,22,43,36,57,59,70,69,73,72], $luxorTicket->getFrame());
    }
}