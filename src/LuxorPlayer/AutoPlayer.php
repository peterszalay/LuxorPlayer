<?php
namespace LuxorPlayer;


class AutoPlayer {
    
    private $name = '';
    private $drawCount = 0;
    private $ticketCount = 0;
    private $random = false;
    private $regenerated = false;
    private $most = false;
    private $least = false;
    private $mixed = false;
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
    public function setDrawCount($drawCount)
    {
        $this->drawCount = $drawCount;
    }

    /**
     * @param int $ticketCount
     */
    public function setTicketCount($ticketCount)
    {
        $this->ticketCount = $ticketCount;
    }

    /**
     * @param boolean $random
     */
    public function setRandom($random)
    {
        $this->random = $random;
    }

    /**
     * @param boolean $regenerated
     */
    public function setRegenerated($regenerated)
    {
        $this->regenerated = $regenerated;
    }

    /**
     * @param boolean $most
     */
    public function setMost($most)
    {
        $this->most = $most;
    }

    /**
     * @param boolean $least
     */
    public function setLeast($least)
    {
        $this->least = $least;
    }

    /**
     * @param boolean $mixed
     */
    public function setMixed($mixed)
    {
        $this->mixed = $mixed;
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
}