<?php
require __DIR__ . '/../vendor/autoload.php';

$luxorPlayer = new LuxorPlayer\LuxorPlayer;
$luxorPlayer->init();
$ticketGenerator = new LuxorPlayer\LuxorTicketGenerator;
$autoPlay = new LuxorPlayer\AutoPlay;


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
3. Autoplay
4. Go back to main menu
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
            playFromConfig();
            break;
        case 3:
            autoPlay();
            break;
        case 4:
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
        if($value['jackpot'] > 0){
            print 'jackpot dates: ' . implode(', ', $value['jackpot_dates']) . PHP_EOL;
        }
        if($value['luxor'] > 0){
            print 'Luxor dates: ' . implode(', ', $value['luxor_dates']) . PHP_EOL;
        }
        if($value['first_frame'] > 0){
            print 'First frame dates: ' . implode(', ', $value['first_frame_dates']) . PHP_EOL;
        }
        if($value['first_picture'] > 0){
            print 'First picture dates: ' . implode(', ', $value['first_picture_dates']) . PHP_EOL;
        }
        if($value['frames'] > 0){
            print 'Frame dates: ' . implode(', ', $value['frame_dates']) . PHP_EOL;
        }
        if($value['pictures'] > 0){
            print 'Picture dates: ' . implode(', ', $value['picture_dates']) . PHP_EOL;
        }
        print PHP_EOL;
        $i++;
     }
     print PHP_EOL;
     main();
}

