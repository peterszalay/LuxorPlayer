<?php
namespace LuxorPlayer;


class AutoPlayer {
    
    private static $draws = [];
    private static $drawCount = 0;
    private static $ticketCount = 0;
    private static $strategies = [];
    private static $previousDraws = [];
    private static $weeksAnalyzed = 0;
    private static $repeat = 0;
    private static $minSelection = 0;
    private static $maxSelection = 0;
    private static $firstSelection = [];
    private static $secondSelection = [];
    private static $thirdSelection = [];
    private static $orderBy = '';
    
    private $playerName = '';
    private $playerStrategies = [];
    private $playerPreviousDraws = [];
    private $playerWeeksAnalyzed = 0;
    private $playerRepeat = 0;
    private $playerMinSelection = 0;
    private $playerMaxSelection = 0;
    private $playerFirstSelection = [];
    private $playerSecondSelection = [];
    private $playerThirdSelection = [];
    private $playerStrategiesPlayed = 0;
    private $playerOrderBy = '';
    private $playerResults = [];
    
    
    public function __construct($name)
    {
        $this->playerName = $name;
    }
    
    public static function create($name)
    {
        return new AutoPlayer($name);
    }
    
    /**
     * @param array $draws
     */
    public static function setDraws($draws)
    {
        self::$draws = $draws;
    }

    /**
     * @param int $drawCount
     */
    public static function setDrawCount($drawCount)
    {
        self::$drawCount = $drawCount;
    }

    /**
     * @param int $ticketCount
     */
    public static function setTicketCount($ticketCount)
    {
        self::$ticketCount = $ticketCount;
    }
    
    /**
     * @param array $strategies
     */
    public static function setStrategies($strategies)
    {
        self::$strategies = $strategies;
    }


    /**
     * @param array $previousDraws
     */
    public static function setPreviousDraws($previousDraws)
    {
        self::$previousDraws = $previousDraws;
    }

    /**
     * @param int $weeksAnalyzed
     */
    public static function setWeeksAnalyzed($weeksAnalyzed)
    {
        self::$weeksAnalyzed = $weeksAnalyzed;
    }

    /**
     * @param int $repeat
     */
    public static function setRepeat($repeat)
    {
        self::$repeat = $repeat;
    }

    /**
     * @param int $minSelection
     */
    public static function setMinSelection($minSelection)
    {
        self::$minSelection = $minSelection;
    }

    /**
     * @param int $maxSelection
     */
    public static function setMaxSelection($maxSelection)
    {
        self::$maxSelection = $maxSelection;
    }

    /**
     * @param array $firstSelection
     */
    public static function setFirstSelection($firstSelection)
    {
        self::$firstSelection = $firstSelection;
    }

    /**
     * @param array $secondselection
     */
    public static function setSecondSelection($secondSelection)
    {
        self::$secondSelection = $secondSelection;
    }

    /**
     * @param array $thirdSelection
     */
    public static function setThirdSelection($thirdSelection)
    {
        self::$thirdSelection = $thirdSelection;
    }
    
    /**
     * @param string $orderBy
     */
    public static function setOrderBy($orderBy)
    {
        AutoPlayer::$orderBy = $orderBy;
    }

    /**
     * @param int $strategiesPlayed
     */
    public function setStrategiesPlayed($strategiesPlayed)
    {
        $this->strategiesPlayed = $strategiesPlayed;
    }

    /**
     * @return array $playerResults
     */
    public function getResults()
    {
        return $this->playerResults;
    }
    
    /**
     * @return String playeRane
     */
    public function getName()
    {
        return $this->playerName;
    }
    
    /**
     * @param multitype: $playerStrategies
     */
    public function setPlayerStrategies($playerStrategies)
    {
        $this->playerStrategies = $playerStrategies;
    }

    /**
     * @param multitype: $playerPreviousDraws
     */
    public function setPlayerPreviousDraws($playerPreviousDraws)
    {
        $this->playerPreviousDraws = $playerPreviousDraws;
    }

    /**
     * @param number $playerWeeksAnalyzed
     */
    public function setPlayerWeeksAnalyzed($playerWeeksAnalyzed)
    {
        $this->playerWeeksAnalyzed = $playerWeeksAnalyzed;
    }

    /**
     * @param number $playerRepeat
     */
    public function setPlayerRepeat($playerRepeat)
    {
        $this->playerRepeat = $playerRepeat;
    }

    /**
     * @param multitype: $playerFirstSelection
     */
    public function setPlayerFirstSelection($playerFirstSelection)
    {
        $this->playerFirstSelection = $playerFirstSelection;
    }

    /**
     * @param multitype: $playerSecondSelection
     */
    public function setPlayerSecondSelection($playerSecondSelection)
    {
        $this->playerSecondSelection = $playerSecondSelection;
    }

    /**
     * @param multitype: $playerThirdSelection
     */
    public function setPlayerThirdSelection($playerThirdSelection)
    {
        $this->playerThirdSelection = $playerThirdSelection;
    }

    /**
     * @param number $playerStrategiesPlayed
     */
    public function setPlayerStrategiesPlayed($playerStrategiesPlayed)
    {
        $this->playerStrategiesPlayed = $playerStrategiesPlayed;
    }

    /**
     * @param number $playerMinSelection
     */
    public function setPlayerMinSelection($playerMinSelection)
    {
        $this->playerMinSelection = $playerMinSelection;
    }

    /**
     * @param number $playerMaxSelection
     */
    public function setPlayerMaxSelection($playerMaxSelection)
    {
        $this->playerMaxSelection = $playerMaxSelection;
    }
    
