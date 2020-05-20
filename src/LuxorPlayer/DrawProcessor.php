<?php
namespace LuxorPlayer;


class DrawProcessor {
    
    
    /**
     * For specific $draws get statistic of how many times each number was drawn and on average in what position
     * 
     * @param array $draws
     * @return array $results
     */
    public function getNumberDrawStatistics($draws){
        
        $results = array_fill(1, 75, ['times_drawn' => 0, 'avg_draw_position' => 0]);
        foreach($draws as $draw){
            for($i = 1; $i <= sizeof($draw[1]); $i++){
                if($draw[1][$i] != 0){
                    $results[$i]['times_drawn']++;
                    $results[$i]['avg_draw_position'] += $draw[1][$i];
                }
            }
        }
        for($i = 1; $i <= sizeof($results); $i++){
            if($results[$i]['avg_draw_position'] != 0){
                $results[$i]['avg_draw_position'] = round($results[$i]['avg_draw_position'] / floatval($results[$i]['times_drawn']), 2);
            }
        }
        return $results;
    }
    
    /**
     * Return most drawn numbers by range from draws
     * 
     * @param array $draws
     * @param number $numberOfMostDrawn
     * @return array
     */
    public function getMostDrawnNumbers($draws, $numberOfMostDrawn = 40){     
        return $this->getDrawnNumbersAccordingToOrdering($draws, $numberOfMostDrawn, "orderByMostDrawn");
    }
    
    /**
     * Return least drawn numbers by range from draws
     *
     * @param array $draws
     * @param number $numberOfLeastDrawn
     * @return array
     */
    public function getLeastDrawnNumbers($draws, $numberOfLeastDrawn = 40){
        return $this->getDrawnNumbersAccordingToOrdering($draws, $numberOfLeastDrawn, "orderByLeastDrawn");
    }
    
    /**
     * Helper function which returns numbers ordered in five ranges
     * 
     * @param array $draws
     * @param int $numberOfDrawn
     * @param int $ordering
     * @return array
     */
    private function getDrawnNumbersAccordingToOrdering($draws, $numberOfDrawn, $ordering){
        $numberOfDrawn = $this->ensureDivisableByFive($numberOfDrawn);
        $numberOfDrawnPerSlice = $numberOfDrawn / 5;
        $results = $this->getNumberDrawStatistics($draws);
        $firstRange = $this->createSimplifiedOrderedSlice($results, 1, $numberOfDrawnPerSlice, $ordering);
        $secondRange = $this->createSimplifiedOrderedSlice($results, 16, $numberOfDrawnPerSlice, $ordering);
        $thirdRange = $this->createSimplifiedOrderedSlice($results, 31, $numberOfDrawnPerSlice, $ordering);
        $fourthRange = $this->createSimplifiedOrderedSlice($results, 46, $numberOfDrawnPerSlice, $ordering);
        $fifthRange = $this->createSimplifiedOrderedSlice($results, 61, $numberOfDrawnPerSlice, $ordering);
        print_r($draws);
        print_r($results);
        return ['first_range' => $firstRange, 'second_range' => $secondRange, 'third_range' => $thirdRange, 'fourth_range' => $fourthRange, 'fifth_range' => $fifthRange];
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
    private function createSimplifiedOrderedSlice($array, $start, $length, $ordering){
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
    private function simplifyArray($array){
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
    private function sliceArray($draw, $from, $length = 15){
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
     * Helper function to ensure $numberOfDrawn is divisable by 5 and between 20 and 80
     * 
     * @param int $numberOfMostDrawn
     * @return number
     */
    private function ensureDivisableByFive($numberOfDrawn){
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
    
    /**
     * Helper funciton which is used by usort to sort by times_drawn and avg_draw_position in order of most drawn
     * 
     * @param array $a
     * @param array $b
     * @return number
     */
    private function orderByMostDrawn($a, $b){
        if($a['times_drawn'] < $b['times_drawn'] || ($a['times_drawn'] == $b['times_drawn'] && $a['avg_draw_position'] > $b['avg_draw_position'])){
            return 1;
        }else if($a['times_drawn'] > $b['times_drawn'] || ($a['times_drawn'] == $b['times_drawn'] && $a['avg_draw_position'] < $b['avg_draw_position'])){
            return -1;
        }
        return 0;
    }
    
    /**
     * Helper funciton which is used by usort to sort by times_drawn and avg_draw_position in order of least drawn
     *
     * @param array $a
     * @param array $b
     * @return number
     */
    private function orderByLeastDrawn($a, $b){
        if($a['times_drawn'] > $b['times_drawn'] || ($a['times_drawn'] == $b['times_drawn'] && $a['avg_draw_position'] < $b['avg_draw_position'])){
            return 1;
        }else if($a['times_drawn'] < $b['times_drawn'] || ($a['times_drawn'] == $b['times_drawn'] && $a['avg_draw_position'] > $b['avg_draw_position'])){
            return -1;
        }
        return 0;
    }
}