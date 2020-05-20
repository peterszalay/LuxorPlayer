<?php
use PHPUnit\Framework\TestCase;
use LuxorPlayer\LuxorPlayer;

class LuxorPlayerTest extends TestCase
{ 
    protected $luxorPlayer;
    protected $draws;
    
    protected function setUp(): void
    {
        $this->luxorPlayer = new LuxorPlayer;
        $this->luxorPlayer->init();
        $this->luxorPlayer->setDrawCount(1);
        $this->luxorPlayer->setTicketCount(2);
    }
    
    public function testPlayWithRandomNumbersReturnsAssociativeArrayWithCorrectKeys()
    {   
        $result = $this->luxorPlayer->playWithRandomNumbers();
        
        $this->assertEquals(sizeof($result), 12);
        $this->assertArrayHasKey('jackpot', $result);
        $this->assertArrayHasKey('luxor', $result);
        $this->assertArrayHasKey('first_frame', $result);
        $this->assertArrayHasKey('first_picture', $result);
        $this->assertArrayHasKey('frames', $result);
        $this->assertArrayHasKey('pictures', $result);
        $this->assertArrayHasKey('jackpot_dates', $result);
        $this->assertArrayHasKey('luxor_dates', $result);
        $this->assertArrayHasKey('first_frame_dates', $result);
        $this->assertArrayHasKey('first_picture_dates', $result);
        $this->assertArrayHasKey('picture_dates', $result);
        $this->assertArrayHasKey('frame_dates', $result);
        
        $result = $this->luxorPlayer->playWithRandomNumbers(true);
        
        $this->assertEquals(sizeof($result), 12);
        $this->assertArrayHasKey('jackpot', $result);
        $this->assertArrayHasKey('luxor', $result);
        $this->assertArrayHasKey('first_frame', $result);
        $this->assertArrayHasKey('first_picture', $result);
        $this->assertArrayHasKey('frames', $result);
        $this->assertArrayHasKey('pictures', $result);
        $this->assertArrayHasKey('jackpot_dates', $result);
        $this->assertArrayHasKey('luxor_dates', $result);
        $this->assertArrayHasKey('first_frame_dates', $result);
        $this->assertArrayHasKey('first_picture_dates', $result);
        $this->assertArrayHasKey('picture_dates', $result);
        $this->assertArrayHasKey('frame_dates', $result);
    }
    
}