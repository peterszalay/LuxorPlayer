<?php
namespace LuxorPlayer;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


class AutoPlay
{
    use Ordering;
    use Validator;

    private const DEFAULT_WEEKS_ANALYZED = 0;
    private const DEFAULT_DRAWS_PLAYED = 0;
    private const DEFAULT_NUM_TICKETS = 0;
    private const DEFAULT_MIN_SELECTION = 20;
    private const DEFAULT_MAX_SELECTION = 70;
    private const DEFAULT_REPEAT_TIMES = 1;
    private const DEFAULT_STRATEGIES_PLAYED = 1;
    private const DEFAULT_ORDER_BY = "orderByUniqueTotal";
    private string $name = "AutoPlay";
    private array $players = [];
    private array $results = [];
    private Logger $logger;


    public function __construct()
    {
        $this->logger = new Logger($this->name);
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
                AutoPlayer::setDrawCount($drawCount = $this->getIntValue($file['auto_player']['draws_played'], 2, self::DEFAULT_WEEKS_ANALYZED));
                AutoPlayer::setWeeksAnalyzed($weeksAnalyzed = $this->getIntValue($file['auto_player']['weeks_analyzed'], 2, self::DEFAULT_WEEKS_ANALYZED));
                AutoPlayer::setTicketCount($this->getIntValue($file['auto_player']['tickets_per_player'], 2, self::DEFAULT_NUM_TICKETS));
                AutoPlayer::setRepeat($this->getIntValue($file['auto_player']['repeat'], 2, self::DEFAULT_REPEAT_TIMES));
                AutoPlayer::setMinSelection($this->getIntValue($file['auto_player']['min_selection'], self::DEFAULT_MIN_SELECTION, self::DEFAULT_MIN_SELECTION));
                AutoPlayer::setMaxSelection($this->getIntValue($file['auto_player']['max_selection'], self::DEFAULT_MIN_SELECTION, self::DEFAULT_MAX_SELECTION));
                AutoPlayer::setStrategies($this->getArrayValues($file['auto_player']['strategies'], []));
                AutoPlayer::setPreviousDraws($previousDraws = $this->getArrayValues($file['auto_player']['previous_draws'], []));
                AutoPlayer::setFirstSelection($this->getArrayValues($file['auto_player']['one_selection'], []));
                AutoPlayer::setSecondSelection($this->getArrayValues($file['auto_player']['two_selections'], []));
                AutoPlayer::setThirdSelection($this->getArrayValues($file['auto_player']['three_selections'], []));
                
                $fileProcessor = new FileProcessor();
                $fileProcessor->readFileIntoArray($drawCount + $weeksAnalyzed + max($previousDraws));
                $draws = $fileProcessor->getDrawResults();
                AutoPlayer::setDraws($draws);   
                
                if(isset($file['auto_player']['players']) && is_array($file['auto_player']['players'])) {
                    foreach ($file['auto_player']['players'] as $player){
                        if(isset($player['name'])){
                            $newPlayer = AutoPlayer::create($player['name']);
                            $this->players[] = $newPlayer;
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
        $this->results[$playerName] = $startValue;
    }
    
    /**
     * Play with players on by one
     * 
     * @return array $results
     */
    public function play() :array
    {
        $this->createPlayers();
        //loop through the players array and play each player
        foreach($this->players as $player){           
            $this->results[$player->getName()] = $player->play();
        }
        uasort($this->results, [$this, 'orderByTotal']);
        return $this->results;
    }

}