<?php
use PHPUnit\Framework\TestCase;
use LuxorPlayer\LuxorTicket;

class LuxorTicketTest extends TestCase
{
    public function testCreate()
    {
        $luxorTicket = LuxorTicket::create([],[]);
        $this->assertEquals($luxorTicket->picture, []);
        $this->assertEquals($luxorTicket->frame, []);
        
        $luxorTicket = LuxorTicket::create([25,20,45,38,48,46],[12,2,11,8,19,22,43,36,57,59,70,69,73,72]);
        $this->assertEquals($luxorTicket->picture, [25,20,45,38,48,46]);
        $this->assertEquals($luxorTicket->frame, [12,2,11,8,19,22,43,36,57,59,70,69,73,72]);
        
    }
}