<?php
namespace LuxorPlayer;


class LuxorTicketGenerator {
    
    private $name = "Ticket Generator";
    private $logger;
    /**
     * Luxornumbers are split into 5 ranges. Each range contains 15 numbers, 75 in total. 
     * From each range a player picks 4 numbers, 20 in total.
     */
    private $firstRange;
    private $secondRange;
    private $thirdRange;
    private $fourthRange;
    private $fifthRange;
    /**
     * $tickets will contain the players bets
     */
    private $tickets = [];
    
    
    public function __construct(){
    }
    
    /**
     * Get generated $tickets array
     * 
     * @return array
     */
    public function getTickets(){
        return $this->tickets;
    }
    
    /**
     * Generate number of tickets with randomly selected numbers
     * 
     * @param int $numberOfTickets
     */
    public function generateTicketsWithRandomNumbers($numberOfTickets){
        $this->tickets = [];
        for($i = 0; $i < $numberOfTickets; $i++){
            $this->tickets[$i] = $this->generateTicketWithRandomNumbers();     
        }
    }
    
    /**
     * Generate number of tickets with randomly selected numbers from selection
     * 
     * @param int $numberOfTickets
     * @param array $selection
     */
    public function generateTicketsWithRandomNumbersFromSelection($numberOfTickets, $selection){
        $this->tickets = [];
        for($i = 0; $i < $numberOfTickets; $i++){
            $this->tickets[$i] = $this->generateTicketWithRandomNumbersFromSelection($selection);
        }
    }
    
    /**
     * Generate one ticket populated with random numbers
     * 
     * @todo implement force odd even ratio, force prime ratio functionality
     * 
     * @return \LuxorPlayer\LuxorTicket
     */
    public function generateTicketWithRandomNumbers(){
        $this->fillRanges();
        return $this->generateTicketWithRandomNumberUsingRanges();
    }
    
    /**
     * Generate ticket from selection of number split into 5 ranges
     * 
     * @param array $selection
     * @return \LuxorPlayer\LuxorTicket
     */
    public function generateTicketWithRandomNumbersFromSelection($selection){       
        $this->fillRanges($selection);
        return $this->generateTicketWithRandomNumberUsingRanges();
    }
    
    /**
     * Generates ticket with random numbers using the five ranges
     * 
     * @return \LuxorPlayer\LuxorTicket
     */
    private function generateTicketWithRandomNumberUsingRanges(){
        $frame = [];
        $picture = [];
        $i = 1;
        while($i <= 20){
            if($i <= 4){
                shuffle($this->firstRange);
                $frame[] = array_pop($this->firstRange);
            } elseif ($i <= 8){
                shuffle($this->secondRange);
                if($i <= 6){
                    $frame[] = array_pop($this->secondRange);
                } else {
                    $picture[] = array_pop($this->secondRange);
                }
            } elseif($i <= 12){
                shuffle($this->thirdRange);
                if($i <= 10){
                    $frame[] = array_pop($this->thirdRange);
                } else {
                    $picture[] = array_pop($this->thirdRange);
                }
            } elseif($i <= 16){
                shuffle($this->fourthRange);
                if($i <= 14){
                    $frame[] = array_pop($this->fourthRange);
                } else {
                    $picture[] = array_pop($this->fourthRange);
                }
            } else {
                shuffle($this->fifthRange);
                $frame[] = array_pop($this->fifthRange);
            }
            $i++;
        }
        return LuxorTicket::create($picture, $frame);
    }
    
    /**
     * Put number in picture of frame array and remove from range
     * 
     * @param int $number
     * @param array $range
     * @param array $pictureOrFrame
     */
    private function putNumberInFrameOrPicture($number, &$range, &$pictureOrFrame){
        $pictureOrFrame[] = $number;
        $key = array_search($number, $range);
        unset($range[$key]);
    }
    
    /**
     * Fill ranges with the 75 numbers
     * 
     * @param array $selection
     */
    private function fillRanges($selection = []){
        if(empty($selection)){
            $this->firstRange = range(1,15);
            $this->secondRange = range(16,30);
            $this->thirdRange = range(31,45);
            $this->fourthRange = range(46,60);
            $this->fifthRange = range(61,75);
        } else {
            $this->firstRange = $selection['first_range'];
            $this->secondRange = $selection['second_range'];
            $this->thirdRange = $selection['third_range'];
            $this->fourthRange = $selection['fourth_range'];
            $this->fifthRange = $selection['fifth_range'];
        }
    }
    
    /**
     * Helper function that merges two selections (can be used to combine most and least drawn numbers)
     *
     * @param array $selection1
     * @param array $selection2
     * @return array
     */
    public function mergeTwofSelections($selection1, $selection2){
        $firstRange = array_values(array_unique(array_merge($selection1['first_range'], $selection2['first_range'])));
        $secondRange = array_values(array_unique(array_merge($selection1['second_range'], $selection2['second_range'])));
        $thirdRange = array_values(array_unique(array_merge($selection1['third_range'], $selection2['third_range'])));
        $fourthRange = array_values(array_unique(array_merge($selection1['fourth_range'], $selection2['fourth_range'])));
        $fifthRange = array_values(array_unique(array_merge($selection1['fifth_range'], $selection2['fifth_range'])));
        return ['first_range' => $firstRange, 'second_range' => $secondRange, 'third_range' => $thirdRange, 'fourth_range' => $fourthRange, 'fifth_range' => $fifthRange];
    }
    
    /**
     * Helper function that returns a selection of random numbers of size (rounded so it is minimum 0, maximum 40 and dividable by 5) 
     * 
     * @param int $size
     * @return array
     */
    public function generateRandomSelection($size){
        $this->fillRanges();
        $firstRange = [];
        $secondRange = [];
        $thirdRange = [];
        $fourthRange = [];
        $fifthRange = [];
        if($size < 5){
            $size = 0;
        }
        if($size >= 40){
            $size = 40;
        }
        if($size % 5 != 0){
            $size = $size - ($size % 5);
        }
        $i = 1;
        while($i <= $size){
            if($i <= ($size / 5)){
                shuffle($this->firstRange);
                $firstRange[] = array_pop($this->firstRange);
            } elseif ($i <= (($size / 5) * 2)){
                shuffle($this->secondRange);
                $secondRange[] = array_pop($this->secondRange);
            } elseif($i <= (($size / 5) * 3)) {
                shuffle($this->thirdRange);
                $thirdRange[] = array_pop($this->thirdRange);
            } elseif ($i <= (($size / 5)* 4)) {
                shuffle($this->fourthRange);
                $fourthRange[] = array_pop($this->fourthRange);
            } else {
                shuffle($this->fifthRange);
                $fifthRange[] = array_pop($this->fifthRange);
            }
            $i++;
        } 
        return ['first_range' => $firstRange, 'second_range' => $secondRange, 'third_range' => $thirdRange, 'fourth_range' => $fourthRange, 'fifth_range' => $fifthRange];
    }
    
}