<?php
namespace LuxorPlayer;


class DrawProcessor
{
    use Ordering;

    /**
     * For specific $draws get statistic of how many times each number was drawn and on average in what position
     *
     * @param array $draws
     * @return array
     */
    public function getNumberDrawStatistics(array $draws) :array
    {
        $results = array_fill(1, 75, ['times_drawn' => 0, 'avg_draw_position' => 0]);
        foreach($draws as $draw) {
            for($i = 1; $i <= sizeof($draw[1]); $i++) {
                if($draw[1][$i] != 0) {
                    $results[$i]['times_drawn']++;
                    $results[$i]['avg_draw_position'] += $draw[1][$i];
                }
            }
        }
        $results = $this->calculateAverageDrawPosition($results);
        return $results;
    }

    /**
     * Calculate the average draw position of each number in array identified by its key
     *
     * @param array $results
     * @return array
     */
    public function calculateAverageDrawPosition(array $results) :array
    {
        for($i = 1; $i <= sizeof($results); $i++) {
            if($results[$i]['avg_draw_position'] != 0) {
                $results[$i]['avg_draw_position'] = round($results[$i]['avg_draw_position'] /
                    floatval($results[$i]['times_drawn']), 2);
            }
        }
        return $results;
    }
    
    /**
     * Return most drawn numbers by range from draws
     * 
     * @param array $draws
     * @param int $numberOfMostDrawn
     * @return array
     */
    public function getMostDrawnNumbers(array $draws, int $numberOfMostDrawn = 40) :array
    {
        return $this->getDrawnNumbersAccordingToOrdering($draws, $numberOfMostDrawn, "orderByMostDrawn");
    }
    
    /**
     * Return least drawn numbers by range from draws
     *
     * @param array $draws
     * @param int $numberOfLeastDrawn
     * @return array
     */
    public function getLeastDrawnNumbers(array $draws, int $numberOfLeastDrawn = 40) :array
    {
        return $this->getDrawnNumbersAccordingToOrdering($draws, $numberOfLeastDrawn, "orderByLeastDrawn");
    }
    
    /**
     * Helper function which returns numbers ordered in five ranges
     * 
     * @param array $draws
     * @param int $numberOfDrawn
     * @param string $ordering
     * @return array
     */
    private function getDrawnNumbersAccordingToOrdering(array $draws, int $numberOfDrawn, string $ordering) :array
    {
        $numberOfDrawn = $this->ensureDivisibleByFive($numberOfDrawn);
        $numberOfDrawnPerSlice = $numberOfDrawn / 5;
        $results = $this->getNumberDrawStatistics($draws);
        $firstRange = $this->createSimplifiedOrderedSlice($results, 1, $numberOfDrawnPerSlice, $ordering);
        $secondRange = $this->createSimplifiedOrderedSlice($results, 16, $numberOfDrawnPerSlice, $ordering);
        $thirdRange = $this->createSimplifiedOrderedSlice($results, 31, $numberOfDrawnPerSlice, $ordering);
        $fourthRange = $this->createSimplifiedOrderedSlice($results, 46, $numberOfDrawnPerSlice, $ordering);
        $fifthRange = $this->createSimplifiedOrderedSlice($results, 61, $numberOfDrawnPerSlice, $ordering);
        return ['first_range' => $firstRange, 'second_range' => $secondRange, 'third_range' => $thirdRange,
                'fourth_range' => $fourthRange, 'fifth_range' => $fifthRange];
    }

    /**
     * Extract the slice representing a range from start for length and order it according to $ordering
     *
     * @param array $array
     * @param int $start
     * @param int $length
     * @param string $ordering
     * @return array
     */
    private function createSimplifiedOrderedSlice(array $array, int $start, int $length, string $ordering) :array
    {
        $slice = $this->sliceArray($array, $start);
        usort($slice, [$this, $ordering]);
        $simplifiedSlice = $this->simplifyArray($slice);
        return array_slice($simplifiedSlice, 0, $length);
    }
    
    /**
     * Make multidimensional array one dimensional with only number in it
     * 
     * @param array $array
     * @return array
     */
    private function simplifyArray(array $array) :array
    {
        $result = [];
        foreach($array as $element){
            $result[] = $element['number'];
        }
        return $result;
    }

    /**
     * Slice array also restructure, remove number from key
     *
     * @param array $draw
     * @param int $from
     * @param int $length
     * @return array
     */
    private function sliceArray(array $draw, int $from, $length = 15) :array
    {
        $range = [];
        $counter = 0;
        for($i = $from; $i < ($from + $length); $i++){
            $range[$counter]['number'] = $i;
            $range[$counter]['times_drawn'] = $draw[$i]['times_drawn'];
            $range[$counter]['avg_draw_position'] = $draw[$i]['avg_draw_position'];
            $counter++;
        }
        return $range;
    }

    /**
     * Helper function to ensure $numberOfDrawn is divisible by 5 and between 20 and 80
     *
     * @param int $numberOfDrawn
     * @return int
     */
    private function ensureDivisibleByFive(int $numberOfDrawn) :int
    {
        if($numberOfDrawn < 5){
            return 0;
        }
        if($numberOfDrawn >= 70){
            return 70;
        }
        if($numberOfDrawn % 5 != 0){
            $numberOfDrawn = $numberOfDrawn - ($numberOfDrawn % 5);
        }
        return $numberOfDrawn;
    }
}