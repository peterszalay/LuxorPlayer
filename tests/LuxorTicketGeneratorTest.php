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
    
    public function testGenerateTicketWithRandomNumbersFromSelectionReturnsLuxorTicketWithCorrectPictureFrameSizes()
    {
        $ranges = ['first_range' => [ 1, 2, 3, 4, 5, 6, 7, 8], 'second_range' => [16,17,18,19,20,21,22,23], 
                   'third_range' => [31,32,33,34,35,36,37,38], 'fourth_range' => [46,47,48,49,50,51,52,53], 
                   'fifth_range' => [61,62,63,64,65,66,67,68]];
        
        $luxorTicket = $this->luxorTicketGenerator->generateTicketWithRandomNumbersFromSelection($ranges);
        
        $this->assertInstanceOf(LuxorTicket::class, $luxorTicket);
        
        $this->assertEquals(sizeof($luxorTicket->picture), 6);
        
        $this->assertEquals(sizeof($luxorTicket->frame), 14); 
        
    }
    
    public function testGenerateTicketWithRandomNumbersFromSelectionReturnsTicketWithPictureAndFrameInCorrectRangeAndOnlyNumbersFromSection()
    {
        $ranges = ['first_range' => [ 1, 2, 3, 4, 5, 6, 7, 8], 'second_range' => [16,17,18,19,20,21,22,23],
                   'third_range' => [31,32,33,34,35,36,37,38], 'fourth_range' => [46,47,48,49,50,51,52,53],
                   'fifth_range' => [61,62,63,64,65,66,67,68]];
        
        $luxorTicket = $this->luxorTicketGenerator->generateTicketWithRandomNumbersFromSelection($ranges);
        
        $pictureInRange = true;
        
        foreach($luxorTicket->picture as $number){
            if($number < 16 || $number > 53 || ($number >= 24 && $number <= 30) || ($number >= 39 && $number <= 45)){
                $pictureInRange = false;
            }
        }
        
        $this->assertTrue($pictureInRange);
        
        $frameInRange = true;
        
        foreach($luxorTicket->frame as $number){
            if($number < 1 || $number > 68 || ($number >= 24 && $number <= 30) || ($number >= 39 && $number <= 45)){
                $frameInRange = false;
            }
        }
        
        $this->assertTrue($frameInRange);
    }
    
    public function testGenerateTicketsWithRandomNumbersFromSelectionReturnsTicketsWithPictureAndFrameContainingDifferentNumbers()
    {
        $ranges = ['first_range' => [ 1, 2, 3, 4, 5, 6, 7, 8], 'second_range' => [16,17,18,19,20,21,22,23],
                   'third_range' => [31,32,33,34,35,36,37,38], 'fourth_range' => [46,47,48,49,50,51,52,53],
                   'fifth_range' => [61,62,63,64,65,66,67,68]];
        
        $this->luxorTicketGenerator->generateTicketsWithRandomNumbersFromSelection(1000, $ranges);
        
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
    
    public function testMergeTwofSelectionsReturnsCorreclyMergedArrays()
    {
        $selection1 = ['first_range' => [ 1, 2, 3, 4], 'second_range' => [16,17,18,19],
                       'third_range' => [31,32,33,34], 'fourth_range' => [46,47,48,49],
                       'fifth_range' => [61,62,63,64]];
        $selection2 = ['first_range' => [ 4, 5], 'second_range' => [22,24],
                       'third_range' => [33,35], 'fourth_range' => [50,55],
                       'fifth_range' => [67,68]];
        
        $mergedSelection = $this->luxorTicketGenerator->mergeTwofSelections($selection1, $selection2);
        
        $this->assertEquals($mergedSelection, ['first_range' => [ 1, 2, 3, 4, 5], 'second_range' => [16,17,18,19,22,24], 'third_range' => [31,32,33,34,35], 'fourth_range' => [46,47,48,49,50,55],
            'fifth_range' => [61,62,63,64,67,68]]);
    }
    
    public function testGenerateRandomSelectionReturnsCorrectSizeArrayWithCorrectSizeRanges()
    {
        $selection = $this->luxorTicketGenerator->generateRandomSelection(-10); //min: 0
        
        $this->assertEquals(sizeof($selection['first_range']), 0);
        $this->assertEquals(sizeof($selection['second_range']), 0);
        $this->assertEquals(sizeof($selection['third_range']), 0);
        $this->assertEquals(sizeof($selection['fourth_range']), 0);
        $this->assertEquals(sizeof($selection['fifth_range']), 0);
        
        $selection = $this->luxorTicketGenerator->generateRandomSelection(20);
        
        $this->assertEquals(sizeof($selection['first_range']), 4);
        $this->assertEquals(sizeof($selection['second_range']), 4);
        $this->assertEquals(sizeof($selection['third_range']), 4);
        $this->assertEquals(sizeof($selection['fourth_range']), 4);
        $this->assertEquals(sizeof($selection['fifth_range']), 4);
        
        $selection = $this->luxorTicketGenerator->generateRandomSelection(100); //max: 40
        
        $this->assertEquals(sizeof($selection['first_range']), 8);
        $this->assertEquals(sizeof($selection['second_range']), 8);
        $this->assertEquals(sizeof($selection['third_range']), 8);
        $this->assertEquals(sizeof($selection['fourth_range']), 8);
        $this->assertEquals(sizeof($selection['fifth_range']), 8);
    }
}