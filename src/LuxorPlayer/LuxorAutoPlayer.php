<?php
namespace LuxorPlayer;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Exception;

class LuxorAutoPlayer extends LuxorPlayer
{
    use Ordering;

    private static array $players = [];
    private static array $results = [];

    private array $playerResults = [];
    
    
    public function __construct(string $name)
    {
        $this->playerName = $name;
    }
    
    public static function create(string $name) :LuxorAutoPlayer
    {
        return new LuxorAutoPlayer($name);
    }

    /**
     * @return array $playerResults
     */
    public function getPlayerResults() :array
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
     * @return array
     */
    public static function getPlayers(): array
    {
        return self::$players;
    }

    /**
     * @return array
     */
    public static function getResults(): array
    {
        return self::$results;
    }



    /**
     * Each player plays according to its settings in config
     *
     * @return array
     */
    public function play() :array
    {
        if(isset($this->playerStrategies) && !is_array($this->playerStrategies)){
            $luxorPlayer = new LuxorStrategyPlayer;
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
                $luxorPlayer = new LuxorStrategyPlayer;
                $luxorPlayer->init();
                $ticketGenerator = new LuxorTicketCreator;
                if(isset($this->playerStrategiesPlayed) && $this->playerStrategiesPlayed > 1){
                    $ticketCount = self::$ticketCount / $this->playerStrategiesPlayed;
                } else {
                    $ticketCount = self::$ticketCount;
                }
                $analysisResults =  $luxorPlayer->autoAnalyzeStrategies($draws, $previousDraws, $ticketCount, $repeatTimes, $minSelection,
                                                                        $maxSelection, $strategies, $selections, $orderBy, $maxPreviousDraws);

                $tickets = [];
                if(isset($this->playerStrategiesPlayed) && $this->playerStrategiesPlayed > 1){
                    $bestStrategies = array_slice($analysisResults, 0, $this->playerStrategiesPlayed);
                    foreach($bestStrategies as $bestStrategy){
                        $selection = $luxorPlayer->autoGenerateNumbers($draws, $bestStrategy['prev_draws'], $bestStrategy['first_selection'],
                                                                       $bestStrategy['strategy'], $bestStrategy['second_selection'],
                                                                       $bestStrategy['third_selection']);
                        $ticketGenerator->generateTicketsWithRandomNumbersFromSelection($ticketCount, $selection);
                        $tickets = array_merge($tickets, $ticketGenerator->getTickets());
                    }
                } else {
                    $bestStrategy = array_slice($analysisResults, 0, 1);
                    $selection = $luxorPlayer->autoGenerateNumbers($draws, $bestStrategy[key($bestStrategy)]['prev_draws'],
                                                                   $bestStrategy[key($bestStrategy)]['first_selection'],
                                                                   $bestStrategy[key($bestStrategy)]['strategy'],
                                                                   $bestStrategy[key($bestStrategy)]['second_selection'],
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

    /**
     * Creates players according to setting in luxor config under auto_player and initializes results array
     * which stores final results
     */
    public function createPlayers() :void
    {
        try {
            $file = include  __DIR__ . '/../../config/luxor.php';
            if(isset($file['auto_player'])) {
                //load players from luxor config file
                self::setDrawCount($drawCount = $this->getIntValue($file['auto_player']['draws_played'], 2, self::DEFAULT_WEEKS_ANALYZED));
                LuxorAutoPlayer::setWeeksAnalyzed($weeksAnalyzed = $this->getIntValue($file['auto_player']['weeks_analyzed'], 2, self::DEFAULT_WEEKS_ANALYZED));
                LuxorAutoPlayer::setTicketCount($this->getIntValue($file['auto_player']['tickets_per_player'], 2, self::DEFAULT_NUM_TICKETS));
                LuxorAutoPlayer::setRepeat($this->getIntValue($file['auto_player']['repeat'], 2, self::DEFAULT_REPEAT_TIMES));
                LuxorAutoPlayer::setMinSelection($this->getIntValue($file['auto_player']['min_selection'], self::DEFAULT_MIN_SELECTION, self::DEFAULT_MIN_SELECTION));
                LuxorAutoPlayer::setMaxSelection($this->getIntValue($file['auto_player']['max_selection'], self::DEFAULT_MIN_SELECTION, self::DEFAULT_MAX_SELECTION));
                LuxorAutoPlayer::setStrategies($this->getArrayValues($file['auto_player']['strategies'], []));
                LuxorAutoPlayer::setPreviousDraws($previousDraws = $this->getArrayValues($file['auto_player']['previous_draws'], []));
                LuxorAutoPlayer::setFirstSelection($this->getArrayValues($file['auto_player']['one_selection'], []));
                LuxorAutoPlayer::setSecondSelection($this->getArrayValues($file['auto_player']['two_selections'], []));
                LuxorAutoPlayer::setThirdSelection($this->getArrayValues($file['auto_player']['three_selections'], []));

                $fileProcessor = new LuxorFileProcessor();
                $fileProcessor->readFileIntoArray($drawCount + $weeksAnalyzed + max($previousDraws));
                $draws = $fileProcessor->getDrawResults();
                LuxorAutoPlayer::setDraws($draws);

                if(isset($file['auto_player']['players']) && is_array($file['auto_player']['players'])) {
                    foreach ($file['auto_player']['players'] as $player){
                        if(isset($player['name'])){
                            $newPlayer = LuxorAutoPlayer::create($player['name']);
                            self::$players[] = $newPlayer;
                            $this->initializePlayerResults($newPlayer->getName());
                            $newPlayer->setPlayerWeeksAnalyzed($this->getIntValue($player['weeks_analyzed'], 2, self::DEFAULT_WEEKS_ANALYZED));
                            $newPlayer->setPlayerRepeat($this->getIntValue($player['repeat'], 2, self::DEFAULT_REPEAT_TIMES));
                            $newPlayer->setPlayerStrategies($this->getArrayValues($player['strategies'], []));
                            $newPlayer->setPlayerPreviousDraws($this->getArrayValues($player['previous_draws'], []));
                            $newPlayer->setPlayerMinSelection($this->getIntValue($player['min_selection'], self::DEFAULT_MIN_SELECTION, self::DEFAULT_MIN_SELECTION));
                            $newPlayer->setPlayerMaxSelection($this->getIntValue($player['max_selection'], self::DEFAULT_MIN_SELECTION, self::DEFAULT_MAX_SELECTION));
                            $newPlayer->setPlayerFirstSelection($this->getArrayValues($player['one_selection'], []));
                            $newPlayer->setPlayerSecondSelection($this->getArrayValues($player['two_selections'], []));
                            $newPlayer->setPlayerThirdSelection($this->getArrayValues($player['three_selections'], []));
                            $newPlayer->setPlayerStrategiesPlayed($this->getIntValue($player['strategies_played'], 2, self::DEFAULT_STRATEGIES_PLAYED));
                            $newPlayer->setPlayerOrderBy($this->getStringValue($player['order_by'], self::DEFAULT_ORDER_BY));
                        }
                    }
                }
            } else {
                $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/error.log',
                    Logger::ERROR));
                $this->logger->error("auto_player not found in luxor config");
            }
        } catch(Exception $ex){
            $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/error.log',
                Logger::CRITICAL));
            $this->logger->critical($ex);
        }
    }

    /**
     * Add player to $results array with starting values
     *
     * @param String $playerName
     */
    private function initializePlayerResults(string $playerName) :void
    {
        $startValue = ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0,
                       'frames' => 0, 'pictures' => 0, 'jackpot_dates' => [], 'luxor_dates' => [],
                       'first_picture_dates' => [], 'first_frame_dates' => [], 'picture_dates' => [],
                       'frame_dates' => []];
        self::$results[$playerName] = $startValue;
    }
}