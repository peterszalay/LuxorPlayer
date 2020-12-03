<?php
namespace LuxorPlayer;


class FileProcessor
{
    /**
     * Stores draw results
     */
    private array $drawResults = [];

    /**
     * Reads csv file into $drawResults which can be used by Game class to simulate game
     * @param int $drawCount
     */
    public function readFileIntoArray(int $drawCount = 0) :void
    {
        $file = include  __DIR__ . '/../../config/luxor.php';
        if($drawCount == 0 && isset($file['game_variables']['draws']) && is_int($file['game_variables']['draws'])){
            $drawCount = $file['game_variables']['draws'];
        }
        if($drawCount > 0){
            if (file_exists($file['file_paths']['local_path']) && ($handle = fopen($file['file_paths']['local_path'], "r")) !== FALSE) {
                $i = 0;
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    if($i >= $drawCount){
                        break;
                    }
                    $this->drawResults[$i][0]['date'] = $data[2];
                    $this->drawResults[$i][0]['jackpot_limit'] = $data[3]; 
                    $this->drawResults[$i][0]['first_picture'] = $data[4]; 
                    $this->drawResults[$i][0]['first_frame'] = $data[5]; 
                    $this->drawResults[$i][0]['luxor'] = $data[6];
                   
                   $keys = range(1,75);
                   $this->drawResults[$i][1] = array_fill_keys($keys, 0);
                   $j = 7;
                   $counter = 1;
                   while(isset($data[$j]) && $data[$j] != ""){
                       $drawnNumber = $data[$j];
                       $this->drawResults[$i][1][$drawnNumber] = $counter;
                       $counter++;
                       $j++;
                   }
                   $i++;
                }
                fclose($handle);
            }
        }
    }
    
    /**
     * @return array $drawResults
     */
    public function getDrawResults() :array
    {
        return $this->drawResults;
    }
    
}