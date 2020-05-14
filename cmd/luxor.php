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
$playGame = true;

main();

function main()
{
    global $handle, $playGame;
    
    mainMenu();
    
    while($playGame)
    {
        $input = fgets($handle);
        
        switch($input){
            case 1:
                playLuxorMenu();
                break;
            case 2:
                generateNumbers();
                break;
            case 3:
                $playGame = false;
                exitGame();
                break;
            default:
                print 'Please choose number 1, 2 or 3...' . PHP_EOL;
                mainMenu();
        }
        
    }
}

function mainMenu()
{
    $menu =
    '
1. Play luxor
2. Generate number selection
3. Quit game
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
    
    print PHP_EOL;
    
    switch($input){
        case 1:
            playLuxorManually();
            break;
        case 2:
            print 'Play with parameters given in configuration file...' . PHP_EOL;
            break;
        case 3:
            main();
            break;       
        default:
            print 'Please give number 1, 2 or 3...' . PHP_EOL;
            print $playMenu;
    }
        
}

function playLuxorManually()
{
    global $handle, $luxorPlayer;
    
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
5. Play least drawn and random combined
6. Play most, least and random numbers mixed
' . PHP_EOL;
    
    $strategy = '';
    $previousDrawsToSelectFrom = '';
    $selection = [];
    $selection['first'] = 0;
    $selection['second'] = 0;
    $selection['third'] = 0;
    
    $strategyId = intval(trim(fgets($handle)));
    print PHP_EOL;
    
    print "How many previous draws should be evaluated? ";
    $previousDrawsToSelectFrom = intval(trim(fgets($handle)));
    print PHP_EOL;

    switch($strategyId){
        case 2:
            $strategy = "LEAST_DRAWN";
            print "How many least selected numbers should be selected? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
            break;
        case 3:
            $strategy = "LEAST_AND_MOST_DRAWN";
            print "How many least selected numbers should be selected? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many most selected numbers should be selected? (5-70) ";
            $selection['second'] = intval(trim(fgets($handle)));
            break;
        case 4:
            $strategy = "MOST_DRAWN_AND_RANDOM";
            print "How many most selected numbers should be selected? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many random numbers should be selected? (5-70) ";
            $selection['second'] = intval(trim(fgets($handle)));
            break;
        case 5:
            $strategy = "LEAST_DRAWN_AND_RANDOM";
            print "How many least selected numbers should be selected? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many random numbers should be selected? (5-70) ";
            $selection['second'] = intval(trim(fgets($handle)));
            break;
        case 6:
            $strategy = "MOST_LEAST_AND_RANDOM";
            print "How many most selected numbers should be selected? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many least selected numbers should be selected? (5-70) ";
            $selection['second'] = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many random numbers should be selected? (5-70) ";
            $selection['third'] = intval(trim(fgets($handle)));
            break;
        case 1: default:
            $strategy = "MOST_DRAWN";
            print "How many most selected numbers should be selected? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
    }
    
    print PHP_EOL;
    
    print "How many times do you want to run the simulation? ";
    $numberOfTimesRepeated = intval(trim(fgets($handle)));
    while(!is_int($numberOfTimesRepeated)){
        print PHP_EOL . "Please give number of times you want to run the simulation as a whole number (example: 10). Press E for exit! ";
        $numberOfTimesRepeated = trim(fgets($handle));
        if($numberOfTimesRepeated == "E" || $numberOfTimesRepeated == "e"){
            main();
            break;
        }
    }
    print PHP_EOL;
    
    print "DRAWS: " . $numberOfDraws . " TICKETS: " . $numberOfTickets . " TEST REPEATED: " . $numberOfTimesRepeated . PHP_EOL;
    print "spent: " . number_format(($numberOfDraws * $numberOfTickets * 200), 0, ',', ' ');
    if($numberOfTimesRepeated > 1){
        print " * " . $numberOfTimesRepeated;
    }
    print " Ft" . PHP_EOL . PHP_EOL;
    
    $results = $luxorPlayer->play($numberOfDraws, $numberOfTickets, $previousDrawsToSelectFrom, $strategy, $selection, $numberOfTimesRepeated);
    $i = 1;
    foreach($results as $key => $value){
        print $i  . '. ' . $key . ' reached a total of: ' . number_format((intval($value['total']) * 1000), 0, ',', ' ') . ' Ft' . PHP_EOL;
        print 'jackpot: ' . $value['jackpot'] . ', luxor: ' . $value['luxor'] . ', first frame: ' . $value['first_frame'] . ', first picture: ' . $value['first_picture'] . ', frames: ' . $value['frames'] .
        ', pictures: ' . $value['pictures'] . PHP_EOL . PHP_EOL;
        $i++;
     }
     print PHP_EOL;
     main();
}

