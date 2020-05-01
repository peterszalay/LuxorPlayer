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
    
}