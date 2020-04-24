<?php

return [
        /**
        * file paths are used when downloading and storing csv containing draw results
        */
        'file_paths' => 
                        [
                         'remote_path' => 'https://bet.szerencsejatek.hu/cmsfiles/luxor.csv',
                         'local_path' =>  __DIR__ . '/../files/luxor.csv'
                            
                        ],
         /**
          * game variables are used during by computer when automatically playing
          */
        'game_variables' => 
                        [
                          'load_draws' => 2,
                          'play_last_draws' => 100,
                          'play_by_previous_draws' => [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,40,50,60,70,80,90,100],
                          'tickets_played' => [2,5,10,20,50,100,200,500,1000]
                        ]
        ];
