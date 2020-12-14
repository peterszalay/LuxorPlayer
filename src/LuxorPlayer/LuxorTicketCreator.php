<?php
namespace LuxorPlayer;


class LuxorTicketCreator implements TicketCreator
{
    use Comparator;

    /**
     * Luxor numbers are split into 5 ranges. Each range contains 15 numbers, 75 in total.
     * From each range a player picks 4 numbers, 20 in total.
     */
    private array $firstRange;
    private array $secondRange;
    private array $thirdRange;
    private array $fourthRange;
    private array $fifthRange;
    /**
     * $tickets will contain the players bets
     */
    private array $tickets = [];
    
    /**
     * Get generated $tickets array
     * 
     * @return array
     */
    public function getTickets() :array
    {
        return $this->tickets;
    }

    /**
     * Create number of tickets with randomly selected numbers
     *
     * @param int $numberOfTickets
     * @param bool $enforceOddEvenRatio
     */
    public function createTicketsWithRandomNumbers(int $numberOfTickets, bool $enforceOddEvenRatio = false) :void
    {
        $this->tickets = [];
        for($i = 0; $i < $numberOfTickets; $i++){
            $this->tickets[$i] = $this->createTicketWithRandomNumbers($enforceOddEvenRatio);
        }
    }
    
    /**
     * Create number of tickets with randomly selected numbers from selection
     * 
     * @param int $numberOfTickets
     * @param array $selection
     */
    public function createTicketsWithRandomNumbersFromSelection(int $numberOfTickets, array $selection) :void
    {
        $this->tickets = [];
        for($i = 0; $i < $numberOfTickets; $i++){
            $this->tickets[$i] = $this->createTicketWithRandomNumbersFromSelection($selection);
        }
    }

    /**
     * Create one ticket populated with random numbers
     *
     * @param bool $enforceOddEvenRatio
     * @return Ticket
     * @todo implement force prime ratio functionality
     */
    public function createTicketWithRandomNumbers(bool $enforceOddEvenRatio = false) :Ticket
    {
        $this->fillRanges();
        return $this->createTicketWithRandomNumberUsingRanges($enforceOddEvenRatio);
    }
    
    /**
     * Create ticket from selection of number split into 5 ranges
     * 
     * @param array $selection
     * @return Ticket
     */
    public function createTicketWithRandomNumbersFromSelection(array $selection) :Ticket
    {
        $this->fillRanges($selection);
        return $this->createTicketWithRandomNumberUsingRanges();
    }

    /**
     * Create Luxor Ticket
     *
     * @param array $picture
     * @param array $frame
     * @return LuxorTicket
     */
    public static function createTicket(array $picture, array $frame) :LuxorTicket
    {
        return new LuxorTicket($picture, $frame);
    }

    /**
     * Create ticket with random numbers using the five ranges
     *
     * @param bool $oddEven
     * @return LuxorTicket
     */
    private function createTicketWithRandomNumberUsingRanges(bool $oddEven = false) :LuxorTicket
    {
        $this->shuffleRanges();
        $firstRange = $this->getNumbersFromRange($this->firstRange, $oddEven);
        $secondRange = array_chunk($this->getNumbersFromRange($this->secondRange, $oddEven), 2);
        $thirdRange = array_chunk($this->getNumbersFromRange($this->thirdRange, $oddEven), 2);
        $fourthRange = array_chunk($this->getNumbersFromRange($this->fourthRange, $oddEven), 2);
        $fifthRange = $this->getNumbersFromRange($this->fifthRange, $oddEven);
        $frame = array_merge($firstRange, $secondRange[0], $thirdRange[0], $fourthRange[0], $fifthRange);
        $picture = array_merge($secondRange[1], $thirdRange[1], $fourthRange[1]);
        return self::createTicket($picture, $frame);
    }

    /**
     * Retrieve numbers from range
     *
     * @param array $range
     * @param bool $oddEven
     * @return array
     */
    private function getNumbersFromRange(array $range, bool $oddEven) :array
    {
        if(!$oddEven){
            return array_slice($range, 0, 4);
        } else {
            $odd = $this->filterArray($range, array(__CLASS__, "oddComparator"));
            $even = $this->filterArray($range, array(__CLASS__, "evenComparator"));
            $slice = array_slice($range, 0, 3);
            if(sizeof($this->filterArray($slice, array(__CLASS__, "oddComparator"))) >= 2){
                $slice = $this->addNumberToArray($slice, $even);
            } else {
                $slice = $this->addNumberToArray($slice, $odd);
            }
            return $slice;
        }
    }

