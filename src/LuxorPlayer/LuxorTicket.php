<?php
namespace LuxorPlayer;

/**
 * A Luxor Ticket or Bet consists of a picture (6 numbers between 16 and 60)
 * and a frame (14 numbers between 1 and 75)
 *
 */
class LuxorTicket {
    
    private array $picture;
    private array $frame;
    
    public function __construct($picture, $frame){
        $this->picture = $picture;
        $this->frame = $frame;
    }

    /**
     * @return array
     */
    public function getPicture(): array
    {
        return $this->picture;
    }

    /**
     * @return array
     */
    public function getFrame(): array
    {
        return $this->frame;
    }

    /**
     * Remove number from picture
     *
     * @param int $number
     */
    public function removeNumberFromPicture(int $number) :void
    {
        $key = array_search($number, $this->picture);
        unset($this->picture[$key]);
    }

    /**
     * Remove $number from frame
     *
     * @param int $number
     */
    public function removeNumberFromFrame(int $number) :void
    {
        $key = array_search($number, $this->frame);
        unset($this->frame[$key]);
    }
}