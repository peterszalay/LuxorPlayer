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
    
    public function testEnsureDivisableByFiveReturnsCorrectResults()
    {
        $reflector = new ReflectionClass(DrawProcessor::class);
        $method = $reflector->getMethod('ensureDivisableByFive');
        $method->setAccessible(true);
        
        $result = $method->invokeArgs($this->drawProcessor, [26]);
        $this->assertEquals($result, 25);
        
        $result = $method->invokeArgs($this->drawProcessor, [-100]);
        $this->assertEquals($result, 20);
        
        $result = $method->invokeArgs($this->drawProcessor, [79]);
        $this->assertEquals($result, 75);
        
        $result = $method->invokeArgs($this->drawProcessor, [99]);
        $this->assertEquals($result, 80);
    }
    
    public function testSliceArrayReturnsArrayWithSizeOf15()
    {
        $reflector = new ReflectionClass(DrawProcessor::class);
        $method = $reflector->getMethod('sliceArray');
        $method->setAccessible(true);
        
        $draw = array_fill(1, 75, 0);
        $result = $method->invokeArgs($this->drawProcessor, [$draw, 1]);
        $this->assertEquals(sizeof($result), 15);       
    }
    
    public function testSliceArrayReturnsOnlyCorrectValues()
    {
        $reflector = new ReflectionClass(DrawProcessor::class);
        $method = $reflector->getMethod('sliceArray');
        $method->setAccessible(true);
        
        $draw = array_fill(1, 75, ['times_drawn' => 0, 'avg_draw_position' => 0]);
        $result = $method->invokeArgs($this->drawProcessor, [$draw, 1]);
        $sum = 0;
        foreach($result as $num){
            $sum += $num['times_drawn'];
            $sum += $num['avg_draw_position'];
        }
        $this->assertEquals($sum, 0);
        
        $draw[1]['times_drawn'] = 10;
        $draw[1]['avg_draw_position'] = 5;
        
        $result = $method->invokeArgs($this->drawProcessor, [$draw, 1]);
        $this->assertEquals($result[0]['number'], 1);
        $this->assertEquals($result[0]['times_drawn'], 10);
        $this->assertEquals($result[0]['avg_draw_position'], 5);
    }
    
    public function testSimplifyArrayReturnsOneDimensionalArray()
    {
        $reflector = new ReflectionClass(DrawProcessor::class);
        $method = $reflector->getMethod('simplifyArray');
        $method->setAccessible(true);
        
        $slice = array_fill(0, 15, ['number' => 0, 'times_drawn' => 0, 'avg_draw_position' => 0]);
        for($i = 0; $i < 15; $i++){
            $slice[$i]['number'] = $i + 1;
        }
        $result = $method->invokeArgs($this->drawProcessor, [$slice]);
        $this->assertEquals(sizeof($result), 15);
        $this->assertEquals($result[0], 1);
        $this->assertEquals($result[7], 8);
        $this->assertEquals($result[14], 15);
    }
    
    public function testGetMostDrawnNumbersReturnsArrayContainingFiveArrays()
    {
        $draws = [];
        $draws[0][1] = array_fill(1, 75, 0);
        $draws[1][1] = array_fill(1, 75, 0);
        $draws[2][1] = array_fill(1, 75, 0);
        $draws[3][1] = array_fill(1, 75, 0);
        
        $results = $this->drawProcessor->getMostDrawnNumbers($draws, 50);
        $this->assertIsArray($results);
        $this->assertEquals(sizeof($results), 5);
        $this->assertIsArray($results['first_range'] );
        $this->assertIsArray($results['second_range']);
        $this->assertIsArray($results['third_range']);
        $this->assertIsArray($results['fourth_range']);
        $this->assertIsArray($results['fifth_range']);
    }
    
    public function testGetMostDrawnNumbersReturnsCorrectSizeRangeInCorrectOrder()
    {
        $draws = [];
        $draws[0][1] = array_fill(1, 75, 0);
        $draws[1][1] = array_fill(1, 75, 0);
        $draws[2][1] = array_fill(1, 75, 0);
        $draws[3][1] = array_fill(1, 75, 0);
        
        $draws[1][1][1] = 3;
        
        $draws[0][1][2] = 40;
        
        $draws[0][1][3] = 22;
        $draws[2][1][3] = 10;
        
        $draws[1][1][5] = 23;
        $draws[3][1][5] = 10;
        
        $draws[3][1][6] = 12;
        
        $draws[0][1][7] = 32;
        
        $draws[0][1][11] = 10;
        $draws[1][1][11] = 20;
        $draws[2][1][11] = 30;
        
        $draws[0][1][15] = 12;
        $draws[1][1][15] = 2;
        $draws[2][1][15] = 27;
        
        $results = $this->drawProcessor->getMostDrawnNumbers($draws, 30);
        $this->assertEquals($results['first_range'], [15,11,3,5,1,6]);
    }
}