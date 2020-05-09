<?php
namespace LuxorPlayer;


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
        $this->fileProcessor->readFileIntoArray($this->drawCount);
        $draws = $this->fileProcessor->getDrawResults();
        if($regenerateTicketsBeforeEveryDraw){
            foreach($draws as $draw){
                $this->ticketGenerator->generateTicketsWithRandomNumbers($this->ticketCount);
                $this->game->processTicketsForADraw($this->ticketGenerator->getTickets(), $draw);
            }
            return $this->game->getResults();
        } else {
            $this->ticketGenerator->generateTicketsWithRandomNumbers($this->ticketCount);
            $results = $this->game->processTicketsForDraws($this->ticketGenerator->getTickets(), $draws);
            return $results;
        }
    }
    
    /**
     * Play with selected numbers
     * 
     * @param int $previousDrawsToSelectFrom
     * @param int $firstSelection
     * @param string $ordering
     * @param int $secondSelection
     * @return array
     */
    public function playWithSelectedNumbers($previousDrawsToSelectFrom, $firstSelection, $ordering = "MOST_DRAWN", $secondSelection = 0, $thirdSelection = 0){
        $this->game = new LuxorGame();
        $this->fileProcessor->readFileIntoArray($this->drawCount + $previousDrawsToSelectFrom);
        $draws = array_reverse($this->fileProcessor->getDrawResults());
        for($i = 0; $i < $this->drawCount; $i++){
            $lastDraw = array_pop($draws);
            $previousDraws = array_slice($draws, -($previousDrawsToSelectFrom), $previousDrawsToSelectFrom, true);
            switch($ordering){
                case "LEAST_DRAWN":
                    $selection = $this->drawProcessor->getLeastDrawnNumbers($previousDraws, $firstSelection);
                    break;
                case "LEAST_AND_MOST_DRAWN":
                    $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($previousDraws, $firstSelection);
                    $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($previousDraws, $secondSelection);
                    $selection = $this->ticketGenerator->mergeTwofSelections($leastDrawnSelection, $mostDrawnSelection);
                    break;
                case "LEAST_DRAWN_AND_RANDOM":
                    $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($previousDraws, $firstSelection);
                    $randomSelection = $this->ticketGenerator->generateRandomSelection($secondSelection);
                    $selection = $this->ticketGenerator->mergeTwofSelections($leastDrawnSelection, $randomSelection);
                    break;
                case "MOST_DRAWN_AND_RANDOM":
                    $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($previousDraws, $firstSelection);
                    $randomSelection = $this->ticketGenerator->generateRandomSelection($secondSelection);
                    $selection = $this->ticketGenerator->mergeTwofSelections($mostDrawnSelection, $randomSelection);
                    break;
                case "MOST_LEAST_AND_RANDOM":
                    $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($previousDraws, $firstSelection);
                    $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($previousDraws, $secondSelection);
                    $randomSelection = $this->ticketGenerator->generateRandomSelection($thirdSelection);
                    $selection1 = $this->ticketGenerator->mergeTwofSelections($mostDrawnSelection, $leastDrawnSelection);
                    $selection = $this->ticketGenerator->mergeTwofSelections($selection1, $randomSelection);
                    break;
                case "MOST_DRAWN": default:
                    $selection = $this->drawProcessor->getMostDrawnNumbers($previousDraws, $firstSelection);
            }
            $this->ticketGenerator->generateTicketsWithRandomNumbersFromSelection($this->ticketCount, $selection);
            $this->game->processTicketsForADraw($this->ticketGenerator->getTickets(), $lastDraw);
        }
        return $this->game->getResults();
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