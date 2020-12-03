<?php

use PhpOffice\PhpSpreadsheet\Style\Fill;

require __DIR__ . '/../vendor/autoload.php';

print
' 

       /$$       /$$   /$$ /$$   /$$  /$$$$$$  /$$$$$$$             
      | $$      | $$  | $$| $$  / $$ /$$__  $$| $$__  $$            
      | $$      | $$  | $$|  $$/ $$/| $$  \ $$| $$  \ $$            
      | $$      | $$  | $$ \  $$$$/ | $$  | $$| $$$$$$$/            
      | $$      | $$  | $$  >$$  $$ | $$  | $$| $$__  $$            
      | $$      | $$  | $$ /$$/\  $$| $$  | $$| $$  \ $$            
      | $$$$$$$$|  $$$$$$/| $$  \ $$|  $$$$$$/| $$  | $$            
      |________/ \______/ |__/  |__/ \______/ |__/  |__/            
                                                              
                                                              
                                                              
  /$$$$$$$  /$$        /$$$$$$  /$$     /$$ /$$$$$$$$ /$$$$$$$ 
 | $$__  $$| $$       /$$__  $$|  $$   /$$/| $$_____/| $$__  $$
 | $$  \ $$| $$      | $$  \ $$ \  $$ /$$/ | $$      | $$  \ $$
 | $$$$$$$/| $$      | $$$$$$$$  \  $$$$/  | $$$$$   | $$$$$$$/
 | $$____/ | $$      | $$__  $$   \  $$/   | $$__/   | $$__  $$
 | $$      | $$      | $$  | $$    | $$    | $$      | $$  \ $$
 | $$      | $$$$$$$$| $$  | $$    | $$    | $$$$$$$$| $$  | $$
 |__/      |________/|__/  |__/    |__/    |________/|__/  |__/
                                                              
                                                              
                                                              ';
print PHP_EOL;
print 'Welcome to Luxor Player (LP)! LP is a program that can be configured to play the Hungarian lotto game Luxor.' . PHP_EOL;
print PHP_EOL;
print 'What would you like to do?' . PHP_EOL;

$luxorPlayer = new LuxorPlayer\LuxorPlayer;
$luxorPlayer->init();
$ticketGenerator = new LuxorPlayer\LuxorTicketGenerator;
$autoPlay = new LuxorPlayer\AutoPlay;

$handle = fopen ("php://stdin","r");
$playGame = true;

require 'main.php';

main();

