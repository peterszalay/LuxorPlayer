<?php
namespace LuxorPlayer;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;


class FileProcessor {
    
    private $name = "File Processor";
    private $logger;
    /**
     * Stores draw results
     */
    private $drawResults = [];
    
    public function __construct(){
        $this->logger = new Logger($this->name);
    }
    
    /**
     * Reads csv file into $drawResults which can be used by Game class to simulate game
     * 
     */
    public function readFileIntoArray(){
        $file = include  __DIR__ . '/../../config/app.php';
        if(isset($file['game_variables']['load_draws']) && is_int($file['game_variables']['load_draws'])){
            $draws = $file['game_variables']['load_draws'];
            if($draws > 0){
                if (file_exists($file['file_paths']['local_path']) && ($handle = fopen($file['file_paths']['local_path'], "r")) !== FALSE) {
                    $i = $draws - 1;
                    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                        //print $data[2] . ' ' . $data[3] . ' ' . $data[4] . ' ' . $data[5] . ' ' . $data[6] . ' numbers start here: ' . $data[7] . PHP_EOL;
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
                       if($i <= 0){
                           break;
                       }
                       $i--;
                    }
                    fclose($handle);
                }
                $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/game.log', Logger::INFO));
                $this->logger->info("Last " . $draws . " draws loaded for game simulation...");
            }
        }
    }
    
    /**
     * @return $drawResults
     */
    public function getDrawResults(){
        return $this->drawResults;
    }
    
}