function playFromConfig()
{
    global $handle, $luxorPlayer;
    
    print "Do you want to save results to excel? (Y = yes N = no) ";
    $toExcel = strtoupper(trim(fgets($handle)));
    $spreadsheet;
    $sheet;
    if($toExcel == 'Y'){
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ranking');
        $sheet->setCellValue('B1', 'strategy');
        $sheet->setCellValue('C1', 'previous draws');
        $sheet->setCellValue('D1', 'random');
        $sheet->setCellValue('E1', 'most');
        $sheet->setCellValue('F1', 'least');
        $sheet->setCellValue('G1', 'mixed');
        $sheet->setCellValue('H1', 'first selection');
        $sheet->setCellValue('I1', 'second selection');
        $sheet->setCellValue('J1', 'third selection');
        $sheet->setCellValue('K1', 'total');
        $sheet->setCellValue('L1', 'jackpot');
        $sheet->setCellValue('M1', 'luxor');
        $sheet->setCellValue('N1', 'first frame');
        $sheet->setCellValue('O1', 'first picture');
        $sheet->setCellValue('P1', 'frames');
        $sheet->setCellValue('Q1', 'pictures');
        $sheet->setCellValue('R1', 'unique jackpot');
        $sheet->setCellValue('S1', 'unique luxor');
        $sheet->setCellValue('T1', 'unique first frame');
        $sheet->setCellValue('U1', 'unique first picture');
        $sheet->setCellValue('V1', 'unique frames');
        $sheet->setCellValue('W1', 'unique pictures');
        $sheet->setCellValue('X1', 'jackpot dates');
        $sheet->setCellValue('Y1', 'luxor dates');
        $sheet->setCellValue('Z1', 'first frame dates');
        $sheet->setCellValue('AA1', 'first picture dates');
        $sheet->setCellValue('AB1', 'frame dates');
        $sheet->setCellValue('AC1', 'picture dates');
        $spreadsheet->getActiveSheet()->getStyle('A1:AC1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('00FFFF');
        
    }
    
    print PHP_EOL;
    
    
    $results = $luxorPlayer->playFromConfig();  
    $i = 1;
    print PHP_EOL;
    foreach($results as $key => $value){
        if($i == 51 || $i == (sizeof($results) - 10)){
            print '...' . PHP_EOL;
        }
        if($i <= 50 || $key == "SAME_RANDOM" || $key == "REGENERATED_RANDOM" || ($i >= sizeof($results) - 10)) {
            print $i  . '. ' . $key . ' reached a total of: ' . number_format((intval($value['total']) * 1000), 0, ',', ' ') . ' Ft' . PHP_EOL;
            //print 'prev draws: ' . $value['prev_draws'] . ', random: ' . $value['random'] . ', most: ' . $value['most'] . ', least: ' . $value['least']  . ', mixed: ' . $value['mixed'] . PHP_EOL;
            //print 'first selection: ' . $value['first_selection'] . ', second selection: ' . $value['second_selection'] . ', third selection: ' . $value['third_selection'] . PHP_EOL;
            print 'jackpot: ' . $value['jackpot'] . ', luxor: ' . $value['luxor'] . ', first frame: ' . $value['first_frame'] . ', first picture: ' . $value['first_picture'] . ', frames: ' . $value['frames'] .
            ', pictures: ' . $value['pictures'] . PHP_EOL . PHP_EOL;
            if($value['jackpot'] > 0){
                print 'jackpot dates: ' . implode(', ', $value['jackpot_dates']) . PHP_EOL;
            }
            if($value['luxor'] > 0){
                print 'Luxor dates: ' . implode(', ', $value['luxor_dates']) . PHP_EOL;    
            }
            if($value['first_frame'] > 0){
                print 'First frame dates: ' . implode(', ', $value['first_frame_dates']) . PHP_EOL;
            }
            if($value['first_picture'] > 0){
                print 'First picture dates: ' . implode(', ', $value['first_picture_dates']) . PHP_EOL;
            }
            if($value['frames'] > 0){
                print 'Frame dates: ' . implode(', ', $value['frame_dates']) . PHP_EOL;
            }
            if($value['pictures'] > 0){
                print 'Picture dates: ' . implode(', ', $value['picture_dates']) . PHP_EOL;
            }
            print PHP_EOL;
        }
        if($toExcel == 'Y'){
            $sheet->setCellValue('A' . ($i+1), $i);
            $sheet->setCellValue('B' . ($i+1), $key);
            $sheet->setCellValue('C' . ($i+1), $value['prev_draws']);
            $sheet->setCellValue('D' . ($i+1), $value['random']);
            $sheet->setCellValue('E' . ($i+1), $value['most']);
            $sheet->setCellValue('F' . ($i+1), $value['least']);
            $sheet->setCellValue('G' . ($i+1), $value['mixed']);
            $sheet->setCellValue('H' . ($i+1), $value['first_selection']);
            $sheet->setCellValue('I' . ($i+1), $value['second_selection']);
            $sheet->setCellValue('J' . ($i+1), $value['third_selection']);
            $sheet->setCellValue('K' . ($i+1), $value['total']);
            $sheet->setCellValue('L' . ($i+1), $value['jackpot']);
            $sheet->setCellValue('M' . ($i+1), $value['luxor']);
            $sheet->setCellValue('N' . ($i+1), $value['first_frame']);
            $sheet->setCellValue('O' . ($i+1), $value['first_picture']);
            $sheet->setCellValue('P' . ($i+1), $value['frames']);
            $sheet->setCellValue('Q' . ($i+1), $value['pictures']);
            $sheet->setCellValue('R' . ($i+1), $value['unique_jackpot']);
            $sheet->setCellValue('S' . ($i+1), $value['unique_luxor']);
            $sheet->setCellValue('T' . ($i+1), $value['unique_first_frame']);
            $sheet->setCellValue('U' . ($i+1), $value['unique_first_picture']);
            $sheet->setCellValue('V' . ($i+1), $value['unique_frame']);
            $sheet->setCellValue('W' . ($i+1), $value['unique_picture']);
            $sheet->setCellValue('X' . ($i+1), implode(', ', $value['jackpot_dates']));
            $sheet->setCellValue('Y' . ($i+1), implode(', ', $value['luxor_dates']));
            $sheet->setCellValue('Z' . ($i+1), implode(', ', $value['first_frame_dates']));
            $sheet->setCellValue('AA' . ($i+1), implode(', ', $value['first_picture_dates']));
            $sheet->setCellValue('AB' . ($i+1), implode(', ', $value['frame_dates']));
            $sheet->setCellValue('AC' . ($i+1), implode(', ', $value['picture_dates']));
        }
        $i++;
    }
    if($toExcel == 'Y'){
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->setAutoFilter('A1:AC'.$i);
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('files/results/luxor_' . date("Y_m_d_H_i_s") .  '.xlsx');
    }
    print PHP_EOL;
    main();
}

function generateNumbers(){
    
    global $handle, $luxorPlayer, $ticketGenerator;
    
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
            print "How many least selected numbers should be included? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
            break;
        case 3:
            $strategy = "LEAST_AND_MOST_DRAWN";
            print "How many least selected numbers should be included? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many most selected numbers should be included? (5-70) ";
            $selection['second'] = intval(trim(fgets($handle)));
            break;
        case 4:
            $strategy = "MOST_DRAWN_AND_RANDOM";
            print "How many most selected numbers should be included? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many random numbers should be selected? (5-70) ";
            $selection['second'] = intval(trim(fgets($handle)));
            break;
        case 5:
            $strategy = "LEAST_DRAWN_AND_RANDOM";
            print "How many least selected numbers should be included? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many random numbers should be selected? (5-70) ";
            $selection['second'] = intval(trim(fgets($handle)));
            break;
        case 6:
            $strategy = "MOST_LEAST_AND_RANDOM";
            print "How many most selected numbers should be included? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many least selected numbers should be included? (5-70) ";
            $selection['second'] = intval(trim(fgets($handle)));
            print PHP_EOL;
            print "How many random numbers should be included? (5-70) ";
            $selection['third'] = intval(trim(fgets($handle)));
            break;
        case 1: default:
            $strategy = "MOST_DRAWN";
            print "How many most selected numbers should be selected? (5-70) ";
            $selection['first'] = intval(trim(fgets($handle)));
    }
    
    print PHP_EOL;
    print "How many tickets do you want to generate? ";
    $numberOfTickets = intval(trim(fgets($handle)));
    print PHP_EOL . PHP_EOL;
    $results = $luxorPlayer->generateNumbers($previousDrawsToSelectFrom, $selection['first'], $strategy, $selection['second'], $selection['third']);
    sort($results['first_range']);
    sort($results['second_range']);
    sort($results['third_range']);
    sort($results['fourth_range']);
    sort($results['fifth_range']);
    print "1. range: " . implode(' ', $results['first_range']) . PHP_EOL;
    print "2. range: " . implode(' ', $results['second_range']) . PHP_EOL;
    print "3. range: " . implode(' ', $results['third_range']) . PHP_EOL;
    print "4. range: " . implode(' ', $results['fourth_range']) . PHP_EOL;
    print "5. range: " . implode(' ', $results['fifth_range']) . PHP_EOL;
    print PHP_EOL;
    $ticketGenerator->generateTicketsWithRandomNumbersFromSelection($numberOfTickets, $results);
    $tickets = $ticketGenerator->getTickets();
    $i = 1;
    foreach($tickets as $ticket) {
        sort($ticket->picture);
        sort($ticket->frame);
        $allInOne = array_merge($ticket->picture, $ticket->frame);
        sort($allInOne);
        print $i . '.  picture: ' . implode(' ', $ticket->picture) . ' frame: ' . implode(' ', $ticket->frame) . PHP_EOL . '    all in one: ' . implode(' ', $allInOne) . PHP_EOL . PHP_EOL;
        $i++;
    }
    print PHP_EOL . PHP_EOL;
    main();
}

