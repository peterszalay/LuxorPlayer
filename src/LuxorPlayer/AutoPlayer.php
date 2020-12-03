<?php
namespace LuxorPlayer;


class AutoPlayer
{
    private static array $draws = [];
    private static int $drawCount = 0;
    private static int $ticketCount = 0;
    private static array $strategies = [];
    private static array $previousDraws = [];
    private static int $weeksAnalyzed = 0;
    private static int $repeat = 0;
    private static int $minSelection = 0;
    private static int $maxSelection = 0;
    private static array $firstSelection = [];
    private static array $secondSelection = [];
    private static array $thirdSelection = [];
    private static string $orderBy = '';

    private string $playerName;
    private array $playerStrategies = [];
    private array $playerPreviousDraws = [];
    private int $playerWeeksAnalyzed = 0;
    private int $playerRepeat = 0;
    private int $playerMinSelection = 0;
    private int $playerMaxSelection = 0;
    private array $playerFirstSelection = [];
    private array $playerSecondSelection = [];
    private array $playerThirdSelection = [];
    private int $playerStrategiesPlayed = 0;
    private string $playerOrderBy = '';
    private array $playerResults = [];
    
    
    public function __construct(string $name)
    {
        $this->playerName = $name;
    }
    
    public static function create(string $name) :AutoPlayer
    {
        return new AutoPlayer($name);
    }
    
    /**
     * Set draws
     *
     * @param array $draws
     */
    public static function setDraws(array $draws) :void
    {
        self::$draws = $draws;
    }

    /**
     * Set draw count for player
     *
     * @param int $drawCount
     */
    public static function setDrawCount(int $drawCount) :void
    {
        self::$drawCount = $drawCount;
    }

    /**
     * Set ticket count for player
     *
     * @param int $ticketCount
     */
    public static function setTicketCount(int $ticketCount) :void
    {
        self::$ticketCount = $ticketCount;
    }

    /**
     * Set strategies for player
     *
     * @param array $strategies
     */
    public static function setStrategies(array $strategies) :void
    {
        self::$strategies = $strategies;
    }


    /**
     * Set previous draws
     *
     * @param array $previousDraws
     */
    public static function setPreviousDraws(array $previousDraws) :void
    {
        self::$previousDraws = $previousDraws;
    }

    /**
     * Set weeks analyzed
     *
     * @param int $weeksAnalyzed
     */
    public static function setWeeksAnalyzed(int $weeksAnalyzed) :void
    {
        self::$weeksAnalyzed = $weeksAnalyzed;
    }

    /**
     * Set repeat
     *
     * @param int $repeat
     */
    public static function setRepeat(int $repeat) :void
    {
        self::$repeat = $repeat;
    }

    /**
     * Set minimum selection
     *
     * @param int $minSelection
     */
    public static function setMinSelection(int $minSelection) :void
    {
        self::$minSelection = $minSelection;
    }

    /**
     * Set maximum selection
     * @param int $maxSelection
     */
    public static function setMaxSelection(int $maxSelection) :void
    {
        self::$maxSelection = $maxSelection;
    }

    /**
     * Set first selection
     *
     * @param array $firstSelection
     */
    public static function setFirstSelection(array $firstSelection) :void
    {
        self::$firstSelection = $firstSelection;
    }

    /**
     * Set second selection
     *
     * @param array $secondSelection
     */
    public static function setSecondSelection(array $secondSelection) :void
    {
        self::$secondSelection = $secondSelection;
    }

    /**
     * Set third selection
     *
     * @param array $thirdSelection
     */
    public static function setThirdSelection(array $thirdSelection) :void
    {
        self::$thirdSelection = $thirdSelection;
    }
    
    /**
     * Set order by
     *
     * @param string $orderBy
     */
    public static function setOrderBy(string $orderBy) :void
    {
        AutoPlayer::$orderBy = $orderBy;
    }

    /**
     * @return array $playerResults
     */
    public function getResults() :array
    {
        return $this->playerResults;
    }
    
    /**
     * @return string playerName
     */
    public function getName() :string
    {
        return $this->playerName;
    }
    
    /**
     * @param array $playerStrategies
     */
    public function setPlayerStrategies(array $playerStrategies) :void
    {
        $this->playerStrategies = $playerStrategies;
    }

