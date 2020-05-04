<?php
namespace LuxorPlayer;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;


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
        $this->logger = new Logger($this->name);
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
        for($i = 0; $i < $numberOfTickets; $i++){
            $this->tickets[$i] = $this->generateTicketWithRandomNumbers();     
        }
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/game.log', Logger::INFO));
        $this->logger->info($numberOfTickets. " number of tickets with random numbers generated...");
    }
    
    /**
     * Generate number of tickets with randomly selected numbers from selection
     * 
     * @param int $numberOfTickets
     * @param array $selection
     */
    public function generateTicketsFromSelection($numberOfTickets, $selection){
        for($i = 0; $i < $numberOfTickets; $i++){
            $this->tickets[$i] = $this->generateTicketFromSelection($selection);
        }
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/game.log', Logger::INFO));
        $this->logger->info($numberOfTickets. " number of tickets with random numbers from selection generated...");
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
        $frame = [];
        $picture = [];
        $i = 1;
        while($i <= 20){
            if($i <= 4){
                $randomNumber = mt_rand(1,15);
                if(in_array($randomNumber, $this->firstRange)){
                    $this->putNumberInFrameOrPicture($randomNumber, $this->firstRange, $frame);
                    $i++;
                }
            } elseif ($i <= 8){
                $randomNumber = mt_rand(16,30);
                if($i <= 6){
                    if(in_array($randomNumber, $this->secondRange)){
                        $this->putNumberInFrameOrPicture($randomNumber, $this->secondRange, $frame);
                        $i++;
                    }
                } else {
                    if(in_array($randomNumber, $this->secondRange)){
                        $this->putNumberInFrameOrPicture($randomNumber, $this->secondRange, $picture);
                        $i++;
                    }
                }
                
            } elseif($i <= 12){
                $randomNumber = mt_rand(31,45);
                if($i <= 10){
                    if(in_array($randomNumber, $this->thirdRange)){
                        $this->putNumberInFrameOrPicture($randomNumber, $this->thirdRange, $frame);
                        $i++;
                    }
                } else {
                    if(in_array($randomNumber, $this->thirdRange)){
                        $this->putNumberInFrameOrPicture($randomNumber, $this->thirdRange, $picture);
                        $i++;
                    }
                }
            } elseif($i <= 16){
                $randomNumber = mt_rand(46,60);
                if($i <= 14){
                    if(in_array($randomNumber, $this->fourthRange)){
                        $this->putNumberInFrameOrPicture($randomNumber, $this->fourthRange, $frame);
                        $i++;
                    }
                } else {
                    if(in_array($randomNumber, $this->fourthRange)){
                        $this->putNumberInFrameOrPicture($randomNumber, $this->fourthRange, $picture);
                        $i++;
                    }
                }
            } else {
                $randomNumber = mt_rand(61,75);
                if(in_array($randomNumber, $this->fifthRange)){
                    $this->putNumberInFrameOrPicture($randomNumber, $this->fifthRange, $frame);
                    $i++;
                }
            }
        } 
        return LuxorTicket::create($picture, $frame);
    }
    
    /**
     * Generate ticket from selection of number split into 5 ranges
     * 
     * @param array $selection
     * @return \LuxorPlayer\LuxorTicket
     */
    public function generateTicketFromSelection($selection){
        $frame = [];
        $picture = [];
        $i = 1;
        $this->firstRange = $selection['first_range'];
        $this->secondRange = $selection['second_range'];
        $this->thirdRange = $selection['third_range'];
        $this->fourthRange = $selection['fourth_range'];
        $this->fifthRange = $selection['fifth_range'];
        while($i <= 20){
            if($i <= 4){
                shuffle($this->firstRange);
                $frame[] = array_pop($this->firstRange);
                $i++;
            } elseif ($i <= 8){
                shuffle($this->secondRange);
                if($i <= 6){   
                    $frame[] = array_pop($this->secondRange);
                    $i++;
                } else {
                    $picture[] = array_pop($this->secondRange);
                    $i++;
                }          
            } elseif($i <= 12){
                shuffle($this->thirdRange);
                if($i <= 10){
                    $frame[] = array_pop($this->thirdRange);
                    $i++;
                } else {
                    $picture[] = array_pop($this->thirdRange);
                    $i++;
                }
            } elseif($i <= 16){
                shuffle($this->fourthRange);
                if($i <= 14){ 
                    $frame[] = array_pop($this->fourthRange);
                    $i++;
                } else {
                    $picture[] = array_pop($this->fourthRange);
                    $i++;
                }
            } else {
                shuffle($this->fifthRange);
                $frame[] = array_pop($this->fifthRange);
                $i++;
            }
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
     */
    private function fillRanges(){
        $this->firstRange = range(1,15);
        $this->secondRange = range(16,30);
        $this->thirdRange = range(31,45);
        $this->fourthRange = range(46,60);
        $this->fifthRange = range(61,75);
    }
    
}