    /**
     * @param string $playerOrderBy
     */
    public function setPlayerOrderBy($playerOrderBy)
    {
        $this->playerOrderBy = $playerOrderBy;
    }

    /**
     * Each player plays according to its settings
     * 
     */
    public function play(){
        if(isset($this->playerStrategies) && !is_array($this->playerStrategies)){
            $luxorPlayer = new LuxorPlayer;
            $luxorPlayer->init();
            $luxorPlayer->setDrawCount(self::$drawCount);
            $luxorPlayer->setTicketCount(self::$ticketCount);
            if($this->playerStrategies == "REGENERATED_RANDOM"){
                $this->playerResults = $luxorPlayer->playWithRandomNumbers(true);
            } elseif($this->playerStrategies == "RANDOM") {
                $this->playerResults = $luxorPlayer->playWithRandomNumbers();
            }
        } else {
            if(isset($this->playerStrategies)){
                $strategies = $this->playerStrategies;
            } else {
                $strategies = self::$strategies;
            }
            if(!empty($this->playerPreviousDraws)){
                $previousDraws = $this->playerPreviousDraws;
            } else {
                $previousDraws = self::$previousDraws;
            }
            if(isset($this->playerRepeat) && $this->playerRepeat != 0){
                $repeatTimes = $this->playerRepeat;
            } else {
                $repeatTimes = self::$repeat;
            }
            if(isset($this->playerWeeksAnalyzed) && $this->playerWeeksAnalyzed != 0){
                $weeksAnalyzed = $this->playerWeeksAnalyzed;
            } else {
                $weeksAnalyzed = self::$weeksAnalyzed;
            }
            if(isset($this->playerMinSelection) && $this->playerMinSelection != 0){
                $minSelection = $this->playerMinSelection;
            } else {
                $minSelection = self::$minSelection;
            }
            if(isset($this->playerMaxSelection) && $this->playerMaxSelection != 0){
                $maxSelection = $this->playerMaxSelection;
            } else {
                $maxSelection = self::$maxSelection;
            }
            if(!empty($this->playerFirstSelection)){
                $firstSelection = $this->playerFirstSelection;
            } else {
                $firstSelection = self::$firstSelection;
            }
            if(!empty($this->playerSecondSelection)){
                $secondSelection = $this->playerSecondSelection;
            } else {
                $secondSelection = self::$secondSelection;
            }
            if(!empty($this->playerThirdSelection)){
                $thirdSelection = $this->playerThirdSelection;
            } else {
                $thirdSelection = self::$thirdSelection;
            }
            if(!empty($this->playerOrderBy)){
                $orderBy = $this->playerOrderBy;
            } else {
                $orderBy = self::$orderBy;
            }
            $selections = [];
            $selections[0] = $firstSelection;
            $selections[1] = $secondSelection;
            $selections[2] = $thirdSelection;
            $game = new LuxorGame;
            for($i = (self::$drawCount-1); $i > 0; $i--){
                $draws = array_slice(self::$draws, $i+1, ($weeksAnalyzed+1));
                //print_r($draws);
                $luxorPlayer = new LuxorPlayer;
                $luxorPlayer->init();
                $ticketGenerator = new LuxorTicketGenerator;                
                if(isset($this->playerStrategiesPlayed) && $this->playerStrategiesPlayed > 1){
                    $ticketCount = self::$ticketCount / $this->playerStrategiesPlayed;
                } else {
                    $ticketCount = self::$ticketCount;
                }
                $analysisResults =  $luxorPlayer->autoAnalyzeStrategies($draws, $previousDraws, $ticketCount, $repeatTimes, $minSelection, $maxSelection, $strategies, $selections, $orderBy);
                /*print_r(['previous_draws' => $previousDraws, 'ticket_count' => $ticketCount, 'repeat_times' => $repeatTimes, 'min_selection' => $minSelection, 
                         'max_selection' => $maxSelection, 'strategies' => $strategies, 'selections' => $selections, 'order_by' => $orderBy]);*/
                
                $selection = [];
                $tickets = [];
                if(isset($this->playerStrategiesPlayed) && $this->playerStrategiesPlayed > 1){
                    $bestStrategies = array_slice($analysisResults, 0, $this->playerStrategiesPlayed);     
                    //print_r($bestStrategies);
                    foreach($bestStrategies as $bestStrategy){
                        //print_r($bestStrategy);
                        $selection += $luxorPlayer->autoGenerateNumbers($draws, $bestStrategy['prev_draws'], $bestStrategy['first_selection'], $bestStrategy['strategy'], $bestStrategy['second_selection'], $bestStrategy['third_selection']);
                        $ticketGenerator->generateTicketsWithRandomNumbersFromSelection($ticketCount, $selection);
                        $tickets += $ticketGenerator->getTickets();
                    }
                } else {
                    $bestStrategy = array_slice($analysisResults, 0, 1);
                    //print_r($bestStrategy);
                    $selection = $luxorPlayer->autoGenerateNumbers($draws, $bestStrategy[key($bestStrategy)]['prev_draws'], $bestStrategy[key($bestStrategy)]['first_selection'], $bestStrategy[key($bestStrategy)]['strategy'], $bestStrategy[key($bestStrategy)]['second_selection'], $bestStrategy[key($bestStrategy)]['third_selection']);
                    $ticketGenerator->generateTicketsWithRandomNumbersFromSelection($ticketCount, $selection);
                    $tickets = $ticketGenerator->getTickets();
                }
                $game->processTicketsForADraw($tickets, self::$draws[$i]);
            }
            $this->playerResults = $game->getResults();  
        }
        return $this->playerResults;
    }
}