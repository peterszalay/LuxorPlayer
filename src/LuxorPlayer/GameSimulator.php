<?php
namespace LuxorPlayer;


class GameSimulator
{
    use Ordering;

    private array $results = [];

    /**
     * Play with players on by one
     * 
     * @return array $results
     */
    public function play() :array
    {
        $luxorAutoPayer = new LuxorAutoPlayer("auto player");
        $luxorAutoPayer->createPlayers();
        //loop through the players array and play each player
        foreach($luxorAutoPayer->getPlayers() as $player){
            $this->results[$player->getName()] = $player->play();
        }
        uasort($this->results, [$this, 'orderByTotal']);
        return $this->results;
    }

}