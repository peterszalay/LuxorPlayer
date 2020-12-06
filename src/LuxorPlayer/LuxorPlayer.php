<?php
namespace LuxorPlayer;


use Exception;

class LuxorPlayer
{
    use Ordering;

    private const DEFAULT_WEEKS_ANALYZED = 0;
    private const DEFAULT_DRAWS_PLAYED = 0;
    private const DEFAULT_NUM_TICKETS = 0;
    private const DEFAULT_MIN_SELECTION = 20;
    private const DEFAULT_MAX_SELECTION = 70;
    private const DEFAULT_REPEAT_TIMES = 1;
    private const DEFAULT_STRATEGIES_PLAYED = 1;
    private const DEFAULT_ORDER_BY = "orderByUniqueTotal";
    private FileProcessor $fileProcessor;
    private LuxorTicketGenerator $ticketGenerator;
    private DrawProcessor $drawProcessor;
    private LuxorGame $game;
    /**
     * User set variables
     */
    private int $drawCount = 0;
    private int $ticketCount = 0;
    
    public function init(){
        $fileDownloader = new FileDownloader();
        $fileDownloader->downloadCsv();
        $this->fileProcessor = new FileProcessor();
        $this->ticketGenerator = new LuxorTicketGenerator();
        $this->drawProcessor = new DrawProcessor();
    }
    
    
    /**
     * Play luxor with parameters given in file
     * 
     * @return array
     */
    public function playFromConfig() :array
    {
        try {
            $file = include  __DIR__ . '/../../config/luxor.php';
            if(isset($file['manual_player'])){
                $i = 1;
                $drawCount = getIntValue($file['manual_player']['draws'], 2, self::DEFAULT_WEEKS_ANALYZED);
                $ticketCount = getIntValue($file['manual_player']['tickets'], 2, self::DEFAULT_NUM_TICKETS);
                $repeatTimes = getIntValue($file['manual_player']['repeat'], 2, self::DEFAULT_REPEAT_TIMES);
                $minSelection = getIntValue($file['manual_player']['min_selection'], self::DEFAULT_MIN_SELECTION, self::DEFAULT_MIN_SELECTION);
                $maxSelection = getIntValue($file['manual_player']['max_selection'], self::DEFAULT_MIN_SELECTION, self::DEFAULT_MAX_SELECTION);
                $strategies = getArrayValues($file['manual_player']['strategies'], []);
                $previousDraws = getArrayValues($file['manual_player']['previous_draws'], []);
                $selections = [];
                $selections[0] = getArrayValues($file['manual_player']['one_selection'], []);
                $selections[1] = getArrayValues($file['manual_player']['two_selections'], []);
                $selections[2] = getArrayValues($file['manual_player']['three_selections'], []);
                $selections[2] = getArrayValues($file['manual_player']['three_selections'], []);

                $results = $this->initializeResultsFromConfig($strategies, $previousDraws, $selections, $minSelection, $maxSelection);
                $this->setDrawCount($drawCount);
                $this->setTicketCount($ticketCount);
                
                while($i <= $repeatTimes){
                    $drawResult = $this->playWithRandomNumbers();
                    $this->addToResults('SAME_RANDOM', $results, $drawResult);

                    $drawResult = $this->playWithRandomNumbers(true);
                    $this->addToResults('REGENERATED_RANDOM', $results, $drawResult);

                    $drawResult = $this->playWithRandomNumbers(false, true);
                    $this->addToResults('SAME_RANDOM_ENFORCED_PROPORTIONS', $results, $drawResult);

                    $drawResult = $this->playWithRandomNumbers(true, true);
                    $this->addToResults('REGENERATED_RANDOM_ENFORCED_PROPORTIONS', $results, $drawResult);
                    
                   
                    foreach($previousDraws as $previousDraw){
                        foreach($strategies as $strategy){
                            $key = '';
                            if(in_array($strategy, ["LEAST_DRAWN", "MOST_DRAWN"])){
                                foreach($selections[0] as $selection){
                                    if(($selection < $minSelection) || ($selection > $maxSelection)){
                                        continue;
                                    }
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
                                    $this->addToResults($key, $results, $drawResult);
                                    
                                }
                            } elseif(in_array($strategy, ["LEAST_DRAWN_AND_RANDOM", "MOST_DRAWN_AND_RANDOM", "LEAST_AND_MOST_DRAWN"])){
                                foreach($selections[1]['first'] as $firstSelection){
                                    foreach($selections[1]['second'] as $secondSelection){
                                        if(($firstSelection + $secondSelection < $minSelection) || ($firstSelection + $secondSelection > $maxSelection)){
                                            continue;
                                        }
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
                                        $this->addToResults($key, $results, $drawResult);
                                    }
                                }
                            } elseif($strategy == "MOST_LEAST_AND_RANDOM"){
                                foreach($selections[2]['first'] as $firstSelection){
                                    foreach($selections[2]['second'] as $secondSelection){
                                        foreach($selections[2]['third'] as $thirdSelection){
                                            if(($firstSelection + $secondSelection + $thirdSelection < $minSelection) || ($firstSelection + $secondSelection + $thirdSelection > $maxSelection)){
                                                continue;
                                            }
                                            $key = $strategy .  '_' . $previousDraw . '_M' . $firstSelection . '_L' . $secondSelection . '_R' . $thirdSelection;
                                            $drawResult = $this->playWithSelectedNumbers($previousDraw, $firstSelection, "MOST_LEAST_AND_RANDOM", $secondSelection, $thirdSelection);
                                            $this->addToResults($key, $results, $drawResult);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $i++;
                }                   
            }
        } catch(Exception $ex){
        }
        $this->cleanResultDates($results);
        uasort($results, [$this, 'orderByTotal']);
        return $results;
    }

    /**
     * AutoPlayer uses this to load its config
     *
     * @param array $draws
     * @param array $previousDraws
     * @param int $ticketCount
     * @param int $repeatTimes
     * @param int $minSelection
     * @param int $maxSelection
     * @param array $strategies
     * @param array $selections
     * @param string $orderBy
     * @param $maxPreviousDraws
     * @return array
     */
    public function autoAnalyzeStrategies(array $draws, array $previousDraws, int $ticketCount, int $repeatTimes, int $minSelection, int $maxSelection, array $strategies, array $selections, string $orderBy = 'orderByUniqueTotal', $maxPreviousDraws){
        try {
            $i = 1;          
            $results = $this->initializeResultsFromConfig($strategies, $previousDraws, $selections, $minSelection, $maxSelection, false);
            //print_r($results);
            $this->setTicketCount($ticketCount);           
            while($i <= $repeatTimes){         
                foreach($previousDraws as $previousDraw){
                    foreach($strategies as $strategy){
                        $key = '';
                        if(in_array($strategy, ["LEAST_DRAWN", "MOST_DRAWN"])){
                            foreach($selections[0] as $selection){
                                if(($selection < $minSelection) || ($selection > $maxSelection)){
                                    continue;
                                }
                                $drawResult = [];
                                $key = $strategy . '_' . $previousDraw . '_' . $selection;
                                switch($strategy){
                                    case "LEAST_DRAWN":
                                        $drawResult = $this->autoPlayWithSelectedNumbers($draws, $previousDraw, $selection, "LEAST_DRAWN", $maxPreviousDraws);
                                        break;
                                    case "MOST_DRAWN":
                                        $drawResult = $this->autoPlayWithSelectedNumbers($draws, $previousDraw, $selection, "MOST_DRAWN", $maxPreviousDraws);
                                        break;
                                }
                                $this->addToResults($key, $results, $drawResult);
                                
                            }
                        } elseif(in_array($strategy, ["LEAST_DRAWN_AND_RANDOM", "MOST_DRAWN_AND_RANDOM", "LEAST_AND_MOST_DRAWN"])){
                            foreach($selections[1]['first'] as $firstSelection){
                                foreach($selections[1]['second'] as $secondSelection){
                                    if(($firstSelection + $secondSelection < $minSelection) || ($firstSelection + $secondSelection > $maxSelection)){
                                        continue;
                                    }
                                    $drawResult = [];
                                    switch($strategy){
                                        case "LEAST_DRAWN_AND_RANDOM":
                                            $key = $strategy . '_' . $previousDraw . '_L' . $firstSelection . '_R' . $secondSelection;
                                            $drawResult = $this->autoPlayWithSelectedNumbers($draws, $previousDraw, $firstSelection, "LEAST_DRAWN_AND_RANDOM", $maxPreviousDraws, $secondSelection);
                                            break;
                                        case "MOST_DRAWN_AND_RANDOM":
                                            $key = $strategy . '_' . $previousDraw . '_M' . $firstSelection . '_R' . $secondSelection;
                                            $drawResult = $this->autoPlayWithSelectedNumbers($draws, $previousDraw, $firstSelection, "MOST_DRAWN_AND_RANDOM", $maxPreviousDraws, $secondSelection);
                                            break;
                                        case "LEAST_AND_MOST_DRAWN":
                                            $key = $strategy . '_' . $previousDraw . '_L' . $firstSelection . '_M' . $secondSelection;
                                            $drawResult = $this->autoPlayWithSelectedNumbers($draws, $previousDraw, $firstSelection, "LEAST_AND_MOST_DRAWN", $maxPreviousDraws, $secondSelection);
                                            break;
                                    }
                                    $this->addToResults($key, $results, $drawResult);
                                }
                            }
                        } elseif($strategy == "MOST_LEAST_AND_RANDOM"){
                            foreach($selections[2]['first'] as $firstSelection){
                                foreach($selections[2]['second'] as $secondSelection){
                                    foreach($selections[2]['third'] as $thirdSelection){
                                        if(($firstSelection + $secondSelection + $thirdSelection < $minSelection) || ($firstSelection + $secondSelection + $thirdSelection > $maxSelection)){
                                            continue;
                                        }
                                        $key = $strategy .  '_' . $previousDraw . '_M' . $firstSelection . '_L' . $secondSelection . '_R' . $thirdSelection;
                                        $drawResult = $this->autoPlayWithSelectedNumbers($draws, $previousDraw, $firstSelection, "MOST_LEAST_AND_RANDOM", $maxPreviousDraws, $secondSelection, $thirdSelection);
                                        $this->addToResults($key, $results, $drawResult);
                                    }
                                }
                            }
                        }
                    }
                }
                $i++;
            }
        } catch(Exception $ex){
        }
        $this->cleanResultDates($results);
        uasort($results, [$this, $orderBy]);
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
    public function play(int $drawCount, int $ticketCount, int $previousDrawsToSelectFrom, string $strategy, array $selections, int $repeatTimes) :array
    {
        $i = 1;
        $results = $this->initializeResults($strategy, $selections);
        
        $this->setDrawCount($drawCount);
        $this->setTicketCount($ticketCount);
        
        while($i <= $repeatTimes){
            $drawResult = $this->playWithRandomNumbers();
            $this->addToResults('SAME_RANDOM', $results, $drawResult);

            $drawResult = $this->playWithRandomNumbers(false, true);
            $this->addToResults('SAME_RANDOM_ENFORCED_PROPORTIONS', $results, $drawResult);

            $drawResult = $this->playWithRandomNumbers(true);
            $this->addToResults('REGENERATED_RANDOM', $results, $drawResult);

            $drawResult = $this->playWithRandomNumbers(true, true);
            $this->addToResults('REGENERATED_RANDOM_ENFORCED_PROPORTIONS', $results, $drawResult);

            $key = '';
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
            $this->addToResults($key, $results, $drawResult);
            
            $i++;
        }
        $this->cleanResultDates($results);
        uasort($results, [$this, 'orderByUniqueTotal']);
        return $results;
    }
    
    /**
     * Play with random numbers
     * 
     * @param bool $regenerateTicketsBeforeEveryDraw
     * @param bool $enforceOddEvenRatio
     * @return array
     */
    public function playWithRandomNumbers(bool $regenerateTicketsBeforeEveryDraw = false, bool $enforceOddEvenRatio = false) :array
    {
        $this->game = new LuxorGame();
        $this->fileProcessor = new FileProcessor();
        $this->fileProcessor->readFileIntoArray($this->drawCount);
        $draws = $this->fileProcessor->getDrawResults();
        if($regenerateTicketsBeforeEveryDraw){
            foreach($draws as $draw){
                $this->ticketGenerator->generateTicketsWithRandomNumbers($this->ticketCount, $enforceOddEvenRatio);
                $this->game->processTicketsForADraw($this->ticketGenerator->getTickets(), $draw);
            }
            return $this->game->getResults();
        } else {
            $this->ticketGenerator->generateTicketsWithRandomNumbers($this->ticketCount, $enforceOddEvenRatio);
            return $this->game->processTicketsForDraws($this->ticketGenerator->getTickets(), $draws);
        }
    }

    /**
     * Play with selected numbers
     *
     * @param int $previousDrawsToSelectFrom
     * @param int $firstSelection
     * @param string $strategy
     * @param int $secondSelection
     * @param int $thirdSelection
     * @return array
     */
    public function playWithSelectedNumbers(int $previousDrawsToSelectFrom, int $firstSelection, string $strategy = "MOST_DRAWN", int $secondSelection = 0, int $thirdSelection = 0) :array
    {
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
                    $selection = $this->ticketGenerator->mergeTwoSelections($leastDrawnSelection, $mostDrawnSelection);
                    break;
                case "LEAST_DRAWN_AND_RANDOM":
                    $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($previousDraws, $firstSelection);
                    $randomSelection = $this->ticketGenerator->generateRandomSelection($secondSelection);
                    $selection = $this->ticketGenerator->mergeTwoSelections($leastDrawnSelection, $randomSelection);
                    break;
                case "MOST_DRAWN_AND_RANDOM":
                    $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($previousDraws, $firstSelection);
                    $randomSelection = $this->ticketGenerator->generateRandomSelection($secondSelection);
                    $selection = $this->ticketGenerator->mergeTwoSelections($mostDrawnSelection, $randomSelection);
                    break;
                case "MOST_LEAST_AND_RANDOM":
                    $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($previousDraws, $firstSelection);
                    $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($previousDraws, $secondSelection);
                    $randomSelection = $this->ticketGenerator->generateRandomSelection($thirdSelection);
                    $selection1 = $this->ticketGenerator->mergeTwoSelections($mostDrawnSelection, $leastDrawnSelection);
                    $selection = $this->ticketGenerator->mergeTwoSelections($selection1, $randomSelection);
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
     * Auto play with selected numbers
     *
     * @param array $draws
     * @param int $previousDraw
     * @param int $firstSelection
     * @param string $strategy
     * @param int $maxPreviousDraws
     * @param int $secondSelection
     * @param int $thirdSelection
     * @return array
     */
    public function autoPlayWithSelectedNumbers(array $draws, int $previousDraw, int $firstSelection, string $strategy = "MOST_DRAWN", int $maxPreviousDraws, int $secondSelection = 0, int $thirdSelection = 0) :array
    {
        $this->game = new LuxorGame();
        $draws = array_reverse($draws);
        for($i = 0; $i < (sizeof($draws) - $maxPreviousDraws); $i++){
            $lastDraw = array_pop($draws);
            $previousDraws = array_slice($draws, -($previousDraw), $previousDraw, true);
            switch($strategy){
                case "LEAST_DRAWN":
                    $selection = $this->drawProcessor->getLeastDrawnNumbers($previousDraws, $firstSelection);
                    break;
                case "LEAST_AND_MOST_DRAWN":
                    $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($previousDraws, $firstSelection);
                    $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($previousDraws, $secondSelection);
                    $selection = $this->ticketGenerator->mergeTwoSelections($leastDrawnSelection, $mostDrawnSelection);
                    break;
                case "LEAST_DRAWN_AND_RANDOM":
                    $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($previousDraws, $firstSelection);
                    $randomSelection = $this->ticketGenerator->generateRandomSelection($secondSelection);
                    $selection = $this->ticketGenerator->mergeTwoSelections($leastDrawnSelection, $randomSelection);
                    break;
                case "MOST_DRAWN_AND_RANDOM":
                    $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($previousDraws, $firstSelection);
                    $randomSelection = $this->ticketGenerator->generateRandomSelection($secondSelection);
                    $selection = $this->ticketGenerator->mergeTwoSelections($mostDrawnSelection, $randomSelection);
                    break;
                case "MOST_LEAST_AND_RANDOM":
                    $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($previousDraws, $firstSelection);
                    $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($previousDraws, $secondSelection);
                    $randomSelection = $this->ticketGenerator->generateRandomSelection($thirdSelection);
                    $selection1 = $this->ticketGenerator->mergeTwoSelections($mostDrawnSelection, $leastDrawnSelection);
                    $selection = $this->ticketGenerator->mergeTwoSelections($selection1, $randomSelection);
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
     * Generate numbers for strategy
     * 
     * @param int $previousDrawsToSelectFrom
     * @param int $firstSelection
     * @param string $strategy
     * @param int $secondSelection
     * @param int $thirdSelection
     * @return array
     */
    public function generateNumbers(int $previousDrawsToSelectFrom, int $firstSelection, string $strategy = "MOST_DRAWN", int $secondSelection = 0, int $thirdSelection = 0) :array
    {
        $this->fileProcessor->readFileIntoArray($previousDrawsToSelectFrom);
        $draws = $this->fileProcessor->getDrawResults();
        switch($strategy){
            case "LEAST_DRAWN":
                $selection = $this->drawProcessor->getLeastDrawnNumbers($draws, $firstSelection);
                break;
            case "LEAST_AND_MOST_DRAWN":
                $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($draws, $firstSelection);
                $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($draws, $secondSelection);
                $selection = $this->ticketGenerator->mergeTwoSelections($leastDrawnSelection, $mostDrawnSelection);
                break;
            case "LEAST_DRAWN_AND_RANDOM":
                $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($draws, $firstSelection);
                $randomSelection = $this->ticketGenerator->generateRandomSelection($secondSelection);
                $selection = $this->ticketGenerator->mergeTwoSelections($leastDrawnSelection, $randomSelection);
                break;
            case "MOST_DRAWN_AND_RANDOM":
                $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($draws, $firstSelection);
                $randomSelection = $this->ticketGenerator->generateRandomSelection($secondSelection);
                $selection = $this->ticketGenerator->mergeTwoSelections($mostDrawnSelection, $randomSelection);
                break;
            case "MOST_LEAST_AND_RANDOM":
                $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($draws, $firstSelection);
                $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($draws, $secondSelection);
                $randomSelection = $this->ticketGenerator->generateRandomSelection($thirdSelection);
                $selection1 = $this->ticketGenerator->mergeTwoSelections($mostDrawnSelection, $leastDrawnSelection);
                $selection = $this->ticketGenerator->mergeTwoSelections($selection1, $randomSelection);
                break;
            case "MOST_DRAWN": default:
                $selection = $this->drawProcessor->getMostDrawnNumbers($draws, $firstSelection);
        }
        return $selection;
    }
    
    
    /**
     * Generate numbers for strategy
     *
     * @param array $draws
     * @param int $previousDrawsToSelectFrom
     * @param int $firstSelection
     * @param string $strategy
     * @param int $secondSelection
     * @param int $thirdSelection
     * @return array
     */
    public function autoGenerateNumbers(array $draws, int $previousDrawsToSelectFrom, int $firstSelection, string $strategy = "MOST_DRAWN", int $secondSelection = 0, int $thirdSelection = 0) :array
    {
        switch($strategy){
            case "LEAST_DRAWN":
                $selection = $this->drawProcessor->getLeastDrawnNumbers($draws, $firstSelection);
                break;
            case "LEAST_AND_MOST_DRAWN":
                $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($draws, $firstSelection);
                $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($draws, $secondSelection);
                $selection = $this->ticketGenerator->mergeTwoSelections($leastDrawnSelection, $mostDrawnSelection);
                break;
            case "LEAST_DRAWN_AND_RANDOM":
                $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($draws, $firstSelection);
                $randomSelection = $this->ticketGenerator->generateRandomSelection($secondSelection);
                $selection = $this->ticketGenerator->mergeTwoSelections($leastDrawnSelection, $randomSelection);
                break;
            case "MOST_DRAWN_AND_RANDOM":
                $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($draws, $firstSelection);
                $randomSelection = $this->ticketGenerator->generateRandomSelection($secondSelection);
                $selection = $this->ticketGenerator->mergeTwoSelections($mostDrawnSelection, $randomSelection);
                break;
            case "MOST_LEAST_AND_RANDOM":
                $mostDrawnSelection = $this->drawProcessor->getMostDrawnNumbers($draws, $firstSelection);
                $leastDrawnSelection = $this->drawProcessor->getLeastDrawnNumbers($draws, $secondSelection);
                $randomSelection = $this->ticketGenerator->generateRandomSelection($thirdSelection);
                $selection1 = $this->ticketGenerator->mergeTwoSelections($mostDrawnSelection, $leastDrawnSelection);
                $selection = $this->ticketGenerator->mergeTwoSelections($selection1, $randomSelection);
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
    private function initializeResults(string $strategy, array $selections) :array
    {
        $results = [];
        $startValue = ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0,  'last_win_date' => '', 'win_dates' => 0, 
                       'jackpot_dates' => [], 'luxor_dates' => [], 'first_picture_dates' => [], 'first_frame_dates' => [], 'picture_dates' => [], 'frame_dates' => [], 'unique_jackpot' => 0, 
                       'unique_luxor' => 0, 'unique_first_picture' => 0, 'unique_first_frame' => 0, 'unique_frame' => 0, 'unique_picture' => 0];
        $firstSelection = isset($selections['first']) ? intval($selections['first']) : 0;
        $secondSelection = isset($selections['second']) ? intval($selections['second']) : 0;
        $thirdSelection = isset($selections['third']) ? intval($selections['third']) : 0;
        
        $results["SAME_RANDOM"] = $startValue;
        $results["REGENERATED_RANDOM"] = $startValue;
        $results["SAME_RANDOM_ENFORCED_PROPORTIONS"] = $startValue;
        $results["REGENERATED_RANDOM_ENFORCED_PROPORTIONS"] = $startValue;
        switch($strategy){
            case "LEAST_DRAWN": case "MOST_DRAWN":
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
     * @param array $strategies
     * @param array $previousDraws
     * @param array $selections
     * @param int $minSelection
     * @param int $maxSelection
     * @param bool $withRandoms
     * @return array
     */
    private function initializeResultsFromConfig(array $strategies, array $previousDraws, array $selections, int $minSelection = 20, int $maxSelection = 70, bool $withRandoms = true) :array
    {
        $results = [];
        $startValue = ['random' => false, 'most' => false, 'least' => false, 'mixed' => false, 'prev_draws' => 0, 
                       'first_selection' => 0, 'second_selection' => 0, 'third_selection' => 0, 'total' => 0, 
                       'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0, 'last_win_date' => '',
                       'win_dates' => 0, 'jackpot_dates' => [], 'luxor_dates' => [], 'first_picture_dates' => [], 'first_frame_dates' => [], 
                       'picture_dates' => [], 'frame_dates' => [], 'unique_jackpot' => 0, 'unique_luxor' => 0, 'unique_first_picture' => 0,
                       'unique_first_frame' => 0, 'unique_frame' => 0, 'unique_picture' => 0, 'strategy' => ''
                      ];
        if($withRandoms){
            $results["SAME_RANDOM"] = $startValue;
            $results["SAME_RANDOM"]['random'] = true;
            $results["REGENERATED_RANDOM"] = $startValue;
            $results["REGENERATED_RANDOM"]['random'] = true;
            $results["SAME_RANDOM_ENFORCED_PROPORTIONS"] = $startValue;
            $results["SAME_RANDOM_ENFORCED_PROPORTIONS"]['random'] = true;
            $results["REGENERATED_RANDOM_ENFORCED_PROPORTIONS"] = $startValue;
            $results["REGENERATED_RANDOM_ENFORCED_PROPORTIONS"]['random'] = true;
        }
        foreach($previousDraws as $previousDraw){
            $startValue['prev_draws'] = $previousDraw;
            $startValue['first_selection'] = 0;
            $startValue['second_selection'] = 0;
            $startValue['third_selection'] = 0;
            $startValue['least'] = false;
            $startValue['most'] = false;
            $startValue['random'] = false;
            $startValue['mixed'] = false;
            foreach($strategies as $strategy){
                $startValue['strategy'] = $strategy;
                if(in_array($strategy, ["LEAST_DRAWN", "MOST_DRAWN"])){
                    foreach($selections[0] as $selection){
                        if(($selection < $minSelection) || ($selection > $maxSelection)){
                            continue;
                        }
                        $startValue['first_selection'] = $selection;
                        switch($strategy){
                            case "LEAST_DRAWN":
                                $startValue['least'] = true;
                                $startValue['most'] = false;
                                $startValue['random'] = false;
                                $startValue['mixed'] = false;
                                $results[$strategy . '_' . $previousDraw . '_' . $selection] = $startValue;
                                break;
                            case "MOST_DRAWN":
                                $startValue['most'] = true;
                                $startValue['least'] = false;
                                $startValue['random'] = false;
                                $startValue['mixed'] = false;
                                $results[$strategy . '_' . $previousDraw . '_' . $selection] = $startValue;
                                break;
                        }
                    }
                } elseif(in_array($strategy, ["LEAST_DRAWN_AND_RANDOM", "MOST_DRAWN_AND_RANDOM", "LEAST_AND_MOST_DRAWN"])){
                    foreach($selections[1]['first'] as $firstSelection){
                        foreach($selections[1]['second'] as $secondSelection){
                            if(($firstSelection + $secondSelection < $minSelection) || ($firstSelection + $secondSelection > $maxSelection)){
                                continue;
                            }
                            $startValue['first_selection'] = $firstSelection;
                            $startValue['second_selection'] = $secondSelection;
                            switch($strategy){
                                case "LEAST_DRAWN_AND_RANDOM":
                                    $startValue['least'] = true;
                                    $startValue['random'] = true;
                                    $startValue['mixed'] = true;
                                    $startValue['most'] = false;
                                    $results[$strategy . '_' . $previousDraw . '_L' . $firstSelection . '_R' . $secondSelection] = $startValue;
                                    break;
                                case "MOST_DRAWN_AND_RANDOM":
                                    $startValue['most'] = true;
                                    $startValue['random'] = true;
                                    $startValue['mixed'] = true;
                                    $startValue['least'] = false;
                                    $results[$strategy . '_' . $previousDraw . '_M' . $firstSelection . '_R' . $secondSelection] = $startValue;
                                    break;
                                case "LEAST_AND_MOST_DRAWN":
                                    $startValue['least'] = true;
                                    $startValue['most'] = true;
                                    $startValue['mixed'] = true;
                                    $startValue['random'] = false;
                                    $results[$strategy . '_' . $previousDraw . '_L' . $firstSelection . '_M' . $secondSelection] = $startValue;
                                    break;
                            }
                        }
                    }
                } elseif($strategy == "MOST_LEAST_AND_RANDOM"){
                    foreach($selections[2]['first'] as $firstSelection){
                        foreach($selections[2]['second'] as $secondSelection){
                            foreach($selections[2]['third'] as $thirdSelection){
                                if(($firstSelection + $secondSelection + $thirdSelection < $minSelection) || ($firstSelection + $secondSelection + $thirdSelection > $maxSelection)){
                                    continue;
                                }
                                $startValue['first_selection'] = $firstSelection;
                                $startValue['second_selection'] = $secondSelection;
                                $startValue['third_selection'] = $thirdSelection;
                                $startValue['least'] = true;
                                $startValue['most'] = true;
                                $startValue['random'] = true;
                                $startValue['mixed'] = true;
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
     * Adds draw results for strategy identified by key to results array, which contains results for every strategy
     * 
     * @param string $key
     * @param array $results
     * @param array $drawResult
     */
    private function addToResults(string $key, array &$results, array $drawResult) :void
    {
        $results[$key]['total'] += $drawResult['pictures'] 
                                + (10 * $drawResult['frames']) 
                                + (20 * $drawResult['first_picture']) 
                                + (50 * $drawResult['first_frame']) 
                                + (100 * $drawResult['luxor']) 
                                + (300 * $drawResult['jackpot']);
        $results[$key]['pictures'] += $drawResult['pictures'];
        $results[$key]['frames'] += $drawResult['frames'];
        $results[$key]['first_picture'] += $drawResult['first_picture'];
        $results[$key]['first_frame'] += $drawResult['first_frame'];
        $results[$key]['luxor'] += $drawResult['luxor'];
        $results[$key]['jackpot'] += $drawResult['jackpot'];
        $results[$key]['jackpot_dates'] += $drawResult['jackpot_dates'];
        $results[$key]['luxor_dates'] += $drawResult['luxor_dates'];
        $results[$key]['first_frame_dates'] += $drawResult['first_frame_dates'];
        $results[$key]['first_picture_dates'] += $drawResult['first_picture_dates'];
        $results[$key]['frame_dates'] += $drawResult['frame_dates'];
        $results[$key]['picture_dates'] += $drawResult['picture_dates'];
    }
    
    /**
     * Helper function that cleans result dates
     * 
     * @param array $results
     */
    private function cleanResultDates(array &$results) :void
    {
        foreach ($results as $key => $result){
            $jackpotDates = array_unique($result['jackpot_dates']);
            $luxorDates = array_unique($result['luxor_dates']);
            $firstFrameDates = array_unique($result['first_frame_dates']);
            $firstPictureDates = array_unique($result['first_picture_dates']);
            $frameDates = array_unique($result['frame_dates']);
            $pictureDates = array_unique($result['picture_dates']);
            $allDates = $pictureDates + $frameDates + $luxorDates;
            $results[$key]['win_dates'] = sizeof(array_unique($allDates));
            $results[$key]['last_win_date'] = (!empty($allDates)) ? max($allDates) : '';
            $results[$key]['jackpot_dates'] = $jackpotDates;
            $results[$key]['luxor_dates'] = $luxorDates;
            $results[$key]['first_frame_dates'] = $firstFrameDates;
            $results[$key]['first_picture_dates'] = $firstPictureDates;
            $results[$key]['frame_dates'] = $frameDates;
            $results[$key]['picture_dates'] = $pictureDates;
            
            $results[$key]['unique_jackpot'] = sizeof($jackpotDates);
            $results[$key]['unique_luxor'] = sizeof($luxorDates);
            $results[$key]['unique_first_frame'] = sizeof($firstFrameDates);
            $results[$key]['unique_first_picture'] = sizeof($firstPictureDates);
            $results[$key]['unique_frame'] = sizeof($frameDates);
            $results[$key]['unique_picture'] = sizeof($pictureDates);
            
            rsort($results[$key]['luxor_dates']);
            rsort($results[$key]['first_frame_dates']);
            rsort($results[$key]['first_picture_dates']);
            rsort($results[$key]['frame_dates']);
            rsort($results[$key]['picture_dates']);
        }
    }
}