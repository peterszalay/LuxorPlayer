<?php
namespace LuxorPlayer;

/**
 * A Luxor Ticket or Bet consists of a picture (6 numbers betwee 16 and 60) 
 * and a frame (14 numbers between 1 and 75)
 *
 */
class LuxorTicket {
    
    public $picture;
    public $frame;
    
    public function __construct($picture, $frame){
        $this->picture = $picture;
        $this->frame = $frame;
    }
    
    public static function create($picture, $frame){
        return new LuxorTicket($picture, $frame);
    }
}