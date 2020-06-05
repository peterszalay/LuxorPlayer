<?php
namespace LuxorPlayer;


class AutoPlayer {
    
    private $name = '';
    private static $draws = [];
    private static $drawCount = 0;
    private static $ticketCount = 0;
    private static $strategies;
    private static $previousDraws = [];
    private static $weeksAnalyzed = 0;
    private static $repeat = 0;
    private static $minSelection = 0;
    private static $maxSelection = 0;
    private static $firstSelection = [];
    private static $secondSelection = [];
    private static $thirdSelection = [];
    private $strategiesPlayed = 0;
    private $results = [];
    
    
    public function __construct($name)
    {
        $this->name = $name;
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
     * @param int $strategiesPlayed
     */
    public function setStrategiesPlayed($strategiesPlayed)
    {
        $this->strategiesPlayed = $strategiesPlayed;
    }

    /**
     * @return array $results
     */
    public function getResults()
    {
        return $this->results;
    }
    
    /**
     * @return String name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Each player plays according to its settings
     * 
     */
    public function play(){
        if(!is_array($this->strategies)){
            $luxorPlayer = new LuxorPlayer;
            $luxorPlayer->init();
            $luxorPlayer->setDrawCount($this->drawCount);
            $luxorPlayer->setTicketCount($this->ticketCount);
            if($this->strategies == "REGENERATED_RANDOM"){
                $this->results = $luxorPlayer->playWithRandomNumbers(true);
            } elseif($this->strategies == "RANDOM") {
                $this->results = $luxorPlayer->playWithRandomNumbers();
            }
        } else {
            
        }
    }
}