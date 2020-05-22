<?php
require __DIR__ . '/../vendor/autoload.php';

$drawsToPlay = 10;
$drawsStrategyAnalyzesBeforeEveryDraw = 3;

$fileProcessor = new LuxorPlayer\FileProcessor;
$fileProcessor->readFileIntoArray($drawsToPlay + $drawsStrategyAnalyzesBeforeEveryDraw);
$draws = $fileProcessor->getDrawResults();
print_r($draws);

for($i = 0; $i < $drawsToPlay; $i++){
    $previousDraws = array_slice($draws, -($drawsStrategyAnalyzesBeforeEveryDraw), $drawsStrategyAnalyzesBeforeEveryDraw, true);
    print "DRAWS TO ANALYZE" .  PHP_EOL;
    print_r($previousDraws);
    //choose strategy or strategies after analysis
    //previousDraws are given to function like LuxorPlayer playWithSelectedNumbers but also $draws are given
    //results are stored in extended array with parameters like 'least' => true, 'most' => true, 'random' => true, 'amalyzedDraws' => 3, 'firsSelection' => ...
    //these parameers will be used by player to chose most apropiate strategy strategies to play
    //after strategy is chosen tickets are generated for strategy and played
   print "DRAW TO BET ON" . PHP_EOL;
    print_r($draws[sizeof($draws)-(3+1)]);
    //bet
    //store results of bet
    array_pop($draws); //pop last results
    // go to next round and repeat
}

//return result for player