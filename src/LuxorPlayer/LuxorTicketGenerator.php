<?php
namespace LuxorPlayer;


class LuxorTicketGenerator
{
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
     * Generate number of tickets with randomly selected numbers
     *
     * @param int $numberOfTickets
     * @param bool $enforceOddEvenRatio
     */
    public function generateTicketsWithRandomNumbers(int $numberOfTickets, bool $enforceOddEvenRatio = false) :void
    {
        $this->tickets = [];
        for($i = 0; $i < $numberOfTickets; $i++){
            $this->tickets[$i] = $this->generateTicketWithRandomNumbers($enforceOddEvenRatio);     
        }
    }
    
    /**
     * Generate number of tickets with randomly selected numbers from selection
     * 
     * @param int $numberOfTickets
     * @param array $selection
     */
    public function generateTicketsWithRandomNumbersFromSelection(int $numberOfTickets, array $selection) :void
    {
        $this->tickets = [];
        for($i = 0; $i < $numberOfTickets; $i++){
            $this->tickets[$i] = $this->generateTicketWithRandomNumbersFromSelection($selection);
        }
    }

    /**
     * Generate one ticket populated with random numbers
     *
     * @param bool $enforceOddEvenRatio
     * @return LuxorTicket
     * @todo implement force odd even ratio, force prime ratio functionality
     */
    public function generateTicketWithRandomNumbers(bool $enforceOddEvenRatio = false) :LuxorTicket
    {
        $this->fillRanges();
        return $this->generateTicketWithRandomNumberUsingRanges($enforceOddEvenRatio);
    }
    
    /**
     * Generate ticket from selection of number split into 5 ranges
     * 
     * @param array $selection
     * @return LuxorTicket
     */
    public function generateTicketWithRandomNumbersFromSelection(array $selection) :LuxorTicket
    {
        $this->fillRanges($selection);
        return $this->generateTicketWithRandomNumberUsingRanges();
    }

    /**
     * Generates ticket with random numbers using the five ranges
     *
     * @param bool $oddEven
     * @return LuxorTicket
     */
    private function generateTicketWithRandomNumberUsingRanges(bool $oddEven = false) :LuxorTicket
    {
        $frame = [];
        $picture = [];
        $i = 1;
        $oddCount = 0;
        $evenCount = 0;
        while($i <= 20){
            if($i <= 4){
                shuffle($this->firstRange);
                if($oddEven){
                    if($oddCount == 3){
                        while($this->firstRange[sizeof($this->firstRange)-1] % 2 != 0){
                            shuffle($this->firstRange);
                        }
                    }
                    if($evenCount == 3){
                        while($this->firstRange[sizeof($this->firstRange)-1] % 2 == 0){
                            shuffle($this->firstRange);
                        }
                    }
                }
                $number = array_pop($this->firstRange);
                if($number % 2 != 0){
                    $oddCount++;
                } else {
                    $evenCount++;
                }
                $frame[] = $number;
            } elseif ($i <= 8){
                shuffle($this->secondRange);
                if($oddEven){
                    if($oddCount == 5){
                        while($this->secondRange[sizeof($this->secondRange)-1] % 2 != 0){
                            shuffle($this->secondRange);
                        }
                    }
                    if($evenCount == 5){
                        while($this->secondRange[sizeof($this->secondRange)-1] % 2 == 0){
                            shuffle($this->secondRange);
                        }
                    }
                }
                $number = array_pop($this->secondRange);
                if($number % 2 != 0){
                    $oddCount++;
                } else {
                    $evenCount++;
                }
                if($i <= 6){
                    $frame[] = $number;
                } else {
                    $picture[] = $number;
                }
            } elseif($i <= 12){
                shuffle($this->thirdRange);
                if($oddEven){
                    if($oddCount == 7){
                        while($this->thirdRange[sizeof($this->thirdRange)-1] % 2 != 0){
                            shuffle($this->thirdRange);
                        }
                    }
                    if($evenCount == 7){
                        while($this->thirdRange[sizeof($this->thirdRange)-1] % 2 == 0){
                            shuffle($this->thirdRange);
                        }
                    }
                }
                $number = array_pop($this->thirdRange);
                if($number % 2 != 0){
                    $oddCount++;
                } else {
                    $evenCount++;
                }
                if($i <= 10){
                    $frame[] = $number;
                } else {
                    $picture[] = $number;
                }
            } elseif($i <= 16){
                shuffle($this->fourthRange);
                if($oddEven){
                    if($oddCount == 9){
                        while($this->fourthRange[sizeof($this->fourthRange)-1] % 2 != 0){
                            shuffle($this->fourthRange);
                        }
                    }
                    if($evenCount == 9){
                        while($this->fourthRange[sizeof($this->fourthRange)-1] % 2 == 0){
                            shuffle($this->fourthRange);
                        }
                    }
                }
                $number = array_pop($this->fourthRange);
                if($number % 2 != 0){
                    $oddCount++;
                } else {
                    $evenCount++;
                }
                if($i <= 14){
                    $frame[] = $number;
                } else {
                    $picture[] = $number;
                }
            } else {
                shuffle($this->fifthRange);
                if($oddEven){
                    if($oddCount == 11){
                        while($this->fifthRange[sizeof($this->fifthRange)-1] % 2 != 0){
                            shuffle($this->fifthRange);
                        }
                    }
                    if($evenCount == 11){
                        while($this->fifthRange[sizeof($this->fifthRange)-1] % 2 == 0){
                            shuffle($this->fifthRange);
                        }
                    }
                }
                $number = array_pop($this->fifthRange);
                if($number % 2 != 0){
                    $oddCount++;
                } else {
                    $evenCount++;
                }
                $frame[] = $number;
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
    private function putNumberInFrameOrPicture(int $number, array &$range, array &$pictureOrFrame) :void
    {
        $pictureOrFrame[] = $number;
        $key = array_search($number, $range);
        unset($range[$key]);
    }
    
    /**
     * Fill ranges with the 75 numbers
     * 
     * @param array $selection
     */
    private function fillRanges(array $selection = []) :void
    {
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
    public function mergeTwoSelections(array $selection1, array $selection2) :array
    {
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
    public function generateRandomSelection(int $size) :array
    {
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