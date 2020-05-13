<?php
require __DIR__ . '/../vendor/autoload.php';

$luxorP1 = new LuxorPlayer\LuxorPlayer;
$luxorP1->init();
$most_least_random = $luxorP1->generateNumbers(2, 10, "MOST_LEAST_AND_RANDOM", 10, 5);
$least_drawn_30 = $luxorP1->generateNumbers(7, 30, "LEAST_DRAWN");
$most_drawn_30 = $luxorP1->generateNumbers(5, 30, "MOST_DRAWN");
$least_and_most = $luxorP1->generateNumbers(7, 10, "LEAST_AND_MOST_DRAWN", 10);

print PHP_EOL;

print "MOST_LEAST_AND_RANDOM 2 10 5 5" . PHP_EOL;
print_r($most_least_random);
print "LEAST_DRAWN 7 30" . PHP_EOL;
print_r($least_drawn_30);
print "LEAST_AND_MOST_DRAWN 7 10 10" . PHP_EOL;
print_r($least_and_most);
print "MOST_DRAWN 5 30" . PHP_EOL;
print_r($most_drawn_30);