function generateNumbers(){
    
    global $handle, $luxorPlayer;
    
    print PHP_EOL . "Choose your strategy:" . PHP_EOL;
    
    print '
1. Most drawn (in previous draws)
2. Least drawn (in previous draws)
3. Most and least drawn combined
4. Most drawn and random combined
5. Least drawn and random combined
6. Most, least and random numbers mixed
' . PHP_EOL;
    
    $strategy = '';
    $previousDrawsToSelectFrom = '';
    $selection = [];
    $selection['first'] = 0;
    $selection['second'] = 0;
    $selection['third'] = 0;
    
    $strategyId = intval(trim(fgets($handle)));
    print PHP_EOL;
    
    print "How many previous draws should be evaluated? ";
    $previousDrawsToSelectFrom = intval(trim(fgets($handle)));
    print PHP_EOL;
    
    switch($strategyId){
        case 2:
            $strategy = "LEAST_DRAWN";
            print "How many least selected numbers should be selected? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
            break;
        case 3:
            $strategy = "LEAST_AND_MOST_DRAWN";
            print "How many least selected numbers should be selected? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many most selected numbers should be selected? (5-70) ";
            $selection['second'] = intval(trim(fgets($handle)));
            break;
        case 4:
            $strategy = "MOST_DRAWN_AND_RANDOM";
            print "How many most selected numbers should be selected? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many random numbers should be selected? (5-70) ";
            $selection['second'] = intval(trim(fgets($handle)));
            break;
        case 5:
            $strategy = "LEAST_DRAWN_AND_RANDOM";
            print "How many least selected numbers should be selected? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many random numbers should be selected? (5-70) ";
            $selection['second'] = intval(trim(fgets($handle)));
            break;
        case 6:
            $strategy = "MOST_LEAST_AND_RANDOM";
            print "How many most selected numbers should be selected? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many least selected numbers should be selected? (5-70) ";
            $selection['second'] = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many random numbers should be selected? (5-70) ";
            $selection['third'] = intval(trim(fgets($handle)));
            break;
        case 1: default:
            $strategy = "MOST_DRAWN";
            print "How many most selected numbers should be selected? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
    }
    
    print PHP_EOL . PHP_EOL;
    $results = $luxorPlayer->generateNumbers($previousDrawsToSelectFrom, $selection['first'], $strategy, $selection['second'], $selection['third']);
    print '1. range: ' . implode(' ', $results['first_range']) . PHP_EOL;
    print '2. range: ' . implode(' ', $results['second_range']) . PHP_EOL;
    print '3. range: ' . implode(' ', $results['third_range']) . PHP_EOL;
    print '4. range: ' . implode(' ', $results['fourth_range']) . PHP_EOL;
    print '5. range: ' . implode(' ', $results['fifth_range']) . PHP_EOL;
    print PHP_EOL;
    main();
}

function exitGame()
{
    global $handle;
    
    fclose($handle);
    print PHP_EOL;
    print 'See you...' . PHP_EOL;
}



