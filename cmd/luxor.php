<?php
require __DIR__ . '/../vendor/autoload.php';

$luxorPlayer = new LuxorPlayer\LuxorPlayer;
$luxorPlayer->init();

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
print 'Welcome to LuxorPlayer (LP)! LP is a program that plays the Hungarian lotto game called Luxor.' . PHP_EOL;
print PHP_EOL;
print 'What would you like to do?' . PHP_EOL;

$handle = fopen ("php://stdin","r");

main();

function main()
{
    global $handle;
    
    mainMenu();

    $playGame = true;
    
    while($playGame)
    {
        $input = fgets($handle);
        
        switch($input){
            case 1:
                playLuxorMenu();
                break;
            case 2:
                $playGame = false;
                break;
            default:
                print 'Please choose number 1 or 2...' . PHP_EOL;
                mainMenu();
        }
        
    }
}

function mainMenu()
{
    $menu =
    '
1. Play luxor
2. Quit game
' . PHP_EOL;
    
    print $menu;
}

function playLuxorMenu()
{
    
$playMenu = 
'    
1. Play with user defined parameters manually
2. Play with parameters given in configuration file
3. Go back to main menu
' . PHP_EOL;
    
    print $playMenu;
    
    global $handle;
    
    $input = fgets($handle);
    
    switch($input){
        case 1:
            playLuxorManually();
            break;
        case 2:
            print PHP_EOL . 'Play with parameters given in configuration file...' . PHP_EOL;
            break;
        case 3:
            main();
            break;       
        default:
            print PHP_EOL . 'Please give number 1, 2 or 3...' . PHP_EOL;
            print $playMenu;
    }
        
}

function playLuxorManually()
{
    global $handle;
    
    print "How many tickets do you want to play with? ";
    $numberOfTickets = intval(trim(fgets($handle)));
    while(!is_int($numberOfTickets)){
        print PHP_EOL . "Please give number of tickets as a whole number (example: 10). Press E for exit! ";
        $numberOfTickets = trim(fgets($handle));
        if($numberOfTickets == "E" || $numberOfTickets == "e"){
            main();
            break;
        }
    }
    print PHP_EOL;
    
    print "How many draws should your game last? ";
    $numberOfDraws = intval(trim(fgets($handle)));
    while(!is_int($numberOfDraws)){
        print PHP_EOL . "Please give number of draws as a whole number (example: 10). Press E for exit! ";
        $numberOfDraws = trim(fgets($handle));
        if($numberOfDraws == "E" || $numberOfDraws == "e"){
            main();
            break;
        }
    }
    print PHP_EOL;
    
    print "Choose your strategy:" . PHP_EOL;
    
    print '
1. Most drawn (in previous draws)
2. Least drawn (in previous draws)
3. Play both, most and least drawn combined
4. Play most drawn and random combined
5. Play Least drawn and random combined
6. Play most, least and random numbers mixed
' . PHP_EOL;
    
    $trategy = '';
    $previousDrawsToSelectFrom = '';
    $firstSelection = 0;
    $secondSelection = 0;
    $thirdSelection = 0;
    
    $strategyId = intval(trim(fgets($handle)));
    print PHP_EOL;
    
    print "How many previous draws should be evaluated? ";
    $previousDrawsToSelectFrom = intval(trim(fgets($handle)));
    print PHP_EOL;

    switch($strategyId){
        case 2:
            $strategy = "LEAST_DRAWN";
            print "How many least selected numbers should be selected? (5-70) ";
            $firstSelection = intval(trim(fgets($handle)));
            break;
        case 3:
            $strategy = "LEAST_AND_MOST_DRAWN";
            print "How many most selected numbers should be selected? (5-70) ";
            $secondSelection = intval(trim(fgets($handle)));
            break;
        case 4:
            $strategy = "MOST_DRAWN_AND_RANDOM";
            print "How many most selected numbers should be selected? (5-70) ";
            $firstSelection = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many random numbers should be selected? (5-70) ";
            $secondSelection = intval(trim(fgets($handle)));
            break;
        case 5:
            $strategy = "LEAST_DRAWN_AND_RANDOM";
            print "How many least selected numbers should be selected? (5-70) ";
            $firstSelection = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many random numbers should be selected? (5-70) ";
            $secondSelection = intval(trim(fgets($handle)));
            break;
        case 6:
            $strategy = "MOST_LEAST_AND_RANDOM";
            print "How many most selected numbers should be selected? (5-70) ";
            $firstSelection = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many least selected numbers should be selected? (5-70) ";
            $secondSelection = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many random numbers should be selected? (5-70) ";
            $thirdSelection = intval(trim(fgets($handle)));
            break;
        case 1: default:
            $strategy = "MOST_DRAWN";
            print "How many most selected numbers should be selected? (5-70) ";
            $firstSelection = intval(trim(fgets($handle)));
    }
    
    print PHP_EOL;
    
    print "How many times do you want to repeat the draws? ";
    $numberOfTimesRepeated = intval(trim(fgets($handle)));
    while(!is_int($numberOfTimesRepeated)){
        print PHP_EOL . "Please give number of times you want to cycle through the draws as a whole number (example: 10). Press E for exit! ";
        $numberOfTimesRepeated = trim(fgets($handle));
        if($numberOfTimesRepeated == "E" || $numberOfTimesRepeated == "e"){
            main();
            break;
        }
    }
    print PHP_EOL; 
    
}

fclose($handle);

print PHP_EOL;
print 'See you...' . PHP_EOL;