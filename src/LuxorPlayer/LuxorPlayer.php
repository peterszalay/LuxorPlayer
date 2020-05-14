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
    
    
    /**
     * Play luxor with parameters given in file
     * 
     * @return array
     */
    public function playFromConfig(){
        try {
            $file = include  __DIR__ . '/../../config/luxor.php';
            if(isset($file['game_variables'])){
                $drawCount = (isset($file['game_variables']['draws']) && is_int($file['game_variables']['draws']) && $file['game_variables']['draws'] > 1) ? $file['game_variables']['draws'] : 1;
                $ticketCount = (isset($file['game_variables']['tickets']) && is_int($file['game_variables']['tickets']) && $file['game_variables']['tickets'] > 1) ? $file['game_variables']['tickets'] : 1;
            } else {
            }
        } catch(\Exception $ex){
        }
    }
    
    /**
     * Play luxor with manually given parameters
     * 
     * @param int $drawCount
     * @param int $ticketCount
     * @param int $previousDrawsToSelectFrom
     * @param string $ordering
     * @param array $selections
     * @param int $repeatTimes
     * @return array
     */
    public function play($drawCount, $ticketCount, $previousDrawsToSelectFrom, $ordering, $selections, $repeatTimes){
        $i = 1;
        $results = $this->initializeResults($ordering, $selections);
        
        $this->setDrawCount($drawCount);
        $this->setTicketCount($ticketCount);
        
        while($i <= $repeatTimes){
            $drawResult = $this->playWithRandomNumbers();
            $results['SAME_RANDOM']['total'] += $drawResult['pictures'] + (30 * $drawResult['frames']) + (100 * $drawResult['first_picture']) + (1000 * $drawResult['first_frame']) + (7000 * $drawResult['luxor']) + (40000 * $drawResult['jackpot']);
            $results['SAME_RANDOM']['pictures'] += $drawResult['pictures'];
            $results['SAME_RANDOM']['frames'] += $drawResult['frames'];
            $results['SAME_RANDOM']['first_picture'] += $drawResult['first_picture'];
            $results['SAME_RANDOM']['first_frame'] += $drawResult['first_frame'];
            $results['SAME_RANDOM']['luxor'] += $drawResult['luxor'];
            $results['SAME_RANDOM']['jackpot'] += $drawResult['jackpot'];
            
            $drawResult = $this->playWithRandomNumbers(true);
            $results['REGENERATED_RANDOM']['total'] += $drawResult['pictures'] + (30 * $drawResult['frames']) + (100 * $drawResult['first_picture']) + (1000 * $drawResult['first_frame']) + (7000 * $drawResult['luxor']) + (40000 * $drawResult['jackpot']);
            $results['REGENERATED_RANDOM']['pictures'] += $drawResult['pictures'];
            $results['REGENERATED_RANDOM']['frames'] += $drawResult['frames'];
            $results['REGENERATED_RANDOM']['first_picture'] += $drawResult['first_picture'];
            $results['REGENERATED_RANDOM']['first_frame'] += $drawResult['first_frame'];
            $results['REGENERATED_RANDOM']['luxor'] += $drawResult['luxor'];
            $results['REGENERATED_RANDOM']['jackpot'] += $drawResult['jackpot'];

            $drawResult = [];
            switch($ordering){
                case "LEAST_DRAWN":
                    $key = 'LEAST_DRAWN_' . $selections['first'];
                    $drawResult = $this->playWithSelectedNumbers($previousDrawsToSelectFrom, $selections['first'], "LEAST_DRAWN");
                    break;
                case "MOST_DRAWN":
                    $key = 'MOST_DRAWN_' . $selections['first'];
                    $drawResult = $this->playWithSelectedNumbers($previousDrawsToSelectFrom, $selections['first'], "MOST_DRAWN");
                    break;
                case "LEAST_DRAWN_AND_RANDOM":
                    $key = 'LEAST_DRAWN_AND_RANDOM_L' . $selections['first'] . '_R' . $selections['second'];
                    $drawResult = $this->playWithSelectedNumbers($previousDrawsToSelectFrom, $selections['first'], "LEAST_DRAWN_AND_RANDOM", $selections['second']);
                    break;
                case "MOST_DRAWN_AND_RANDOM":
                    $key = 'MOST_DRAWN_AND_RANDOM_M' . $selections['first'] . '_R' . $selections['second'];
                    $drawResult = $this->playWithSelectedNumbers($previousDrawsToSelectFrom, $selections['first'], "MOST_DRAWN_AND_RANDOM", $selections['second']);
                    break;
                case "LEAST_AND_MOST_DRAWN":
                    $key = 'LEAST_AND_MOST_DRAWN_L' . $selections['first'] . '_M' . $selections['second'];
                    $drawResult = $this->playWithSelectedNumbers($previousDrawsToSelectFrom, $selections['first'], "LEAST_AND_MOST_DRAWN", $selections['second']);
                    break;
                case "MOST_LEAST_AND_RANDOM":
                    $key = 'MOST_LEAST_AND_RANDOM_M' . $selections['first'] . '_L' . $selections['second'] . '_R' . $selections['third'];
                    $drawResult = $this->playWithSelectedNumbers($previousDrawsToSelectFrom, $selections['first'], "MOST_LEAST_AND_RANDOM", $selections['second'], $selections['third']);
                    break;
            }
            $results[$key]['total'] += $drawResult['pictures'] + (30 * $drawResult['frames']) + (100 * $drawResult['first_picture']) + (1000 * $drawResult['first_frame']) + (7000 * $drawResult['luxor']) + (40000 * $drawResult['jackpot']);
            $results[$key]['pictures'] += $drawResult['pictures'];
            $results[$key]['frames'] += $drawResult['frames'];
            $results[$key]['first_picture'] += $drawResult['first_picture'];
            $results[$key]['first_frame'] += $drawResult['first_frame'];
            $results[$key]['luxor'] += $drawResult['luxor'];
            $results[$key]['jackpot'] += $drawResult['jackpot'];
            
            $i++;
        }
        uasort($results, [$this, 'orderByTotal']);
        return $results;
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

    public function generateNumbers($previousDrawsToSelectFrom, $firstSelection, $ordering = "MOST_DRAWN", $secondSelection = 0, $thirdSelection = 0){
        $this->fileProcessor->readFileIntoArray($previousDrawsToSelectFrom);
        $draws = $this->fileProcessor->getDrawResults();
        $selection = [];
        switch($ordering){
            case "LEAST_DRAWN":
                $selection = $this->drawProcessor->getLeastDrawnNumbers($draws, $firstSelection);
                break;
            case "LEAST_AND_MOST_DRAWN":
                $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($draws, $firstSelection);
                $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($draws, $secondSelection);
                $selection = $this->ticketGenerator->mergeTwofSelections($leastDrawnSelection, $mostDrawnSelection);
                break;
            case "LEAST_DRAWN_AND_RANDOM":
                $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($draws, $firstSelection);
                $randomSelection = $this->ticketGenerator->generateRandomSelection($secondSelection);
                $selection = $this->ticketGenerator->mergeTwofSelections($leastDrawnSelection, $randomSelection);
                break;
            case "MOST_DRAWN_AND_RANDOM":
                $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($draws, $firstSelection);
                $randomSelection = $this->ticketGenerator->generateRandomSelection($secondSelection);
                $selection = $this->ticketGenerator->mergeTwofSelections($mostDrawnSelection, $randomSelection);
                break;
            case "MOST_LEAST_AND_RANDOM":
                $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($draws, $firstSelection);
                $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($draws, $secondSelection);
                $randomSelection = $this->ticketGenerator->generateRandomSelection($thirdSelection);
                $selection1 = $this->ticketGenerator->mergeTwofSelections($mostDrawnSelection, $leastDrawnSelection);
                $selection = $this->ticketGenerator->mergeTwofSelections($selection1, $randomSelection);
                break;
            case "MOST_DRAWN": default:
                $selection = $this->drawProcessor->getMostDrawnNumbers($draws, $firstSelection);
        }
        return $selection;
    }
    
    /**
     * Initialize results array to hold results
     * 
     * @param string $ordering
     * @param array $selections
     * @return array
     */
    private function initializeResults($ordering, $selections){
        $results = [];
        $startValue = ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0];
        $firstSelection = isset($selections['first']) ? intval($selections['first']) : 0;
        $secondSelection = isset($selections['second']) ? intval($selections['second']) : 0;
        $thirdSelection = isset($selections['third']) ? intval($selections['third']) : 0;
        
        $results["SAME_RANDOM"] = $startValue;
        $results["REGENERATED_RANDOM"] = $startValue;
        switch($ordering){
            case "LEAST_DRAWN":
                $results[$ordering . '_' . $firstSelection] = $startValue;
                break;
            case "MOST_DRAWN":
                $results[$ordering . '_' . $firstSelection] = $startValue;
                break;
            case "LEAST_DRAWN_AND_RANDOM":
                $results[$ordering . '_L' . $firstSelection . '_R' . $secondSelection] = $startValue;
                break;
            case "MOST_DRAWN_AND_RANDOM":
                $results[$ordering . '_M' . $firstSelection . '_R' . $secondSelection] = $startValue;
                break;
            case "LEAST_AND_MOST_DRAWN":
                $results[$ordering . '_L' . $firstSelection . '_M' . $secondSelection] = $startValue;
                break;
            case "MOST_LEAST_AND_RANDOM":
                $results[$ordering . '_M' . $firstSelection . '_L' . $secondSelection . '_R' . $thirdSelection] =  $startValue;
                break;
        }
        return $results;
    }
    
    /**
     * Helper function that orders array elements by value of total
     * 
     * @param array $a
     * @param array $b
     * @return number
     */
    private function orderByTotal($a, $b){
        if($a['total'] < $b['total']){
            return 1;
        }else if($a['total'] > $b['total']){
            return -1;
        }
        return 0;
    }
}