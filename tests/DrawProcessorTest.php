<?php
use PHPUnit\Framework\TestCase;
use LuxorPlayer\DrawProcessor;

class DrawProcessorTest extends TestCase
{   
    protected $drawProcessor;
    
    protected function setUp(): void
    {
        $this->drawProcessor = new DrawProcessor;    
    }
    
    public function testGetNumberDrawStatisticsReturnsArrayWithSizeOf75()
    {
        $this->assertEquals(sizeof($this->drawProcessor->getNumberDrawStatistics([])), 75); 
    }
    
    public function testGetNumberDrawStatisticsReturnsArrayWithZerosIfEmptyArrayGivenAsArgument()
    {
        $results = $this->drawProcessor->getNumberDrawStatistics([]);
        $sum = 0;
        foreach($results as $number){
            $sum += $number['times_drawn'];
            $sum += $number['avg_draw_position'];
        }
        $this->assertEquals($sum, 0);
    }
    
    public function testGetNumberDrawStatisticsReturnsArrayWithZerosIfArrayWithZeroValuesGivenAsArgument()
    {
        $draws = [];
        $draws[0][1] = array_fill(1, 75, 0);
        $draws[1][1] = array_fill(1, 75, 0);
        $draws[2][1] = array_fill(1, 75, 0);
        $draws[3][1] = array_fill(1, 75, 0);

        $results = $this->drawProcessor->getNumberDrawStatistics($draws);
        $sum = 0;
        foreach($results as $number){
            $sum += $number['times_drawn'];
            $sum += $number['avg_draw_position'];
        }
        $this->assertEquals($sum, 0);
        
    }
    
    public function testGetNumberDrawStatisticsReturnsCorrectResultsWhenActualNumbersAregiven()
    {
        $draws = [];
        $draws[0][1] = array_fill(1, 75, 0);
        $draws[1][1] = array_fill(1, 75, 0);
        $draws[2][1] = array_fill(1, 75, 0);
        $draws[3][1] = array_fill(1, 75, 0);
        
        $draws[0][1][11] = 10;
        $draws[1][1][11] = 20;
        $draws[2][1][11] = 30;
        
        $results = $this->drawProcessor->getNumberDrawStatistics($draws);
        $this->assertEquals($results[11]['times_drawn'], 3);
        $this->assertEquals($results[11]['avg_draw_position'], 20);
        
        $draws[0][1][7] = 17;
        $draws[1][1][7] = 38;
        
        $results = $this->drawProcessor->getNumberDrawStatistics($draws);
        $this->assertEquals($results[7]['times_drawn'], 2);
        $this->assertEquals($results[7]['avg_draw_position'], 27.5);
        
        $draws[3][1][17] = 1;
        $results = $this->drawProcessor->getNumberDrawStatistics($draws);
        $this->assertEquals($results[17]['times_drawn'], 1);
        $this->assertEquals($results[17]['avg_draw_position'], 1);
        
        $this->assertEquals($results[75]['avg_draw_position'], 0);
    }
}