<?php
require __DIR__ . '/../vendor/autoload.php';

$ticketCount = 1000;
$drawCount = 26;
$repeatTest = 1;

$luxorP1 = new LuxorPlayer\LuxorPlayer;
$luxorP1->init();
$luxorP1->setDrawCount($drawCount);
$luxorP1->setTicketCount($ticketCount);
$i = 1;
$resultArray = ['SAME_RANDOM' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0], 
                'REGENERATED_RANDOM' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_220' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_220' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_230' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_230' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_240' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_240' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_250' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_250' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_AND_MOST_DRAWN_2' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_AND_RANDOM_2' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_AND_RANDOM_2' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_LEAST_AND_RANDOM_2' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_320' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_320' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_330' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_330' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_340' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_340' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_350' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_350' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_AND_MOST_DRAWN_3' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_AND_RANDOM_3' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_AND_RANDOM_3' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_LEAST_AND_RANDOM_3' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_520' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_520' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_530' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_530' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_540' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_540' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_550' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_550' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_AND_MOST_DRAWN_5' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_AND_RANDOM_5' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_AND_RANDOM_5' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_LEAST_AND_RANDOM_5' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_720' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_720' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_730' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_730' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_740' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_740' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_750' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_750' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_AND_MOST_DRAWN_7' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'LEAST_DRAWN_AND_RANDOM_7' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_DRAWN_AND_RANDOM_7' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                'MOST_LEAST_AND_RANDOM_7' => ['total' => 0, 'jackpot' => 0, 'luxor' => 0, 'first_frame' => 0, 'first_picture' => 0, 'frames' => 0, 'pictures' => 0],
                ];

