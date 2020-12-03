<?php
namespace LuxorPlayer;


class LuxorGame
{
    private array $results = [];
    
    public function __construct()
    {
        $this->results['jackpot'] = 0;
        $this->results['luxor'] = 0; 
        $this->results['first_frame'] = 0; 
        $this->results['first_picture'] = 0; 
        $this->results['frames'] = 0; 
        $this->results['pictures'] = 0;
        $this->results['luxor_dates'] = [];
        $this->results['jackpot_dates'] = [];
        $this->results['first_frame_dates'] = [];
        $this->results['first_picture_dates'] = [];
        $this->results['frame_dates'] = [];
        $this->results['picture_dates'] = [];
    }
    
    /**
     * Get results
     * 
     * @return array
     */
    public function getResults() :array
    {
        return $this->results;
    }
    
    /**
     * Compare tickets and draws
     * 
     * @param array $tickets
     * @param array $draws
     * @return array $results
     */
    public function processTicketsForDraws(array $tickets, array $draws) :array
    {
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
    public function processTicketsForADraw(array $tickets, array $draw) :void
    {
        foreach($tickets as $ticket){
            $this->processTicket($ticket, $draw);    
        }
    }
    
    /**
     * Process one ticket, compare ticket's numbers to drawn numbers 
     * 
     * @param LuxorTicket $ticket
     * @param array $draw
     */
    public function processTicket(LuxorTicket $ticket, array $draw) :void
    {
        $drawNumber = 1;
        $ticketCopy = clone $ticket;
        while($draw[0]['luxor'] >= $drawNumber){
            $number = array_search($drawNumber, $draw[1]);
            if(in_array($number, $ticketCopy->picture)){
                $key = array_search($number, $ticketCopy->picture);
                unset($ticketCopy->picture[$key]);
                if(empty($ticketCopy->picture)){
                    if($drawNumber <= $draw[0]['first_picture'] && !in_array($draw[0]['date'], $this->results['first_picture_dates'])){
                        $this->results['first_picture']++;
                        $this->results['first_picture_dates'][] = $draw[0]['date'];
                    }
                    $this->results['pictures']++;
                    $this->results['picture_dates'][] = $draw[0]['date'];
                }
            }
            if(in_array($number, $ticketCopy->frame)){
                $key = array_search($number, $ticketCopy->frame);
                unset($ticketCopy->frame[$key]);
                if(empty($ticketCopy->frame)){
                    if($drawNumber <= $draw[0]['first_frame'] && !in_array($draw[0]['date'], $this->results['first_frame_dates'])){
                        $this->results['first_frame']++;
                        $this->results['first_frame_dates'][] = $draw[0]['date'];
                    }
                    $this->results['frames']++;
                    $this->results['frame_dates'][] = $draw[0]['date'];
                }
            }
            if(empty($ticketCopy->frame) && empty($ticketCopy->picture)){
                if($drawNumber <= $draw[0]['jackpot_limit'] && !in_array($draw[0]['date'], $this->results['luxor_dates'])){
                    $this->results['jackpot_dates'][] = $draw[0]['date'];
                    $this->results['luxor_dates'][] = $draw[0]['date'];
                    $this->results['jackpot']++;
                    $this->results['luxor']++;
                    break;
                } elseif(!in_array($draw[0]['date'], $this->results['luxor_dates'])) {
                    $this->results['luxor_dates'][] = $draw[0]['date'];
                    $this->results['luxor']++;
                    break;
                }
            }
            $drawNumber++;
        }  
    }
    
}