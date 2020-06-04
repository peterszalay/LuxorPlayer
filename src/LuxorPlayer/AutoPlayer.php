<?php
namespace LuxorPlayer;


class AutoPlayer {
    
    private $name = '';
    private static $drawCount = 0;
    private static $ticketCount = 0;
    private static $strategies;
    private $previousDraws = 0;
    private $weeksAnalyzed = 0;
    private $strategiesPlayed = 0;
    private $repeat = 0;
    private $minSelection = 0;
    private $maxSelection = 0;
    private $firstSelection = [];
    private $secondselection = [];
    private $thirdSelection = [];
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
     * @param array $previousDraws
     */
    public function setPreviousDraws($previousDraws)
    {
        $this->previousDraws = $previousDraws;
    }

    /**
     * @param int $weeksAnalyzed
     */
    public function setWeeksAnalyzed($weeksAnalyzed)
    {
        $this->weeksAnalyzed = $weeksAnalyzed;
    }
    
    /**
     * @param int $strategies
     */
    public function setStrategies($strategies)
    {
        $this->strategies = $strategies;
    }

    /**
     * @param int $strategiesPlayed
     */
    public function setStrategiesPlayed($strategiesPlayed)
    {
        $this->strategiesPlayed = $strategiesPlayed;
    }

    /**
     * @param int $repeat
     */
    public function setRepeat($repeat)
    {
        $this->repeat = $repeat;
    }

    /**
     * @param int $minSelection
     */
    public function setMinSelection($minSelection)
    {
        $this->minSelection = $minSelection;
    }

    /**
     * @param int $maxSelection
     */
    public function setMaxSelection($maxSelection)
    {
        $this->maxSelection = $maxSelection;
    }

    /**
     * @param array $firstSelection
     */
    public function setFirstSelection($firstSelection)
    {
        $this->firstSelection = $firstSelection;
    }

    /**
     * @param array $secondselection
     */
    public function setSecondselection($secondselection)
    {
        $this->secondselection = $secondselection;
    }

    /**
     * @param array $thirdSelection
     */
    public function setThirdSelection($thirdSelection)
    {
        $this->thirdSelection = $thirdSelection;
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