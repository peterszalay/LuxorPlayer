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
        $this->assertEquals($result, 5);
        
        $result = $method->invokeArgs($this->drawProcessor, [79]);
        $this->assertEquals($result, 70);
        
        $result = $method->invokeArgs($this->drawProcessor, [99]);
        $this->assertEquals($result, 70);
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
        
        //first range
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
        
        //second range
        $draws[1][1][17] = 1;
        $draws[2][1][17] = 14;
        
        $draws[0][1][20] = 1;
        $draws[2][1][20] = 18;
        
        $draws[0][1][22] = 30;
        
        $draws[2][1][25] = 12;
        
        $draws[0][1][26] = 2;
        $draws[1][1][26] = 7;
        
        $draws[1][1][27] = 20;
        $draws[2][1][27] = 30;
        
        $draws[0][1][29] = 12;
        $draws[1][1][29] = 10;
        $draws[2][1][29] = 27;
        
        
        //third range
        $draws[0][1][31] = 22;
        
        $draws[1][1][34] = 13;
        
        $draws[1][1][35] = 11;
        
        $draws[0][1][36] = 20;
        $draws[1][1][36] = 25;
        $draws[2][1][36] = 10;
        
        $draws[0][1][38] = 25;
        $draws[1][1][38] = 20;
        $draws[2][1][38] = 11;
        
        $draws[0][1][41] = 21;
        $draws[1][1][41] = 10;
        
        $draws[2][1][43] = 25;
        
        $draws[1][1][45] = 8;
        
        //fourth range
        $draws[0][1][46] = 2;
        
        $draws[0][1][47] = 40;
        $draws[1][1][47] = 33;
        $draws[2][1][47] = 38;
        $draws[3][1][47] = 37;
        
        $draws[0][1][49] = 25;
        $draws[2][1][49] = 20;
        
        $draws[1][1][50] = 15;
        $draws[2][1][50] = 30;
        
        $draws[2][1][53] = 19;
        $draws[3][1][53] = 27;
        
        $draws[1][1][55] = 28;
        $draws[3][1][55] = 35;
        
        $draws[2][1][56] = 20;
        
        $draws[0][1][57] = 43;
        $draws[1][1][57] = 12;
        $draws[2][1][57] = 40;
        $draws[3][1][57] = 39;
        
        $draws[1][1][60] = 10;
        $draws[2][1][60] = 48;
        $draws[3][1][60] = 25;
        
        //fifth range
        $draws[0][1][61] = 2;
        
        $draws[0][1][63] = 1;
        $draws[1][1][63] = 33;
        $draws[2][1][63] = 38;
        $draws[3][1][63] = 37;
        
        $draws[0][1][64] = 25;
        $draws[2][1][64] = 20;
        
        $draws[1][1][66] = 15;
        $draws[2][1][66] = 30;
        
        $draws[2][1][68] = 19;
        $draws[3][1][68] = 23;
        
        $draws[1][1][69] = 28;
        $draws[3][1][69] = 35;
        
        $draws[2][1][71] = 20;
        
        $draws[0][1][72] = 43;
        $draws[1][1][72] = 12;
        $draws[2][1][72] = 40;
        $draws[3][1][72] = 39;
        
        $draws[1][1][75] = 10;
        $draws[2][1][75] = 33;
        $draws[3][1][75] = 25;
        
        $results = $this->drawProcessor->getMostDrawnNumbers($draws, 30);
        $this->assertEquals($results['first_range'], [15,11,3,5,1,6]);
        $this->assertEquals($results['second_range'], [29,26,17,20,27,25]);
        $this->assertEquals($results['third_range'], [36,38,41,45,35,34]);
        $this->assertEquals($results['fourth_range'], [57,47,60,49,50,53]);
        $this->assertEquals($results['fifth_range'], [63,72,75,68,64,66]);
    }
    
    public function testGetLeastDrawnNumbersReturnsCorrectSizeRangeInCorrectOrder()
    {
        $draws = [];
        $draws[0][1] = array_fill(1, 75, 0);
        $draws[1][1] = array_fill(1, 75, 0);
        $draws[2][1] = array_fill(1, 75, 0);
        $draws[3][1] = array_fill(1, 75, 0);
        
        //first range
        $draws[1][1][1] = 3;
        
        $draws[0][1][2] = 40;
        
        $draws[0][1][3] = 22;
        $draws[2][1][3] = 10;
        
        $draws[1][1][4] = 45;
        
        $draws[1][1][5] = 23;
        $draws[3][1][5] = 10;
        
        $draws[3][1][6] = 12;
        
        $draws[0][1][7] = 32;
        
        $draws[0][1][8] = 30;
        $draws[2][1][8] = 9;
        
        $draws[0][1][9] = 30;
        $draws[1][1][9] = 13;
        $draws[2][1][9] = 8;
        
        $draws[3][1][10] = 1;
        
        $draws[0][1][11] = 10;
        $draws[1][1][11] = 20;
        $draws[2][1][11] = 30;
        
        $draws[1][1][12] = 10;
        $draws[2][1][12] = 28;
        
        $draws[1][1][13] = 9;
        $draws[3][1][13] = 2;
        
        $draws[0][1][15] = 12;
        $draws[1][1][15] = 2;
        $draws[2][1][15] = 27;
        
        //second range
        $draws[1][1][16] = 30;
        
        $draws[0][1][17] = 49;
        
        $draws[0][1][18] = 22;
        $draws[2][1][18] = 10;
        
        $draws[1][1][19] = 45;
        
        $draws[1][1][20] = 23;
        $draws[3][1][20] = 10;
        
        $draws[3][1][21] = 12;
        
        $draws[0][1][22] = 32;
        
        $draws[0][1][23] = 30;
        $draws[2][1][23] = 9;
        
        $draws[0][1][24] = 30;
        $draws[1][1][24] = 13;
        $draws[2][1][24] = 8;
        
        $draws[3][1][25] = 1;
        
        $draws[0][1][26] = 10;
        $draws[1][1][26] = 20;
        $draws[2][1][26] = 30;
        
        $draws[1][1][27] = 10;
        $draws[2][1][27] = 28;
        
        $draws[1][1][28] = 9;
        $draws[3][1][28] = 2;
        
        $draws[0][1][30] = 12;
        $draws[1][1][30] = 2;
        $draws[2][1][30] = 27;
        
        //third range (most numbers missing)
        $draws[0][1][31] = 12;
        $draws[1][1][31] = 25;
        $draws[2][1][31] = 20;
        
        $draws[0][1][32] = 25;
        $draws[1][1][32] = 40;
        $draws[2][1][32] = 27;
        
        $draws[1][1][34] = 9;
        $draws[3][1][34] = 24;
        
        $draws[1][1][36] = 19;
        $draws[3][1][36] = 30;
        
        $draws[0][1][37] = 10;
        $draws[1][1][37] = 34;
        
        $draws[2][1][39] = 29;

        $draws[1][1][43] = 30;
        
        $draws[3][1][45] = 4;
        
        //fourth range
        $draws[1][1][46] = 30;
        
        $draws[0][1][47] = 49;
        
        $draws[0][1][48] = 22;
        $draws[2][1][48] = 10;
        
        $draws[1][1][49] = 45;
        
        $draws[1][1][50] = 23;
        $draws[3][1][50] = 10;
        
        $draws[3][1][51] = 12;
        
        $draws[0][1][52] = 32;
        
        $draws[0][1][53] = 30;
        $draws[2][1][53] = 9;
        
        $draws[0][1][54] = 30;
        $draws[1][1][54] = 13;
        $draws[2][1][54] = 8;
        
        $draws[3][1][55] = 1;
        
        $draws[0][1][56] = 10;
        $draws[1][1][56] = 20;
        $draws[2][1][56] = 30;
        
        $draws[1][1][57] = 10;
        $draws[2][1][57] = 28;
        
        $draws[1][1][58] = 9;
        $draws[3][1][58] = 2;
        
        $draws[2][1][59] = 22;
        
        $draws[0][1][60] = 12;
        $draws[1][1][60] = 2;
        $draws[2][1][60] = 27;
        
        //fifth range
        $draws[0][1][61] = 12;
        $draws[1][1][61] = 25;
        $draws[2][1][61] = 20;
        
        $draws[0][1][62] = 25;
        $draws[1][1][62] = 40;
        $draws[2][1][62] = 27;
        
        $draws[1][1][64] = 9;
        $draws[3][1][64] = 24;
        
        $draws[1][1][66] = 19;
        $draws[3][1][66] = 30;
        
        $draws[0][1][67] = 10;
        $draws[1][1][67] = 34;
        
        $draws[2][1][69] = 29;
        
        $draws[1][1][73] = 30;
        
        $draws[3][1][75] = 4;
        
        $results = $this->drawProcessor->getLeastDrawnNumbers($draws);
        $this->assertEquals($results['first_range'], [14,4,2,7,6,1,10,8]);
        $this->assertEquals($results['second_range'], [29,17,19,22,16,21,25,23]);
        $this->assertEquals($results['third_range'], [33,35,38,40,41,42,44,43]);
        $this->assertEquals($results['fourth_range'], [47,49,52,46,59,51,55,53]);
        $this->assertEquals($results['fifth_range'], [63,65,68,70,71,72,74,73]);
    }
}