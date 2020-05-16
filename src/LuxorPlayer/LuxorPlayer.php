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
                $i = 1;
                $drawCount = (isset($file['game_variables']['draws']) && is_int($file['game_variables']['draws']) && $file['game_variables']['draws'] > 1) ? $file['game_variables']['draws'] : 1;
                $ticketCount = (isset($file['game_variables']['tickets']) && is_int($file['game_variables']['tickets']) && $file['game_variables']['tickets'] > 1) ? $file['game_variables']['tickets'] : 1;
                $repeatTimes = (isset($file['game_variables']['repeat']) && is_int($file['game_variables']['repeat']) && $file['game_variables']['repeat'] > 1) ? $file['game_variables']['repeat'] : 1;
                $strategies = (isset($file['game_variables']['strategies']) && is_array($file['game_variables']['strategies'])) ? $file['game_variables']['strategies'] : [];
                $previousDraws = (isset($file['game_variables']['previous_draws']) && is_array($file['game_variables']['previous_draws'])) ? $file['game_variables']['previous_draws'] : [];
                $selections = [];
                $selections[0] = (isset($file['game_variables']['one_selection']) && is_array($file['game_variables']['one_selection'])) ? $file['game_variables']['one_selection'] : [];
                $selections[1] = (isset($file['game_variables']['two_selections']) && is_array($file['game_variables']['two_selections'])) ? $file['game_variables']['two_selections'] : [];
                $selections[2] = (isset($file['game_variables']['three_selections']) && is_array($file['game_variables']['three_selections'])) ? $file['game_variables']['three_selections'] : [];
                
                $results = $this->initializeResultsFromConfig($strategies, $previousDraws, $selections);
                //print_r($results);
                $this->setDrawCount($drawCount);
                $this->setTicketCount($ticketCount);
                
                while($i <= $repeatTimes){
                    $drawResult = [];
                    $drawResult = $this->playWithRandomNumbers();
                    $results['SAME_RANDOM']['total'] += $drawResult['pictures'] + (30 * $drawResult['frames']) + (100 * $drawResult['first_picture']) + (1000 * $drawResult['first_frame']) + (7000 * $drawResult['luxor']) + (40000 * $drawResult['jackpot']);
                    $results['SAME_RANDOM']['pictures'] += $drawResult['pictures'];
                    $results['SAME_RANDOM']['frames'] += $drawResult['frames'];
                    $results['SAME_RANDOM']['first_picture'] += $drawResult['first_picture'];
                    $results['SAME_RANDOM']['first_frame'] += $drawResult['first_frame'];
                    $results['SAME_RANDOM']['luxor'] += $drawResult['luxor'];
                    $results['SAME_RANDOM']['jackpot'] += $drawResult['jackpot'];
                    $results['SAME_RANDOM']['luxor_dates'] += $drawResult['luxor_dates'];
                    $results['SAME_RANDOM']['first_frame_dates'] += $drawResult['first_frame_dates'];
                    $results['SAME_RANDOM']['first_picture_dates'] += $drawResult['first_picture_dates'];
                    
                    $drawResult = [];
                    $drawResult = $this->playWithRandomNumbers(true);
                    $results['REGENERATED_RANDOM']['total'] += $drawResult['pictures'] + (30 * $drawResult['frames']) + (100 * $drawResult['first_picture']) + (1000 * $drawResult['first_frame']) + (7000 * $drawResult['luxor']) + (40000 * $drawResult['jackpot']);
                    $results['REGENERATED_RANDOM']['pictures'] += $drawResult['pictures'];
                    $results['REGENERATED_RANDOM']['frames'] += $drawResult['frames'];
                    $results['REGENERATED_RANDOM']['first_picture'] += $drawResult['first_picture'];
                    $results['REGENERATED_RANDOM']['first_frame'] += $drawResult['first_frame'];
                    $results['REGENERATED_RANDOM']['luxor'] += $drawResult['luxor'];
                    $results['REGENERATED_RANDOM']['jackpot'] += $drawResult['jackpot'];
                    $results['REGENERATED_RANDOM']['luxor_dates'] += $drawResult['luxor_dates'];
                    $results['REGENERATED_RANDOM']['first_frame_dates'] += $drawResult['first_frame_dates'];
                    $results['REGENERATED_RANDOM']['first_picture_dates'] += $drawResult['first_picture_dates'];
                    
                   
                    foreach($previousDraws as $previousDraw){
                        foreach($strategies as $strategy){
                            if(in_array($strategy, ["LEAST_DRAWN", "MOST_DRAWN"])){
                                foreach($selections[0] as $selection){
                                    $drawResult = [];
                                    $key = $strategy . '_' . $previousDraw . '_' . $selection;
                                    switch($strategy){
                                        case "LEAST_DRAWN":
                                            $drawResult = $this->playWithSelectedNumbers($previousDraw, $selection, "LEAST_DRAWN");
                                            break;
                                        case "MOST_DRAWN":
                                            $drawResult = $this->playWithSelectedNumbers($previousDraw, $selection, "MOST_DRAWN");
                                            break;
                                    }
                                    $results[$key]['total'] += $drawResult['pictures'] + (30 * $drawResult['frames']) + (100 * $drawResult['first_picture']) + (1000 * $drawResult['first_frame']) + (7000 * $drawResult['luxor']) + (40000 * $drawResult['jackpot']);
                                    $results[$key]['pictures'] += $drawResult['pictures'];
                                    $results[$key]['frames'] += $drawResult['frames'];
                                    $results[$key]['first_picture'] += $drawResult['first_picture'];
                                    $results[$key]['first_frame'] += $drawResult['first_frame'];
                                    $results[$key]['luxor'] += $drawResult['luxor'];
                                    $results[$key]['jackpot'] += $drawResult['jackpot'];
                                    $results[$key]['luxor_dates'] += $drawResult['luxor_dates'];
                                    $results[$key]['first_frame_dates'] += $drawResult['first_frame_dates'];
                                    $results[$key]['first_picture_dates'] += $drawResult['first_picture_dates'];
                                    
                                }
                            } elseif(in_array($strategy, ["LEAST_DRAWN_AND_RANDOM", "MOST_DRAWN_AND_RANDOM", "LEAST_AND_MOST_DRAWN"])){
                                foreach($selections[1]['first'] as $firstSelection){
                                    foreach($selections[1]['second'] as $secondSelection){
                                        $drawResult = [];
                                        switch($strategy){
                                            case "LEAST_DRAWN_AND_RANDOM":
                                                $key = $strategy . '_' . $previousDraw . '_L' . $firstSelection . '_R' . $secondSelection;
                                                $drawResult = $this->playWithSelectedNumbers($previousDraw, $firstSelection, "LEAST_DRAWN_AND_RANDOM", $secondSelection);
                                                break;
                                            case "MOST_DRAWN_AND_RANDOM":
                                                $key = $strategy . '_' . $previousDraw . '_M' . $firstSelection . '_R' . $secondSelection;
                                                $drawResult = $this->playWithSelectedNumbers($previousDraw, $firstSelection, "MOST_DRAWN_AND_RANDOM", $secondSelection);
                                                break;
                                            case "LEAST_AND_MOST_DRAWN":
                                                $key = $strategy . '_' . $previousDraw . '_L' . $firstSelection . '_M' . $secondSelection;
                                                $drawResult = $this->playWithSelectedNumbers($previousDraw, $firstSelection, "LEAST_AND_MOST_DRAWN", $secondSelection);
                                                break;
                                        }
                                        $results[$key]['total'] += $drawResult['pictures'] + (30 * $drawResult['frames']) + (100 * $drawResult['first_picture']) + (1000 * $drawResult['first_frame']) + (7000 * $drawResult['luxor']) + (40000 * $drawResult['jackpot']);
                                        $results[$key]['pictures'] += $drawResult['pictures'];
                                        $results[$key]['frames'] += $drawResult['frames'];
                                        $results[$key]['first_picture'] += $drawResult['first_picture'];
                                        $results[$key]['first_frame'] += $drawResult['first_frame'];
                                        $results[$key]['luxor'] += $drawResult['luxor'];
                                        $results[$key]['jackpot'] += $drawResult['jackpot'];
                                        $results[$key]['luxor_dates'] += $drawResult['luxor_dates'];
                                        $results[$key]['first_frame_dates'] += $drawResult['first_frame_dates'];
                                        $results[$key]['first_picture_dates'] += $drawResult['first_picture_dates'];
                                    }
                                }
                            } elseif($strategy == "MOST_LEAST_AND_RANDOM"){
                                foreach($selections[2]['first'] as $firstSelection){
                                    foreach($selections[2]['second'] as $secondSelection){
                                        foreach($selections[2]['third'] as $thirdSelection){
                                            $drawResult = [];
                                            $key = $strategy .  '_' . $previousDraw . '_M' . $firstSelection . '_L' . $secondSelection . '_R' . $thirdSelection;
                                            $drawResult = $this->playWithSelectedNumbers($previousDraw, $firstSelection, "MOST_LEAST_AND_RANDOM", $secondSelection, $thirdSelection);
                                            
                                            $results[$key]['total'] += $drawResult['pictures'] + (30 * $drawResult['frames']) + (100 * $drawResult['first_picture']) + (1000 * $drawResult['first_frame']) + (7000 * $drawResult['luxor']) + (40000 * $drawResult['jackpot']);
                                            $results[$key]['pictures'] += $drawResult['pictures'];
                                            $results[$key]['frames'] += $drawResult['frames'];
                                            $results[$key]['first_picture'] += $drawResult['first_picture'];
                                            $results[$key]['first_frame'] += $drawResult['first_frame'];
                                            $results[$key]['luxor'] += $drawResult['luxor'];
                                            $results[$key]['jackpot'] += $drawResult['jackpot'];
                                            $results[$key]['luxor_dates'] += $drawResult['luxor_dates'];
                                            $results[$key]['first_frame_dates'] += $drawResult['first_frame_dates'];
                                            $results[$key]['first_picture_dates'] += $drawResult['first_picture_dates'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $i++;
                }                   
            } else {
            }
        } catch(\Exception $ex){
        }
        uasort($results, [$this, 'orderByTotal']);
        //$resultSlice = array_slice($results, 0, 100);
        return $results;
    }
    
    /**
     * Play luxor with manually given parameters
     * 
     * @param int $drawCount
     * @param int $ticketCount
     * @param int $previousDrawsToSelectFrom
     * @param string $strategy
     * @param array $selections
     * @param int $repeatTimes
     * @return array
     */
    public function play($drawCount, $ticketCount, $previousDrawsToSelectFrom, $strategy, $selections, $repeatTimes){
        $i = 1;
        $results = $this->initializeResults($strategy, $selections);
        
        $this->setDrawCount($drawCount);
        $this->setTicketCount($ticketCount);
        
        while($i <= $repeatTimes){
            $drawResult = [];
            $drawResult = $this->playWithRandomNumbers();
            $results['SAME_RANDOM']['total'] += $drawResult['pictures'] + (30 * $drawResult['frames']) + (100 * $drawResult['first_picture']) + (1000 * $drawResult['first_frame']) + (7000 * $drawResult['luxor']) + (40000 * $drawResult['jackpot']);
            $results['SAME_RANDOM']['pictures'] += $drawResult['pictures'];
            $results['SAME_RANDOM']['frames'] += $drawResult['frames'];
            $results['SAME_RANDOM']['first_picture'] += $drawResult['first_picture'];
            $results['SAME_RANDOM']['first_frame'] += $drawResult['first_frame'];
            $results['SAME_RANDOM']['luxor'] += $drawResult['luxor'];
            $results['SAME_RANDOM']['jackpot'] += $drawResult['jackpot'];
            $results['SAME_RANDOM']['luxor_dates'] += $drawResult['luxor_dates'];
            $results['SAME_RANDOM']['first_frame_dates'] += $drawResult['first_frame_dates'];
            $results['SAME_RANDOM']['first_picture_dates'] += $drawResult['first_picture_dates'];
            
            $drawResult = [];
            $drawResult = $this->playWithRandomNumbers(true);
            $results['REGENERATED_RANDOM']['total'] += $drawResult['pictures'] + (30 * $drawResult['frames']) + (100 * $drawResult['first_picture']) + (1000 * $drawResult['first_frame']) + (7000 * $drawResult['luxor']) + (40000 * $drawResult['jackpot']);
            $results['REGENERATED_RANDOM']['pictures'] += $drawResult['pictures'];
            $results['REGENERATED_RANDOM']['frames'] += $drawResult['frames'];
            $results['REGENERATED_RANDOM']['first_picture'] += $drawResult['first_picture'];
            $results['REGENERATED_RANDOM']['first_frame'] += $drawResult['first_frame'];
            $results['REGENERATED_RANDOM']['luxor'] += $drawResult['luxor'];
            $results['REGENERATED_RANDOM']['jackpot'] += $drawResult['jackpot'];
            $results['REGENERATED_RANDOM']['luxor_dates'] += $drawResult['luxor_dates'];
            $results['REGENERATED_RANDOM']['first_frame_dates'] += $drawResult['first_frame_dates'];
            $results['REGENERATED_RANDOM']['first_picture_dates'] += $drawResult['first_picture_dates'];
            

            $drawResult = [];
            switch($strategy){
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
            $results[$key]['luxor_dates'] += $drawResult['luxor_dates'];
            $results[$key]['first_frame_dates'] += $drawResult['first_frame_dates'];
            $results[$key]['first_picture_dates'] += $drawResult['first_picture_dates'];
            
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
        $this->fileProcessor = new FileProcessor();
        $this->fileProcessor->readFileIntoArray($this->drawCount);
        $draws = $this->fileProcessor->getDrawResults();
        if($regenerateTicketsBeforeEveryDraw){
            //print PHP_EOL . 'REGENERATED RANDOM DRAW COUNT: ' . sizeof($draws) . ' THIS DRAWCOUNT: ' . $this->drawCount . PHP_EOL;
            foreach($draws as $draw){
                $this->ticketGenerator->generateTicketsWithRandomNumbers($this->ticketCount);
                $this->game->processTicketsForADraw($this->ticketGenerator->getTickets(), $draw);
            }
            return $this->game->getResults();
        } else {
            //print PHP_EOL .'RANDOM DRAW COUNT: ' . sizeof($draws) . ' THIS DRAWCOUNT: ' . $this->drawCount . PHP_EOL;
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
     * @param string $strategy
     * @param int $secondSelection
     * @return array
     */
    public function playWithSelectedNumbers($previousDrawsToSelectFrom, $firstSelection, $strategy = "MOST_DRAWN", $secondSelection = 0, $thirdSelection = 0){
        $this->game = new LuxorGame();
        $this->fileProcessor = new FileProcessor();
        $this->fileProcessor->readFileIntoArray($this->drawCount + $previousDrawsToSelectFrom);
        $draws = array_reverse($this->fileProcessor->getDrawResults());
        //print PHP_EOL . $strategy . ' DRAW COUNT: ' . $this->drawCount . PHP_EOL;
        for($i = 0; $i < $this->drawCount; $i++){
            $lastDraw = array_pop($draws);
            $previousDraws = array_slice($draws, -($previousDrawsToSelectFrom), $previousDrawsToSelectFrom, true);
            switch($strategy){
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
        $results = $this->game->getResults();
        if($results['luxor'] >= 1){
            print $strategy . ' ' . $previousDrawsToSelectFrom . ' ' . $firstSelection . ' ' . $secondSelection . ' ' . $thirdSelection . PHP_EOL;
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
     * Generate numbers for strategy
     * 
     * @param int $previousDrawsToSelectFrom
     * @param int $firstSelection
     * @param string $strategy
     * @param int $secondSelection
     * @param int $thirdSelection
     * @return array
     */
    public function generateNumbers($previousDrawsToSelectFrom, $firstSelection, $strategy = "MOST_DRAWN", $secondSelection = 0, $thirdSelection = 0){
        $this->fileProcessor->readFileIntoArray($previousDrawsToSelectFrom);
        $draws = $this->fileProcessor->getDrawResults();
        $selection = [];
        switch($strategy){
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
     * @param string $strategy
     * @param array $selections
     * @return array
     */
    private function initializeResults($strategy, $selections){
        $results = [];
        $startValue = ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0, 'luxor_dates' => [], 'first_picture_dates' => [], 'first_frame_dates' => []];
        $firstSelection = isset($selections['first']) ? intval($selections['first']) : 0;
        $secondSelection = isset($selections['second']) ? intval($selections['second']) : 0;
        $thirdSelection = isset($selections['third']) ? intval($selections['third']) : 0;
        
        $results["SAME_RANDOM"] = $startValue;
        $results["REGENERATED_RANDOM"] = $startValue;
        switch($strategy){
            case "LEAST_DRAWN":
                $results[$strategy . '_' . $firstSelection] = $startValue;
                break;
            case "MOST_DRAWN":
                $results[$strategy . '_' . $firstSelection] = $startValue;
                break;
            case "LEAST_DRAWN_AND_RANDOM":
                $results[$strategy . '_L' . $firstSelection . '_R' . $secondSelection] = $startValue;
                break;
            case "MOST_DRAWN_AND_RANDOM":
                $results[$strategy . '_M' . $firstSelection . '_R' . $secondSelection] = $startValue;
                break;
            case "LEAST_AND_MOST_DRAWN":
                $results[$strategy . '_L' . $firstSelection . '_M' . $secondSelection] = $startValue;
                break;
            case "MOST_LEAST_AND_RANDOM":
                $results[$strategy . '_M' . $firstSelection . '_L' . $secondSelection . '_R' . $thirdSelection] =  $startValue;
                break;
        }
        return $results;
    }
    
    /**
     * Initialize results array to hold results
     * 
     * @param string $strategy
     * @param array $previousDraws
     * @param array $selections
     * @return array
     */
    private function initializeResultsFromConfig($strategies, $previousDraws, $selections){
        $results = [];
        $startValue = ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0, 'luxor_dates' => [], 'first_picture_dates' => [], 'first_frame_dates' => []];
        
        $results["SAME_RANDOM"] = $startValue;
        $results["REGENERATED_RANDOM"] = $startValue;
        foreach($previousDraws as $previousDraw){
            foreach($strategies as $strategy){
                if(in_array($strategy, ["LEAST_DRAWN", "MOST_DRAWN"])){
                    foreach($selections[0] as $selection){
                        switch($strategy){
                            case "LEAST_DRAWN":
                                $results[$strategy . '_' . $previousDraw . '_' . $selection] = $startValue;
                                break;
                            case "MOST_DRAWN":
                                $results[$strategy . '_' . $previousDraw . '_' . $selection] = $startValue;
                                break;
                        }
                    }
                } elseif(in_array($strategy, ["LEAST_DRAWN_AND_RANDOM", "MOST_DRAWN_AND_RANDOM", "LEAST_AND_MOST_DRAWN"])){
                    foreach($selections[1]['first'] as $firstSelection){
                        foreach($selections[1]['second'] as $secondSelection){
                            switch($strategy){
                                case "LEAST_DRAWN_AND_RANDOM":
                                    $results[$strategy . '_' . $previousDraw . '_L' . $firstSelection . '_R' . $secondSelection] = $startValue;
                                    break;
                                case "MOST_DRAWN_AND_RANDOM":
                                    $results[$strategy . '_' . $previousDraw . '_M' . $firstSelection . '_R' . $secondSelection] = $startValue;
                                    break;
                                case "LEAST_AND_MOST_DRAWN":
                                    $results[$strategy . '_' . $previousDraw . '_L' . $firstSelection . '_M' . $secondSelection] = $startValue;
                                    break;
                            }
                        }
                    }
                } elseif($strategy == "MOST_LEAST_AND_RANDOM"){
                    foreach($selections[2]['first'] as $firstSelection){
                        foreach($selections[2]['second'] as $secondSelection){
                            foreach($selections[2]['third'] as $thirdSelection){
                                $results[$strategy .  '_' . $previousDraw . '_M' . $firstSelection . '_L' . $secondSelection . '_R' . $thirdSelection] =  $startValue;
                            }
                        }
                    }
                }   
            }
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