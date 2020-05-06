<?php
require __DIR__ . '/../vendor/autoload.php';

$fileDownloader = new LuxorPlayer\FileDownloader();
if($fileDownloader->downloadCsv()){
    print 'Downloaded new csv' . PHP_EOL;
} else {
    print 'Remote is not newer' . PHP_EOL;
}

$fileProcessor = new LuxorPlayer\FileProcessor();
$fileProcessor->readFileIntoArray();
$draws = $fileProcessor->getDrawResults();
print_r($draws);
//$results = [];
$counter = 1;
//do {
    $luxorTicketGenerator = new LuxorPlayer\LuxorTicketGenerator();
    $luxorTicketGenerator->generateTicketsWithRandomNumbers(100);
    $tickets = $luxorTicketGenerator->getTickets();
    print_r($tickets);

    $luxorGame = new LuxorPlayer\LuxorGame();
    $results = $luxorGame->processTicketsForDraws($tickets, $draws);
    print_r($results);
    $counter++;
    //} while($results['first_frame')