    /**
     * @param array $playerPreviousDraws
     */
    public function setPlayerPreviousDraws(array $playerPreviousDraws) :void
    {
        $this->playerPreviousDraws = $playerPreviousDraws;
    }

    /**
     * @param int $playerWeeksAnalyzed
     */
    public function setPlayerWeeksAnalyzed(int $playerWeeksAnalyzed) :void
    {
        $this->playerWeeksAnalyzed = $playerWeeksAnalyzed;
    }

    /**
     * @param int $playerRepeat
     */
    public function setPlayerRepeat(int $playerRepeat) :void
    {
        $this->playerRepeat = $playerRepeat;
    }

    /**
     * @param array $playerFirstSelection
     */
    public function setPlayerFirstSelection(array $playerFirstSelection) :void
    {
        $this->playerFirstSelection = $playerFirstSelection;
    }

    /**
     * @param array $playerSecondSelection
     */
    public function setPlayerSecondSelection(array $playerSecondSelection) :void
    {
        $this->playerSecondSelection = $playerSecondSelection;
    }

    /**
     * @param array $playerThirdSelection
     */
    public function setPlayerThirdSelection(array $playerThirdSelection) :void
    {
        $this->playerThirdSelection = $playerThirdSelection;
    }

    /**
     * Set player strategies played
     *
     * @param int $playerStrategiesPlayed
     */
    public function setPlayerStrategiesPlayed(int $playerStrategiesPlayed) :void
    {
        $this->playerStrategiesPlayed = $playerStrategiesPlayed;
    }

    /**
     * Set player minimum selection
     *
     * @param int $playerMinSelection
     */
    public function setPlayerMinSelection(int $playerMinSelection) :void
    {
        $this->playerMinSelection = $playerMinSelection;
    }

    /**
     * Set player max selection
     *
     * @param int $playerMaxSelection
     */
    public function setPlayerMaxSelection(int $playerMaxSelection) :void
    {
        $this->playerMaxSelection = $playerMaxSelection;
    }
    
    /**
     * @param string $playerOrderBy
     */
    public function setPlayerOrderBy(string $playerOrderBy) :void
    {
        $this->playerOrderBy = $playerOrderBy;
    }

    /**
     * Each player plays according to its settings in config
     *
     * @return array
     */
    public function play() :array
    {
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
            if(!empty($this->playerStrategies)){
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
                $maxPreviousDraws = max($previousDraws);
                $draws = array_slice(self::$draws, $i+1, ($weeksAnalyzed + $maxPreviousDraws));
                $luxorPlayer = new LuxorPlayer;
                $luxorPlayer->init();
                $ticketGenerator = new LuxorTicketGenerator;                
                if(isset($this->playerStrategiesPlayed) && $this->playerStrategiesPlayed > 1){
                    $ticketCount = self::$ticketCount / $this->playerStrategiesPlayed;
                } else {
                    $ticketCount = self::$ticketCount;
                }
                $analysisResults =  $luxorPlayer->autoAnalyzeStrategies($draws, $previousDraws, $ticketCount, $repeatTimes, $minSelection, $maxSelection, $strategies, $selections, $orderBy, $maxPreviousDraws);

                $tickets = [];
                if(isset($this->playerStrategiesPlayed) && $this->playerStrategiesPlayed > 1){
                    $bestStrategies = array_slice($analysisResults, 0, $this->playerStrategiesPlayed);
                    foreach($bestStrategies as $bestStrategy){
                        $selection = $luxorPlayer->autoGenerateNumbers($draws, $bestStrategy['prev_draws'], $bestStrategy['first_selection'], $bestStrategy['strategy'], 
                                                                                $bestStrategy['second_selection'], $bestStrategy['third_selection']);
                        $ticketGenerator->generateTicketsWithRandomNumbersFromSelection($ticketCount, $selection);
                        $tickets = array_merge($tickets, $ticketGenerator->getTickets());
                    }
                } else {
                    $bestStrategy = array_slice($analysisResults, 0, 1);
                    $selection = $luxorPlayer->autoGenerateNumbers($draws, $bestStrategy[key($bestStrategy)]['prev_draws'], $bestStrategy[key($bestStrategy)]['first_selection'], 
                                                                           $bestStrategy[key($bestStrategy)]['strategy'], $bestStrategy[key($bestStrategy)]['second_selection'], 
                                                                           $bestStrategy[key($bestStrategy)]['third_selection']);
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