print "DRAWS: " . $drawCount . " TICKETS: " . $ticketCount . " TEST REPEATED: " . $repeatTest . PHP_EOL;
date_default_timezone_set("Europe/Paris");
echo "Started at " . date("h:i:sa") . PHP_EOL;
while($i <= $repeatTest){
    $results = $luxorP1->playWithRandomNumbers();
    $resultArray['SAME_RANDOM']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['SAME_RANDOM']['pictures'] += $results['pictures'];
    $resultArray['SAME_RANDOM']['frames'] += $results['frames'];
    $resultArray['SAME_RANDOM']['first_picture'] += $results['first_picture'];
    $resultArray['SAME_RANDOM']['first_frame'] += $results['first_frame'];
    $resultArray['SAME_RANDOM']['luxor'] += $results['luxor'];
    $resultArray['SAME_RANDOM']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithRandomNumbers(true);
    $resultArray['REGENERATED_RANDOM']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['REGENERATED_RANDOM']['pictures'] += $results['pictures'];
    $resultArray['REGENERATED_RANDOM']['frames'] += $results['frames'];
    $resultArray['REGENERATED_RANDOM']['first_picture'] += $results['first_picture'];
    $resultArray['REGENERATED_RANDOM']['first_frame'] += $results['first_frame'];
    $resultArray['REGENERATED_RANDOM']['luxor'] += $results['luxor'];
    $resultArray['REGENERATED_RANDOM']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(2, 20, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_220']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_220']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_220']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_220']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_220']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_220']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_220']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(2, 20, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_220']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_220']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_220']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_220']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_220']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_220']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_220']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(2, 30, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_230']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_230']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_230']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_230']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_230']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_230']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_230']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(2, 30, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_230']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_230']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_230']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_230']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_230']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_230']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_230']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(2, 40, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_240']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_240']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_240']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_240']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_240']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_240']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_240']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(2, 40, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_240']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_240']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_240']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_240']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_240']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_240']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_240']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(2, 50, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_250']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_250']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_250']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_250']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_250']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_250']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_250']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(2, 50, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_250']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_250']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_250']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_250']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_250']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_250']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_250']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(2, 10, "LEAST_AND_MOST_DRAWN", 10);
    $resultArray['LEAST_AND_MOST_DRAWN_2']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_AND_MOST_DRAWN_2']['pictures'] += $results['pictures'];
    $resultArray['LEAST_AND_MOST_DRAWN_2']['frames'] += $results['frames'];
    $resultArray['LEAST_AND_MOST_DRAWN_2']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_AND_MOST_DRAWN_2']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_AND_MOST_DRAWN_2']['luxor'] += $results['luxor'];
    $resultArray['LEAST_AND_MOST_DRAWN_2']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(2, 15, "LEAST_DRAWN_AND_RANDOM", 10);
    $resultArray['LEAST_DRAWN_AND_RANDOM_2']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_AND_RANDOM_2']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_2']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_2']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_2']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_2']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_2']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(2, 15, "MOST_DRAWN_AND_RANDOM", 10);
    $resultArray['MOST_DRAWN_AND_RANDOM_2']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_AND_RANDOM_2']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_AND_RANDOM_2']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_AND_RANDOM_2']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_AND_RANDOM_2']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_AND_RANDOM_2']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_AND_RANDOM_2']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(2, 10, "MOST_LEAST_AND_RANDOM", 10, 5);
    $resultArray['MOST_LEAST_AND_RANDOM_2']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_LEAST_AND_RANDOM_2']['pictures'] += $results['pictures'];
    $resultArray['MOST_LEAST_AND_RANDOM_2']['frames'] += $results['frames'];
    $resultArray['MOST_LEAST_AND_RANDOM_2']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_LEAST_AND_RANDOM_2']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_LEAST_AND_RANDOM_2']['luxor'] += $results['luxor'];
    $resultArray['MOST_LEAST_AND_RANDOM_2']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(3, 20, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_320']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_320']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_320']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_320']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_320']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_320']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_320']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(3, 20, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_320']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_320']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_320']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_320']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_320']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_320']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_320']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(3, 30, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_330']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_330']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_330']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_330']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_330']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_330']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_330']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(3, 30, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_330']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_330']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_330']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_330']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_330']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_330']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_330']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(3, 40, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_340']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_340']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_340']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_340']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_340']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_340']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_340']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(3, 40, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_340']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_340']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_340']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_340']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_340']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_340']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_340']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(3, 50, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_350']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_350']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_350']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_350']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_350']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_350']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_350']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(3, 50, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_350']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_350']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_350']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_350']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_350']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_350']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_350']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(3, 10, "LEAST_AND_MOST_DRAWN", 10);
    $resultArray['LEAST_AND_MOST_DRAWN_3']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_AND_MOST_DRAWN_3']['pictures'] += $results['pictures'];
    $resultArray['LEAST_AND_MOST_DRAWN_3']['frames'] += $results['frames'];
    $resultArray['LEAST_AND_MOST_DRAWN_3']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_AND_MOST_DRAWN_3']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_AND_MOST_DRAWN_3']['luxor'] += $results['luxor'];
    $resultArray['LEAST_AND_MOST_DRAWN_3']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(3, 15, "LEAST_DRAWN_AND_RANDOM", 10);
    $resultArray['LEAST_DRAWN_AND_RANDOM_3']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_AND_RANDOM_3']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_3']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_3']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_3']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_3']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_3']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(3, 15, "MOST_DRAWN_AND_RANDOM", 10);
    $resultArray['MOST_DRAWN_AND_RANDOM_3']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_AND_RANDOM_3']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_AND_RANDOM_3']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_AND_RANDOM_3']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_AND_RANDOM_3']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_AND_RANDOM_3']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_AND_RANDOM_3']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(3, 10, "MOST_LEAST_AND_RANDOM", 10, 5);
    $resultArray['MOST_LEAST_AND_RANDOM_3']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_LEAST_AND_RANDOM_3']['pictures'] += $results['pictures'];
    $resultArray['MOST_LEAST_AND_RANDOM_3']['frames'] += $results['frames'];
    $resultArray['MOST_LEAST_AND_RANDOM_3']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_LEAST_AND_RANDOM_3']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_LEAST_AND_RANDOM_3']['luxor'] += $results['luxor'];
    $resultArray['MOST_LEAST_AND_RANDOM_3']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(5, 20, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_520']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_520']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_520']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_520']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_520']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_520']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_520']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(5, 20, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_520']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_520']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_520']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_520']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_520']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_520']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_520']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(5, 30, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_530']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_530']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_530']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_530']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_530']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_530']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_530']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(5, 30, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_530']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_530']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_530']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_530']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_530']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_530']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_530']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(5, 40, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_540']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_540']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_540']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_540']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_540']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_540']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_540']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(5, 40, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_540']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_540']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_540']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_540']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_540']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_540']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_540']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(5, 50, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_550']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_550']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_550']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_550']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_550']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_550']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_550']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(5, 50, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_550']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_550']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_550']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_550']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_550']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_550']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_550']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(5, 10, "LEAST_AND_MOST_DRAWN", 10);
    $resultArray['LEAST_AND_MOST_DRAWN_5']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_AND_MOST_DRAWN_5']['pictures'] += $results['pictures'];
    $resultArray['LEAST_AND_MOST_DRAWN_5']['frames'] += $results['frames'];
    $resultArray['LEAST_AND_MOST_DRAWN_5']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_AND_MOST_DRAWN_5']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_AND_MOST_DRAWN_5']['luxor'] += $results['luxor'];
    $resultArray['LEAST_AND_MOST_DRAWN_5']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(5, 15, "LEAST_DRAWN_AND_RANDOM", 10);
    $resultArray['LEAST_DRAWN_AND_RANDOM_5']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_AND_RANDOM_5']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_5']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_5']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_5']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_5']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_5']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(5, 15, "MOST_DRAWN_AND_RANDOM", 10);
    $resultArray['MOST_DRAWN_AND_RANDOM_5']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_AND_RANDOM_5']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_AND_RANDOM_5']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_AND_RANDOM_5']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_AND_RANDOM_5']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_AND_RANDOM_5']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_AND_RANDOM_5']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(5, 10, "MOST_LEAST_AND_RANDOM", 10, 5);
    $resultArray['MOST_LEAST_AND_RANDOM_5']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_LEAST_AND_RANDOM_5']['pictures'] += $results['pictures'];
    $resultArray['MOST_LEAST_AND_RANDOM_5']['frames'] += $results['frames'];
    $resultArray['MOST_LEAST_AND_RANDOM_5']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_LEAST_AND_RANDOM_5']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_LEAST_AND_RANDOM_5']['luxor'] += $results['luxor'];
    $resultArray['MOST_LEAST_AND_RANDOM_5']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(7, 20, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_720']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_720']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_720']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_720']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_720']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_720']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_720']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(7, 20, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_720']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_720']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_720']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_720']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_720']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_720']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_720']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(7, 30, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_730']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_730']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_730']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_730']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_730']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_730']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_730']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(7, 30, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_730']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_730']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_730']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_730']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_730']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_730']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_730']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(7, 40, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_740']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_740']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_740']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_740']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_740']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_740']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_740']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(7, 40, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_740']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_740']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_740']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_740']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_740']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_740']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_740']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(7, 50, "MOST_DRAWN");
    $resultArray['MOST_DRAWN_750']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_750']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_750']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_750']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_750']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_750']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_750']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(7, 50, "LEAST_DRAWN");
    $resultArray['LEAST_DRAWN_750']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_750']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_750']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_750']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_750']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_750']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_750']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(7, 10, "LEAST_AND_MOST_DRAWN", 10);
    $resultArray['LEAST_AND_MOST_DRAWN_7']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_AND_MOST_DRAWN_7']['pictures'] += $results['pictures'];
    $resultArray['LEAST_AND_MOST_DRAWN_7']['frames'] += $results['frames'];
    $resultArray['LEAST_AND_MOST_DRAWN_7']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_AND_MOST_DRAWN_7']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_AND_MOST_DRAWN_7']['luxor'] += $results['luxor'];
    $resultArray['LEAST_AND_MOST_DRAWN_7']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(7, 15, "LEAST_DRAWN_AND_RANDOM", 10);
    $resultArray['LEAST_DRAWN_AND_RANDOM_7']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['LEAST_DRAWN_AND_RANDOM_7']['pictures'] += $results['pictures'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_7']['frames'] += $results['frames'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_7']['first_picture'] += $results['first_picture'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_7']['first_frame'] += $results['first_frame'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_7']['luxor'] += $results['luxor'];
    $resultArray['LEAST_DRAWN_AND_RANDOM_7']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(7, 15, "MOST_DRAWN_AND_RANDOM", 10);
    $resultArray['MOST_DRAWN_AND_RANDOM_7']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);
    $resultArray['MOST_DRAWN_AND_RANDOM_7']['pictures'] += $results['pictures'];
    $resultArray['MOST_DRAWN_AND_RANDOM_7']['frames'] += $results['frames'];
    $resultArray['MOST_DRAWN_AND_RANDOM_7']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_DRAWN_AND_RANDOM_7']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_DRAWN_AND_RANDOM_7']['luxor'] += $results['luxor'];
    $resultArray['MOST_DRAWN_AND_RANDOM_7']['jackpot'] += $results['jackpot'];
    
    $results = $luxorP1->playWithSelectedNumbers(7, 10, "MOST_LEAST_AND_RANDOM", 10, 5);
    $resultArray['MOST_LEAST_AND_RANDOM_7']['total'] += $results['pictures'] + (30 * $results['frames']) + (100 * $results['first_picture']) + (1000 * $results['first_frame']) + (7000 * $results['luxor']) + (40000 * $results['jackpot']);    
    $resultArray['MOST_LEAST_AND_RANDOM_7']['pictures'] += $results['pictures'];
    $resultArray['MOST_LEAST_AND_RANDOM_7']['frames'] += $results['frames'];
    $resultArray['MOST_LEAST_AND_RANDOM_7']['first_picture'] += $results['first_picture'];
    $resultArray['MOST_LEAST_AND_RANDOM_7']['first_frame'] += $results['first_frame'];
    $resultArray['MOST_LEAST_AND_RANDOM_7']['luxor'] += $results['luxor'];
    $resultArray['MOST_LEAST_AND_RANDOM_7']['jackpot'] += $results['jackpot'];
    
    $i++;
}

function orderByTotal($a, $b){
    if($a['total'] < $b['total']){
        return 1;
    }else if($a['total'] > $b['total']){
        return -1;
    }
    return 0;
}

uasort($resultArray, "orderByTotal");
print_r($resultArray);
echo "Finished at " . date("h:i:sa");
