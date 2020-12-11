<?php
namespace LuxorPlayer;


class LuxorGame
{
    private array $results = [];
    private int $drawNumber = 1;
    
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
     * @return array
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
     * Process one ticket, compare ticket's numbers to draw numbers
     * 
     * @param LuxorTicket $ticket
     * @param array $draw
     */
    public function processTicket(LuxorTicket $ticket, array $draw) :void
    {
        $ticketCopy = clone $ticket;
        while($draw[0]['luxor'] >= $this->drawNumber){
            $number = array_search($this->drawNumber, $draw[1]);
            $this->checkAndRemoveNumberIfInPicture($draw, $number, $ticketCopy);
            $this->checkAndRemoveNumberIfInFrame($draw, $number, $ticketCopy);
            $this->checkIfBothPictureANdFrameIsEmpty($draw, $ticketCopy);
            $this->drawNumber++;
        }  
    }

    /**
     * Check and remove number if in picture part of ticket
     *
     * @param array $draw
     * @param int $number
     * @param LuxorTicket $ticket
     */
    private function checkAndRemoveNumberIfInPicture(array $draw, int $number, LuxorTicket $ticket) :void
    {
        if(in_array($number, $ticket->getPicture())){
            $ticket->removeNumberFromPicture($number);
            if(empty($ticket->getPicture())){
                if($this->drawNumber <= $draw[0]['first_picture'] && !in_array($draw[0]['date'], $this->results['first_picture_dates'])){
                    $this->updateFirstPictureResult($draw);
                }
                $this->updatePicturesResult($draw);
            }
        }
    }

    /**
     * Check and remove number if in frame part of ticket
     *
     * @param array $draw
     * @param int $number
     * @param LuxorTicket $ticket
     */
    private function checkAndRemoveNumberIfInFrame(array $draw, int $number, LuxorTicket $ticket) :void
    {
        if(in_array($number, $ticket->getFrame())){
            $ticket->removeNumberFromFrame($number);
            if(empty($ticket->getFrame())){
                if($this->drawNumber <= $draw[0]['first_frame'] && !in_array($draw[0]['date'], $this->results['first_frame_dates'])){
                    $this->updateFirstFrameResult($draw);
                }
                $this->updateFramesResult($draw);
            }
        }
    }

    /**
     * If both picture and frame are empty we have a luxor and possibly a jackpot
     *
     * @param array $draw
     * @param LuxorTicket $ticket
     */
    private function checkIfBothPictureANdFrameIsEmpty(array $draw, LuxorTicket $ticket) :void
    {
        if(empty($ticket->getFrame()) && empty($ticket->getPicture())){
            if($this->drawNumber <= $draw[0]['jackpot_limit'] && !in_array($draw[0]['date'], $this->results['luxor_dates'])){
                $this->updateJackPotResult($draw);
                $this->updateLuxorResult($draw);
                return;
            } elseif(!in_array($draw[0]['date'], $this->results['luxor_dates'])) {
                $this->updateLuxorResult($draw);
                return;
            }
        }
    }

    private function updateFirstFrameResult($draw) :void
    {
        $this->results['first_frame']++;
        $this->results['first_frame_dates'][] = $draw[0]['date'];
    }

    private function updateFramesResult($draw) :void
    {
        $this->results['frames']++;
        $this->results['frame_dates'][] = $draw[0]['date'];
    }

    private function updateFirstPictureResult($draw) :void
    {
        $this->results['first_picture']++;
        $this->results['first_picture_dates'][] = $draw[0]['date'];
    }

    private function updatePicturesResult($draw) :void
    {
        $this->results['pictures']++;
        $this->results['picture_dates'][] = $draw[0]['date'];
    }

    private function updateLuxorResult($draw) :void
    {
        $this->results['luxor_dates'][] = $draw[0]['date'];
        $this->results['luxor']++;
    }

    private function updateJackPotResult($draw) :void
    {
        $this->results['jackpot_dates'][] = $draw[0]['date'];
        $this->results['jackpot']++;
    }
    
}