function autoPlay(){
    global $autoPlay;
    
    $results = $autoPlay->play();
    $i = 1;
    print PHP_EOL;
    foreach($results as $key => $value){
        print $i  . '. ' . $key . PHP_EOL;
        print 'jackpot: ' . $value['jackpot'] . ', luxor: ' . $value['luxor'] . ', first frame: ' . $value['first_frame'] . ', first picture: ' . $value['first_picture'] . ', frames: ' . $value['frames'] .
        ', pictures: ' . $value['pictures'] . PHP_EOL . PHP_EOL;
        if($value['jackpot'] > 0){
            print 'jackpot dates: ' . implode(', ', $value['jackpot_dates']) . PHP_EOL;
        }
        if($value['luxor'] > 0){
            print 'Luxor dates: ' . implode(', ', $value['luxor_dates']) . PHP_EOL;
        }
        if($value['first_frame'] > 0){
            print 'First frame dates: ' . implode(', ', $value['first_frame_dates']) . PHP_EOL;
        }
        if($value['first_picture'] > 0){
            print 'First picture dates: ' . implode(', ', $value['first_picture_dates']) . PHP_EOL;
        }
        if($value['frames'] > 0){
            print 'Frame dates: ' . implode(', ', $value['frame_dates']) . PHP_EOL;
        }
        if($value['pictures'] > 0){
            print 'Picture dates: ' . implode(', ', $value['picture_dates']) . PHP_EOL;
        }
        print PHP_EOL;
        $i++;
    }
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