    /**
     * Add number to array to complete pick of 4 numbers from range
     *
     * @param array $array
     * @param array $subArray
     * @return array
     */
    private function addNumberToArray(array $array, array $subArray) :array
    {
        while(sizeof($array) != 4){
            $number = array_pop($subArray);
            if(!is_null($number) && !in_array($number, $array)){
                array_push($array, $number);
            }
        }
        return $array;
    }
    
    /**
     * Fill ranges with the 75 numbers or selection
     * 
     * @param array $selection
     */
    private function fillRanges(array $selection = []) :void
    {
        if(empty($selection)){
            $this->fillRangesWithAllNumbers();
        } else {
            $this->firstRange = $selection['first_range'];
            $this->secondRange = $selection['second_range'];
            $this->thirdRange = $selection['third_range'];
            $this->fourthRange = $selection['fourth_range'];
            $this->fifthRange = $selection['fifth_range'];
        }
    }

    /**
     * Fill ranges with all 75 numbers
     */
    private function fillRangesWithAllNumbers() :void
    {
        $this->firstRange = range(1,15);
        $this->secondRange = range(16,30);
        $this->thirdRange = range(31,45);
        $this->fourthRange = range(46,60);
        $this->fifthRange = range(61,75);
    }
    
    /**
     * Helper function that merges two selections (can be used to combine most and least drawn numbers)
     *
     * @param array $selection1
     * @param array $selection2
     * @return array
     */
    public function mergeTwoSelections(array $selection1, array $selection2) :array
    {
        $firstRange = array_values(array_unique(array_merge($selection1['first_range'], $selection2['first_range'])));
        $secondRange = array_values(array_unique(array_merge($selection1['second_range'], $selection2['second_range'])));
        $thirdRange = array_values(array_unique(array_merge($selection1['third_range'], $selection2['third_range'])));
        $fourthRange = array_values(array_unique(array_merge($selection1['fourth_range'], $selection2['fourth_range'])));
        $fifthRange = array_values(array_unique(array_merge($selection1['fifth_range'], $selection2['fifth_range'])));
        return ['first_range' => $firstRange, 'second_range' => $secondRange, 'third_range' => $thirdRange,
                'fourth_range' => $fourthRange, 'fifth_range' => $fifthRange];
    }
    
    /**
     * Helper function that returns a selection of random numbers of size
     * (rounded so it is minimum 0, maximum 40 and dividable by 5)
     * 
     * @param int $size
     * @return array
     */
    public function createRandomSelection(int $size) :array
    {
        $this->fillRanges();
        $size = $this->adjustNumberSelectionSize($size);
        $this->shuffleRanges();
        return $this->getRandomRanges($size);
    }

    /**
     * Number selection size should be divisible by 5 and no more then 40
     *
     * @param int $size
     * @return int
     */
    private function adjustNumberSelectionSize(int $size) :int
    {
        if($size < 5){
            $size = 0;
        }
        if($size >= 40){
            $size = 40;
        }
        if($size % 5 != 0){
            $size = $size - ($size % 5);
        }
        return $size;
    }

    /**
     * Shuffle ranges (used before selecting (poping) numbers from each range)
     */
    private function shuffleRanges() :void
    {
        shuffle($this->firstRange);
        shuffle($this->secondRange);
        shuffle($this->thirdRange);
        shuffle($this->fourthRange);
        shuffle($this->fifthRange);
    }

    private function getRandomRanges($size) :array
    {
        $result = ['first_range' => [], 'second_range' => [], 'third_range' => [], 'fourth_range' =>[], 'fifth_range' =>[]];
        $i = 1;
        while($i <= $size){
            if($i <= ($size / 5)){
                $result['first_range'][] = array_pop($this->firstRange);
            } elseif ($i <= (($size / 5) * 2)){
                $result['second_range'][]  = array_pop($this->secondRange);
            } elseif($i <= (($size / 5) * 3)) {
                $result['third_range'][]  = array_pop($this->thirdRange);
            } elseif ($i <= (($size / 5)* 4)) {
                $result['fourth_range'][] = array_pop($this->fourthRange);
            } else {
                $result['fifth_range'][]  = array_pop($this->fifthRange);
            }
            $i++;
        }
        return $result;
    }
    
}