<?php
namespace LuxorPlayer;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;


class AutoPlay {
    
    private $players = [];
    private $results = [];
    
    /**
     * Creates players according to setting in luxor config under auto_player and initializes results arra which stores final results
     */
    public function createPlayers()
    {
        try{
            $file = include  __DIR__ . '/../../config/luxor.php';
            if(isset($file['auto_player'])){
                //load players from luxor config file
                $drawCount = (isset($file['auto_player']['draws']) && is_int($file['auto_player']['draws']) && $file['auto_player']['draws'] > 1) ? $file['auto_player']['draws'] : 0;
                $ticketCount = (isset($file['auto_player']['tickets_per_player']) && is_int($file['auto_player']['tickets_per_player']) && $file['auto_player']['tickets_per_player'] > 1) ? $file['auto_player']['tickets_per_player'] : 0;
                $repeatTimes = (isset($file['auto_player']['repeat']) && is_int($file['auto_player']['repeat']) && $file['auto_player']['repeat'] > 1) ? $file['auto_player']['repeat'] : 0;
                $minSelection = (isset($file['auto_player']['min_selection']) && is_int($file['auto_player']['min_selection']) && $file['auto_player']['min_selection'] > 20) ? $file['auto_player']['min_selection'] : 20;
                $maxSelection = (isset($file['auto_player']['max_selection']) && is_int($file['auto_player']['max_selection']) && $file['auto_player']['max_selection'] > 20) ? $file['auto_player']['max_selection'] : 70;
                $strategies = (isset($file['auto_player']['strategies']) && is_array($file['auto_player']['strategies'])) ? $file['auto_player']['strategies'] : [];
                $previousDraws = (isset($file['auto_player']['previous_draws']) && is_array($file['auto_player']['previous_draws'])) ? $file['auto_player']['previous_draws'] : [];
                $selections = [];
                $selections[0] = (isset($file['auto_player']['one_selection']) && is_array($file['auto_player']['one_selection'])) ? $file['auto_player']['one_selection'] : [];
                $selections[1] = (isset($file['auto_player']['two_selections']) && is_array($file['auto_player']['two_selections'])) ? $file['auto_player']['two_selections'] : [];
                $selections[2] = (isset($file['auto_player']['three_selections']) && is_array($file['auto_player']['three_selections'])) ? $file['auto_player']['three_selections'] : [];
                if(isset($file['auto_player']['players']) && is_array($file['auto_player']['players'])){
                    foreach ($file['auto_player']['players'] as $player){
                        if(isset($player['name'])){
                            $newPlayer = AutoPlayer::create($player['name']);
                            $newPlayer->setDrawCount($drawCount);
                            $newPlayer->setTicketCount($ticketCount);
                            $newPlayer->setRepeat($repeatTimes);
                            if(isset($player['strategies'])){
                                $newPlayer->setStrategies($player['strategies']);
                            }
                            $this->players[] = $newPlayer;
                            $this->initializePlayerResults($newPlayer->getName());
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
    
    public function play()
    {
        $this->createPlayers();
        //loop through the players array and play each player
        foreach($this->players as $player){
            $player->play();
            $this->results[$player->getName()] = $player->getResults();
        }
        return $this->results;
    }

}