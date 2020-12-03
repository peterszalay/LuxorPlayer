<?php

use LuxorPlayer\LuxorTicket;
use PHPUnit\Framework\TestCase;
use LuxorPlayer\LuxorGame;

class LuxorGameTest extends TestCase
{   
    public function testProcessTicket() :void
    {
        $picture = [16,21,31,42,54,56];
        $frame = [2,6,7,9,17,20,35,37,53,59,62,67,68,72];
        $ticket = LuxorTicket::create($picture, $frame);
        $draw = [];
        $draw[0] = ['jackpot_limit' => 40, 'first_picture' => 14, 'first_frame' => 35, 'luxor' => 37,
                    'date' => '2019.05.16'];
        $draw[1] = array_fill(1, 75, 0);

        $draw[1][16] = 1;
        $draw[1][21] = 2;
        $draw[1][31] = 3;
        $draw[1][42] = 4;
        $draw[1][54] = 5;
        $draw[1][56] = 6;
        
        $draw[1][2] = 7;
        $draw[1][6] = 8;
        $draw[1][7] = 9;
        $draw[1][9] = 10;
        $draw[1][17] = 11;
        $draw[1][20] = 12;
        $draw[1][35] = 13;
        $draw[1][37] = 14;
        $draw[1][53] = 15;
        $draw[1][59] = 16;
        $draw[1][62] = 17;
        $draw[1][67] = 18;
        $draw[1][68] = 19;
        $draw[1][72] = 20;
        
        $luxorGame = new LuxorGame;
        $luxorGame->processTicket($ticket, $draw);
        $results = $luxorGame->getResults();

        $this->assertEquals(1, $results['luxor']);
        $this->assertEquals(1, $results['jackpot']);
        $this->assertEquals(1, $results['frames']);
        $this->assertEquals(1, $results['first_frame']);
        $this->assertEquals(1, $results['pictures']);
        $this->assertEquals(1, $results['first_picture']);
        
        $draw[1][56] = 37;
        $luxorGame = new LuxorGame;
        $luxorGame->processTicket($ticket, $draw);
        $results = $luxorGame->getResults();

        $this->assertEquals(1, $results['pictures']);
        $this->assertEquals(0, $results['first_picture']);
        $this->assertEquals(1, $results['luxor']);
        $this->assertEquals(1, $results['jackpot']);
        $this->assertEquals(1, $results['frames']);
        $this->assertEquals(1, $results['first_frame']);
        
        $draw[1][56] = 0;
        $luxorGame = new LuxorGame;
        $luxorGame->processTicket($ticket, $draw);
        $results = $luxorGame->getResults();

        $this->assertEquals(0, $results['pictures']);
        $this->assertEquals(0, $results['first_picture']);
        $this->assertEquals(0, $results['luxor']);
        $this->assertEquals(0, $results['jackpot']);
        $this->assertEquals(1, $results['frames']);
        $this->assertEquals(1, $results['first_frame']);
        
        $draw[1][56] = 0;
        $draw[1][72] = 36;
        $luxorGame = new LuxorGame;
        $luxorGame->processTicket($ticket, $draw);
        $results = $luxorGame->getResults();

        $this->assertEquals(0, $results['pictures']);
        $this->assertEquals(0, $results['first_picture']);
        $this->assertEquals(0, $results['luxor']);
        $this->assertEquals(0, $results['jackpot']);
        $this->assertEquals(1, $results['frames']);
        $this->assertEquals(0, $results['first_frame']);
    }
    
}