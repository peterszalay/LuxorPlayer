<?php
use PHPUnit\Framework\TestCase;
use LuxorPlayer\LuxorTicket;
use LuxorPlayer\LuxorTicketCreator;

class LuxorTicketCreatorTest extends TestCase
{
    protected LuxorTicketCreator $luxorTicketCreator;
    
    protected function setUp(): void
    {
        $this->luxorTicketCreator = new LuxorTicketCreator;
    }
    
    public function testCreateTicketWithRandomNumbersReturnsInstanceOfLuxorTicket() :void
    {
        $luxorTicket = $this->luxorTicketCreator->createTicketWithRandomNumbers();
        
        $this->assertInstanceOf(LuxorTicket::class, $luxorTicket);
    }
    
    public function testCreateTicketWithRandomNumbersReturnsTicketWithCorrectSizePictureAndFrame() :void
    {
        $luxorTicket = $this->luxorTicketCreator->createTicketWithRandomNumbers();
        
        $this->assertEquals(6, sizeof($luxorTicket->getPicture()));
        
        $this->assertEquals(14, sizeof($luxorTicket->getFrame()));
    }
    
    public function testCreateTicketWithRandomNumbersReturnsTicketWithPictureAndFrameInCorrectRange() :void
    {
        $luxorTicket = $this->luxorTicketCreator->createTicketWithRandomNumbers();
        
        $pictureInRange = true;
        
        foreach($luxorTicket->getPicture() as $number){
            if($number < 16 || $number > 60){
                $pictureInRange = false;
            }
        }
        
        $this->assertTrue($pictureInRange);
        
        $frameInRange = true;
        
        foreach($luxorTicket->getFrame() as $number){
            if($number < 1 || $number > 75){
                $frameInRange = false;
            }
        }
        
        $this->assertTrue($frameInRange);
    }
    
    public function testCreateTicketsWithRandomNumbersReturnsTicketsWithPictureAndFrameContainingDifferentNumbers() :void
    {
        $this->luxorTicketCreator->createTicketsWithRandomNumbers(1000);
        
        $pictureFrameOnlyContainsDifferentNumbers = true;
        
        $tickets = $this->luxorTicketCreator->getTickets();
        
        foreach ($tickets as $ticket){
            if(!empty(array_intersect($ticket->getFrame(), $ticket->getPicture()))){
                $pictureFrameOnlyContainsDifferentNumbers = false;
                break;
            }
        }       
        $this->assertTrue($pictureFrameOnlyContainsDifferentNumbers);
    }
    
    public function testCreateTicketWithRandomNumbersFromSelectionReturnsLuxorTicketWithCorrectPictureFrameSizes() :void
    {
        $ranges = ['first_range' => [ 1, 2, 3, 4, 5, 6, 7, 8], 'second_range' => [16,17,18,19,20,21,22,23], 
                   'third_range' => [31,32,33,34,35,36,37,38], 'fourth_range' => [46,47,48,49,50,51,52,53], 
                   'fifth_range' => [61,62,63,64,65,66,67,68]];
        
        $luxorTicket = $this->luxorTicketCreator->createTicketWithRandomNumbersFromSelection($ranges);
        
        $this->assertInstanceOf(LuxorTicket::class, $luxorTicket);
        
        $this->assertEquals(6, sizeof($luxorTicket->getPicture()));
        
        $this->assertEquals(14, sizeof($luxorTicket->getFrame()));
        
    }
    
    public function testCreateTicketWithRandomNumbersFromSelectionReturnsTicketWithPictureAndFrameInCorrectRangeAndOnlyNumbersFromSection() :void
    {
        $ranges = ['first_range' => [ 1, 2, 3, 4, 5, 6, 7, 8], 'second_range' => [16,17,18,19,20,21,22,23],
                   'third_range' => [31,32,33,34,35,36,37,38], 'fourth_range' => [46,47,48,49,50,51,52,53],
                   'fifth_range' => [61,62,63,64,65,66,67,68]];
        
        $luxorTicket = $this->luxorTicketCreator->createTicketWithRandomNumbersFromSelection($ranges);
        
        $pictureInRange = true;
        
        foreach($luxorTicket->getPicture() as $number){
            if($number < 16 || $number > 53 || ($number >= 24 && $number <= 30) || ($number >= 39 && $number <= 45)){
                $pictureInRange = false;
            }
        }
        
        $this->assertTrue($pictureInRange);
        
        $frameInRange = true;
        
        foreach($luxorTicket->getFrame() as $number){
            if($number < 1 || $number > 68 || ($number >= 24 && $number <= 30) || ($number >= 39 && $number <= 45)){
                $frameInRange = false;
            }
        }
        
        $this->assertTrue($frameInRange);
    }
    
