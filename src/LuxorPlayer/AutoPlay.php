<?php
namespace LuxorPlayer;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;


class AutoPlay {
    
    private $players = [];
    private $results = [];
    private $fileProcessor;
    
    /**
     * Creates players according to setting in luxor config under auto_player and initializes results arra which stores final results
     */
    public function createPlayers()
    {
        try{
            $file = include  __DIR__ . '/../../config/luxor.php';
            if(isset($file['auto_player'])){
                //load players from luxor config file
                $drawCount = (isset($file['auto_player']['draws_played']) && is_int($file['auto_player']['draws_played']) && $file['auto_player']['draws_played'] > 1) ? $file['auto_player']['draws_played'] : 0;
                AutoPlayer::setDrawCount($drawCount);
                $weeksAnalyzed = (isset($file['auto_player']['weeks_analyzed']) && is_int($file['auto_player']['weeks_analyzed']) && $file['auto_player']['weeks_analyzed'] > 1) ? $file['auto_player']['weeks_analyzed'] : 0;
                AutoPlayer::setWeeksAnalyzed($weeksAnalyzed);                         
                $ticketCount = (isset($file['auto_player']['tickets_per_player']) && is_int($file['auto_player']['tickets_per_player']) && $file['auto_player']['tickets_per_player'] > 1) ? $file['auto_player']['tickets_per_player'] : 0;
                AutoPlayer::setTicketCount($ticketCount);
                $repeatTimes = (isset($file['auto_player']['repeat']) && is_int($file['auto_player']['repeat']) && $file['auto_player']['repeat'] > 1) ? $file['auto_player']['repeat'] : 1;
                AutoPlayer::setRepeat($repeatTimes);
                $minSelection = (isset($file['auto_player']['min_selection']) && is_int($file['auto_player']['min_selection']) && $file['auto_player']['min_selection'] > 20) ? $file['auto_player']['min_selection'] : 20;
                AutoPlayer::setMinSelection($minSelection);
                $maxSelection = (isset($file['auto_player']['max_selection']) && is_int($file['auto_player']['max_selection']) && $file['auto_player']['max_selection'] > 20) ? $file['auto_player']['max_selection'] : 70;
                AutoPlayer::setMaxSelection($maxSelection);
                $strategies = (isset($file['auto_player']['strategies']) && is_array($file['auto_player']['strategies'])) ? $file['auto_player']['strategies'] : [];
                AutoPlayer::setStrategies($strategies);
                $previousDraws = (isset($file['auto_player']['previous_draws']) && is_array($file['auto_player']['previous_draws'])) ? $file['auto_player']['previous_draws'] : [];
                AutoPlayer::setPreviousDraws($previousDraws);
                $firstSelections = (isset($file['auto_player']['one_selection']) && is_array($file['auto_player']['one_selection'])) ? $file['auto_player']['one_selection'] : [];
                AutoPlayer::setFirstSelection($firstSelections);
                $secondSelections = (isset($file['auto_player']['two_selections']) && is_array($file['auto_player']['two_selections'])) ? $file['auto_player']['two_selections'] : [];
                AutoPlayer::setSecondSelection($secondSelections);
                $thirdSelections = (isset($file['auto_player']['three_selections']) && is_array($file['auto_player']['three_selections'])) ? $file['auto_player']['three_selections'] : [];
                AutoPlayer::setThirdSelection($thirdSelections);
                
                $this->fileProcessor  = new FileProcessor();
                $this->fileProcessor->readFileIntoArray($drawCount + $weeksAnalyzed + max($previousDraws));
                $draws = $this->fileProcessor->getDrawResults();
                AutoPlayer::setDraws($draws);   
                
                if(isset($file['auto_player']['players']) && is_array($file['auto_player']['players'])){
                    foreach ($file['auto_player']['players'] as $player){
                        if(isset($player['name'])){
                            $newPlayer = AutoPlayer::create($player['name']);
                            $this->players[] = $newPlayer;
                            $this->initializePlayerResults($newPlayer->getName());
                            $playerWeeksAnalyzed = (isset($player['weeks_analyzed']) && is_int($player['weeks_analyzed']) && $player['weeks_analyzed'] > 1) ? $player['weeks_analyzed'] : 0;
                            $newPlayer->setPlayerWeeksAnalyzed($playerWeeksAnalyzed);
                            $playerRepeat = (isset($player['repeat']) && is_int($player['repeat']) && $player['repeat'] > 1) ? $player['repeat'] : 0;
                            $newPlayer->setPlayerRepeat($playerRepeat);
                            $playerStrategies = (isset($player['strategies'])) ? $player['strategies'] : [];
                            $newPlayer->setPlayerStrategies($playerStrategies);
                            $playerPreviousDraws = (isset($player['previous_draws']) && is_array($player['previous_draws'])) ? $player['previous_draws'] : [];
                            $newPlayer->setPlayerPreviousDraws($playerPreviousDraws);
                            $playerMinSelection = (isset($player['min_selection']) && is_int($player['min_selection']) && $player['min_selection'] > 20) ? $player['min_selection'] : 20;
                            $newPlayer->setPlayerMinSelection($playerMinSelection);
                            $playerMaxSelection = (isset($player['max_selection']) && is_int($player['max_selection']) && $player['max_selection'] > 20) ? $player['max_selection'] : 70;
                            $newPlayer->setPlayerMaxSelection($playerMaxSelection);
                            $playerFirstSelections = (isset($player['one_selection']) && is_array($player['one_selection'])) ? $player['one_selection'] : [];
                            $newPlayer->setPlayerFirstSelection($playerFirstSelections);
                            $playerSecondSelections = (isset($player['two_selections']) && is_array($player['two_selections'])) ? $player['two_selections'] : [];
                            $newPlayer->setPlayerSecondSelection($playerSecondSelections);
                            $playerThirdSelections = (isset($player['three_selections']) && is_array($player['three_selections'])) ? $player['three_selections'] : [];
                            $newPlayer->setPlayerThirdSelection($playerThirdSelections);
                            $playerStrategiesPlayed = (isset($player['strategies_played']) && is_int($player['strategies_played']) && $player['strategies_played'] > 1) ? $player['strategies_played'] : 1;
                            $newPlayer->setPlayerStrategiesPlayed($playerStrategiesPlayed);
                            $playerOrderBy = (isset($player['order_by']) && is_string($player['order_by']) && $player['order_by'] != '') ? $player['order_by'] : 'orderByUniqueTotal';
                            $newPlayer->setPlayerOrderBy($playerOrderBy);                           
                        }
                    }
                }
            } else {
                $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/error.log', Logger::ERROR));
                $this->logger->error("auto_player not found in luxor config");
            }
        } catch(\Exception $ex){
            $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/error.log', Logger::CRITICAL));
            $this->logger->critical($ex);
        }
    }
    
    /**
     * Add player to $results array with starting values 
     * 
     * @param String $playerName
     */
    private function initializePlayerResults($playerName)
    {
        $startValue = ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0, 'jackpot_dates' => [],
            'luxor_dates' => [], 'first_picture_dates' => [], 'first_frame_dates' => [], 'picture_dates' => [], 'frame_dates' => []];
        $this->results[$playerName] = $startValue;
    }
    
    /**
     * Play with players on by one
     * 
     * @return array $results
     */
    public function play()
    {
        $this->createPlayers();
        //loop through the players array and play each player
        foreach($this->players as $player){           
            $this->results[$player->getName()] = $player->play();
        }
        return $this->results;
    }

}