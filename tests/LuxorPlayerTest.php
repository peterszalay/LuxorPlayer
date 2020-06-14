<?php
use PHPUnit\Framework\TestCase;
use LuxorPlayer\LuxorPlayer;

class LuxorPlayerTest extends TestCase
{ 
    protected $luxorPlayer;
    protected $draws;
    protected $results;
    
    protected function setUp(): void
    {
        $this->luxorPlayer = new LuxorPlayer;
        $this->luxorPlayer->init();
        $this->luxorPlayer->setDrawCount(1);
        $this->luxorPlayer->setTicketCount(2);
        $this->results = ['a' => ['luxor' => 0, 'unique_luxor' => 0, 'unique_frame' => 5, 'unique_picture' => 15, 'frames' => 5, 'pictures' => 20], 
                          'b' => ['luxor' => 1, 'unique_luxor' => 1, 'unique_frame' => 3, 'unique_picture' => 8, 'frames' => 5, 'pictures' => 10], 
                          'c' => ['luxor' => 0, 'unique_luxor' => 0, 'unique_frame' => 5, 'unique_picture' => 10, 'frames' => 10, 'pictures' => 15],
                          'd' => ['luxor' => 0, 'unique_luxor' => 0, 'unique_frame' => 5, 'unique_picture' => 10, 'frames' => 10, 'pictures' => 16],
                          'e' => ['luxor' => 2, 'unique_luxor' => 1, 'unique_frame' => 3, 'unique_picture' => 7, 'frames' => 5, 'pictures' => 15]
                         ];
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
    
    public function testOrderByUniquePicturesAndFramesReturnsCorrectOrder()
    {       
        uasort($this->results, function($a, $b) {
            $aTotal = ($a['unique_frame'] * 10) + $a['unique_picture'];
            $bTotal = ($b['unique_frame'] * 10) + $b['unique_picture'];
            if($aTotal < $bTotal){
                return 1;
            }else if($aTotal > $bTotal){
                return -1;
            }
            return 0; });
        
        $this->assertEquals(implode('',array_keys($this->results)), 'acdbe');
    }
    
    public function testOrderByUniquePicturesAndFramesDescReturnsCorrectOrder()
    {
        uasort($this->results, function($a, $b) {
            $aTotal = ($a['unique_frame'] * 10) + $a['unique_picture'];
            $bTotal = ($b['unique_frame'] * 10) + $b['unique_picture'];
            if($aTotal > $bTotal){
                return 1;
            }else if($aTotal < $bTotal){
                return -1;
            }
            return 0; });
            
            $this->assertEquals(implode('',array_keys($this->results)), 'ebcda');
    }
    
    public function testOrderByPicturesAndFramesReturnsCorrectOrder()
    {
        uasort($this->results, function($a, $b) {
            $aTotal = ($a['frames'] * 10) + $a['pictures'];
            $bTotal = ($b['frames'] * 10) + $b['pictures'];
            if($aTotal < $bTotal){
                return 1;
            }else if($aTotal > $bTotal){
                return -1;
            }
            return 0; });
            
            $this->assertEquals(implode('',array_keys($this->results)), 'dcaeb');
    }
    
    public function testOrderByPicturesAndFramesDescReturnsCorrectOrder()
    {
        uasort($this->results, function($a, $b) {
            $aTotal = ($a['frames'] * 10) + $a['pictures'];
            $bTotal = ($b['frames'] * 10) + $b['pictures'];
            if($aTotal > $bTotal){
                return 1;
            }else if($aTotal < $bTotal){
                return -1;
            }
            return 0; });
            
            $this->assertEquals(implode('',array_keys($this->results)), 'beacd');
    }
    
    public function testOrderByTotalReturnsCorrectOrder()
    {
        uasort($this->results, function($a, $b) {
            $aTotal = ($a['luxor'] * 100) + ($a['frames'] * 10) + $a['pictures'];
            $bTotal = ($b['luxor'] * 100) + ($b['frames'] * 10) + $b['pictures'];
            if($aTotal < $bTotal){
                return 1;
            }else if($aTotal > $bTotal){
                return -1;
            }
            return 0; });
            
            $this->assertEquals(implode('',array_keys($this->results)), 'ebdca');
    }
    
    public function testOrderByTotalDescReturnsCorrectOrder()
    {
        uasort($this->results, function($a, $b) {
            $aTotal = ($a['luxor'] * 100) + ($a['frames'] * 10) + $a['pictures'];
            $bTotal = ($b['luxor'] * 100) + ($b['frames'] * 10) + $b['pictures'];
            if($aTotal > $bTotal){
                return 1;
            }else if($aTotal < $bTotal){
                return -1;
            }
            return 0; });
            
            $this->assertEquals(implode('',array_keys($this->results)), 'acdbe');
    }
    
    public function testOrderByUniqueTotalReturnsCorrectOrder()
    {
        uasort($this->results, function($a, $b) {
            $aTotal = ($a['unique_luxor'] * 100) + ($a['unique_frame'] * 10) + $a['unique_picture'];
            $bTotal = ($b['unique_luxor'] * 100) + ($b['unique_frame'] * 10) + $b['unique_picture'];
            if($aTotal < $bTotal){
                return 1;
            }else if($aTotal > $bTotal){
                return -1;
            }
            return 0; });
            
            $this->assertEquals(implode('',array_keys($this->results)), 'beacd');
    }
    
    public function testOrderByUniqueTotalDescReturnsCorrectOrder()
    {
        uasort($this->results, function($a, $b) {
            $aTotal = ($a['unique_luxor'] * 100) + ($a['unique_frame'] * 10) + $a['unique_picture'];
            $bTotal = ($b['unique_luxor'] * 100) + ($b['unique_frame'] * 10) + $b['unique_picture'];
            if($aTotal > $bTotal){
                return 1;
            }else if($aTotal < $bTotal){
                return -1;
            }
            return 0; });
            
            $this->assertEquals(implode('',array_keys($this->results)), 'cdaeb');
    }
    
}