<?php
namespace LuxorPlayer;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;


class LuxorGame {
    
    private $name = "Luxor Game";
    private $logger;
    private $results = [];
    
    public function __construct(){
        $this->logger = new Logger($this->name);
        $this->results['jackpot'] = 0;
        $this->results['luxor'] = 0; 
        $this->results['first_frame'] = 0; 
        $this->results['first_picture'] = 0; 
        $this->results['frames'] = 0; 
        $this->results['pictures'] = 0;
    }
    
    /**
     * Get results
     * 
     * @return array
     */
    public function getResults(){
        return $this->results;
    }
    
    /**
     * Compare tickets and draws
     * 
     * @param array $tickets
     * @param array $draws
     * @return array $results
     */
    public function processTicketsForDraws($tickets, $draws){
        foreach($draws as $draw){
            $this->processTicketsForADraw($tickets, $draw);
        }
        return $this->results;
    }
    
    /**
     * Compare tickets to single draw
     * 
     * @param array $tickets
     * @param array $draw
     */
    public function processTicketsForADraw($tickets, $draw){
        foreach($tickets as $ticket){
            $this->processTicket($ticket, $draw);    
        }
    }
    
    /**
     * Process one ticket, compare ticket's numbers to drawn numbers 
     * 
     * @param array $ticket
     * @param array $draw
     */
    public function processTicket($ticket, $draw){
        $drawNumber = 1;
        $ticketCopy = clone $ticket; //cloned because ticket could be used in more than one draw
        while($draw[0]['luxor'] >= $drawNumber){
            $number = array_search($drawNumber, $draw[1]);
            if(in_array($number, $ticketCopy->picture)){
                $key = array_search($number, $ticketCopy->picture);
                unset($ticketCopy->picture[$key]);
                if(empty($ticketCopy->picture)){
                    if($drawNumber <= $draw[0]['first_picture']){
                        $this->results['first_picture']++;
                    }
                    $this->results['pictures']++;
                }
            }
            if(in_array($number, $ticketCopy->frame)){
                $key = array_search($number, $ticketCopy->frame);
                unset($ticketCopy->frame[$key]);
                if(empty($ticketCopy->frame)){
                    if($drawNumber <= $draw[0]['first_frame']){
                        $this->results['first_frame']++;
                    }
                    $this->results['frames']++;
                }
            }
            if(empty($ticketCopy->frame) && empty($ticketCopy->picture)){
                if($drawNumber <= $draw[0]['jackpot_limit']){
                    $this->results['jackpot']++;
                    $this->results['luxor']++;
                    break;
                } else {
                    $this->results['luxor']++;
                    break;
                }
            }
            $drawNumber++;
        }  
    }
    
}