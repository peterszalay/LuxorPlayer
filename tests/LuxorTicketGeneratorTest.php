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
        $luxorTicket = $this->luxorTicketGenerator->generateTicketWithRandomNumbers();
        
        $this->assertInstanceOf(LuxorTicket::class, $luxorTicket);
    }
    
    public function testGenerateTicketWithRandomNumbersReturnsTicketWithCorrectSizePictureAndFrame()
    {
        $luxorTicket = $this->luxorTicketGenerator->generateTicketWithRandomNumbers();
        
        $this->assertEquals(sizeof($luxorTicket->picture), 6);
        
        $this->assertEquals(sizeof($luxorTicket->frame), 14);        
    }
    
    public function testGenerateTicketWithRandomNumbersReturnsTicketWithPictureAndFrameInCorrectRange()
    {
        $luxorTicket = $this->luxorTicketGenerator->generateTicketWithRandomNumbers();
        
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
    
    public function testGenerateTicketFromSelectionReturnsLuxorTicketWithCorrectPictureFrameSizes()
    {
        $ranges = ['first_range' => [ 1, 2, 3, 4, 5, 6, 7, 8], 'second_range' => [16,17,18,19,20,21,22,23], 
                   'third_range' => [31,32,33,34,35,36,37,38], 'fourth_range' => [46,47,48,49,50,51,52,53], 
                   'fifth_range' => [61,62,63,64,65,66,67,68]];
        
        $luxorTicket = $this->luxorTicketGenerator->generateTicketFromSelection($ranges);
        
        $this->assertInstanceOf(LuxorTicket::class, $luxorTicket);
        
        $this->assertEquals(sizeof($luxorTicket->picture), 6);
        
        $this->assertEquals(sizeof($luxorTicket->frame), 14); 
        
    }
}