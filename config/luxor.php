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
          * game variables are used by computer when generating strategies
          */
        'game_variables' => 
                        [
                          'draws' => 100,
                          'tickets' => 50,
                          'repeat' => 1,
                          'previous_draws' => [2,3,4,5,6,7,8,9,10,11,14,30],
                          'one_selection' => [20,25,30,35,40,45,50],
                          'two_selections' => ['first' => [10,15,20,25], 'second' => [10,15,20,25]],
                          'three_selections' => ['first' => [10,15,20,25], 'second' => [10,15,20], 'third' => [5,10,15]],
                        ]
        ];
