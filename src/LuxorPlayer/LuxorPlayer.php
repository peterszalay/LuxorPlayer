<?php
namespace LuxorPlayer;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;


class LuxorPlayer {
   
    private $fileDownloader;
    private $fileProcessor;
    private $ticketGenerator;
    private $drawProcessor;
    private $game;
    /**
     * User set variables
     */
    private $drawCount = 0;
    private $ticketCount = 0;
    private $gameType;
    
    public function init(){
        $this->fileDownloader = new FileDownloader();
        $this->fileProcessor = new FileProcessor();
        $this->ticketGenerator = new LuxorTicketGenerator();
        $this->drawProcessor = new DrawProcessor();
        $this->fileDownloader->downloadCsv();
    }
    
    public function play(){
                
    }
    
    /**
     * Play with random numbers
     * 
     * @param boolean $regenerateTicketsBeforeEveryDraw
     */
    public function playWithRandomNumbers($regenerateTicketsBeforeEveryDraw = false){
        $this->game = new LuxorGame();
        if($regenerateTicketsBeforeEveryDraw){
            $this->fileProcessor->readFileIntoArray($this->drawCount);
            $draws = $this->fileProcessor->getDrawResults();
            foreach($draws as $draw){
                $this->ticketGenerator->generateTicketsWithRandomNumbers($this->ticketCount);
                $this->game->processTicketsForADraw($this->ticketGenerator->getTickets(), $draw);
            }
            return $this->game->getResults();
        } else {
            $this->fileProcessor->readFileIntoArray($this->drawCount);
            $this->ticketGenerator->generateTicketsWithRandomNumbers($this->ticketCount);
            $results = $this->game->processTicketsForDraws($this->ticketGenerator->getTickets(), $this->fileProcessor->getDrawResults());
            return $results;
        }
    }

    /**
     * @param mixed $drawCount
     */
    public function setDrawCount($drawCount)
    {
        $this->drawCount = $drawCount;
    }

    /**
     * @param number $ticketCount
     */
    public function setTicketCount($ticketCount)
    {
        $this->ticketCount = $ticketCount;
    }

    /**
     * @param mixed $gameType
     */
    public function setGameType($gameType)
    {
        $this->gameType = $gameType;
    }

    
    
    
}