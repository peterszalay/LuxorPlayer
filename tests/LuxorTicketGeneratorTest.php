<?php
use PHPUnit\Framework\TestCase;
use LuxorPlayer\LuxorTicket;
use LuxorPlayer\LuxorTicketGenerator;

class LuxorTicketGeneratorTest extends TestCase
{
    protected $luxorTicketGenerator;
    
    protected function setUp(): void
    {
        $this->luxorTicketGenerator = new LuxorTicketGenerator;
    }
    
    public function testGenerateTicketWithRandomNumbersReturnsInstanceOfLuxorTicket()
    {
        $luxorTicket = $this->luxorTicketGenerator->generateTicketWithRandomNumbers(false, false);
        
        $this->assertInstanceOf(LuxorTicket::class, $luxorTicket);
    }
    
    public function testGenerateTicketWithRandomNumbersReturnsTicketWithCorrectSizePictureAndFrame()
    {
        $luxorTicket = $this->luxorTicketGenerator->generateTicketWithRandomNumbers(false, false);
        
        $this->assertEquals(sizeof($luxorTicket->picture), 6);
        
        $this->assertEquals(sizeof($luxorTicket->frame), 14);        
    }
    
    public function testGenerateTicketWithRandomNumbersReturnsTicketWithPictureAndFrameInCorrectRange()
    {
        $luxorTicket = $this->luxorTicketGenerator->generateTicketWithRandomNumbers(false, false);
        
        $pictureInRange = true;
        
        foreach($luxorTicket->picture as $number){
            if($number < 16 || $number > 60){
                $pictureInRange = false;
            }
        }
        
        $this->assertTrue($pictureInRange);
        
        $frameInRange = true;
        
        foreach($luxorTicket->frame as $number){
            if($number < 1 || $number > 75){
                $frameInRange = false;
            }
        }
        
        $this->assertTrue($frameInRange);
    }
    
    public function testGenerateTicketsWithRandomNumbersReturnsTicketsWithPictureAndFrameContainingDifferentNumbers()
    {
        $this->luxorTicketGenerator->generateTicketsWithRandomNumbers(1000);
        
        $pictureFrameOnlyContainsDifferentNumbers = true;
        
        $tickets = $this->luxorTicketGenerator->getTickets();
        
        foreach ($tickets as $ticket){
            if(!empty(array_intersect($ticket->frame, $ticket->picture))){
                $pictureFrameOnlyContainsDifferentNumbers = false;
                break;
            }
        }
        
        $this->assertTrue($pictureFrameOnlyContainsDifferentNumbers);
    }
}