    public function testCreateTicketsWithRandomNumbersFromSelectionReturnsTicketsWithPictureAndFrameContainingDifferentNumbers() :void
    {
        $ranges = ['first_range' => [ 1, 2, 3, 4, 5, 6, 7, 8], 'second_range' => [16,17,18,19,20,21,22,23],
                   'third_range' => [31,32,33,34,35,36,37,38], 'fourth_range' => [46,47,48,49,50,51,52,53],
                   'fifth_range' => [61,62,63,64,65,66,67,68]];
        
        $this->luxorTicketCreator->createTicketsWithRandomNumbersFromSelection(1000, $ranges);
        
        $pictureFrameOnlyContainsDifferentNumbers = true;
        
        $tickets = $this->luxorTicketCreator->getTickets();
        
        foreach ($tickets as $ticket){
            if(!empty(array_intersect($ticket->getFrame(), $ticket->getPicture()))){
                $pictureFrameOnlyContainsDifferentNumbers = false;
                break;
            }
        }
        $this->assertTrue($pictureFrameOnlyContainsDifferentNumbers);
    }
    
    public function testMergeTwoSelectionsReturnsCorrectlyMergedArrays() :void
    {
        $selection1 = ['first_range' => [ 1, 2, 3, 4], 'second_range' => [16,17,18,19],
                       'third_range' => [31,32,33,34], 'fourth_range' => [46,47,48,49],
                       'fifth_range' => [61,62,63,64]];
        $selection2 = ['first_range' => [ 4, 5], 'second_range' => [22,24],
                       'third_range' => [33,35], 'fourth_range' => [50,55],
                       'fifth_range' => [67,68]];
        
        $mergedSelection = $this->luxorTicketCreator->mergeTwoSelections($selection1, $selection2);
        
        $this->assertEquals(['first_range' => [ 1, 2, 3, 4, 5], 'second_range' => [16,17,18,19,22,24],
                             'third_range' => [31,32,33,34,35], 'fourth_range' => [46,47,48,49,50,55],
                             'fifth_range' => [61,62,63,64,67,68]], $mergedSelection);
    }
    
    public function testCreateRandomSelectionReturnsCorrectSizeArrayWithCorrectSizeRanges() :void
    {
        $selection = $this->luxorTicketCreator->createRandomSelection(-10); //min: 0
        
        $this->assertEquals(0, sizeof($selection['first_range']));
        $this->assertEquals(0, sizeof($selection['second_range']));
        $this->assertEquals(0, sizeof($selection['third_range']));
        $this->assertEquals(0, sizeof($selection['fourth_range']));
        $this->assertEquals(0, sizeof($selection['fifth_range']));
        
        $selection = $this->luxorTicketCreator->createRandomSelection(20);
        
        $this->assertEquals(4, sizeof($selection['first_range']));
        $this->assertEquals(4, sizeof($selection['second_range']));
        $this->assertEquals(4, sizeof($selection['third_range']));
        $this->assertEquals(4, sizeof($selection['fourth_range']));
        $this->assertEquals(4, sizeof($selection['fifth_range']));
        
        $selection = $this->luxorTicketCreator->createRandomSelection(100); //max: 40
        
        $this->assertEquals(8, sizeof($selection['first_range']));
        $this->assertEquals(8, sizeof($selection['second_range']));
        $this->assertEquals(8, sizeof($selection['third_range']));
        $this->assertEquals(8, sizeof($selection['fourth_range']));
        $this->assertEquals(8, sizeof($selection['fifth_range']));
    }
    
    public function testCreateTicketWithRandomNumberUsingRangesEnforceProportionsReturnsCorrectOddEvenProportions() :void
    {
        $reflector = new ReflectionClass(LuxorTicketCreator::class);
        try {
            $method1 = $reflector->getMethod('fillRanges');
            $method2 = $reflector->getMethod('CreateTicketWithRandomNumberUsingRanges');
            $method1->setAccessible(true);
            $method2->setAccessible(true);

            $method1->invokeArgs($this->luxorTicketCreator, []);
            $result = $method2->invokeArgs($this->luxorTicketCreator, [true]);
            $allNumbers = array_merge($result->getPicture(), $result->getFrame());

            $this->assertEquals(20, sizeof($allNumbers));
            $evenCount = 0;
            foreach($allNumbers as $number){
                if($number % 2 == 0){
                    $evenCount++;
                }
            }
            $this->assertTrue($evenCount <= 11 && $evenCount >= 9);
        } catch (ReflectionException $e) {
            print $e->getMessage();
        }
    }
}