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
                          'draws' => 52,
                          'tickets' => 10,
                          'repeat' => 10,
                          'min_selection' => 25,
                          'max_selection' => 35,
                          'previous_draws' => [11,12,13,14],
                           /* "LEAST_DRAWN","MOST_DRAWN","LEAST_DRAWN_AND_RANDOM","MOST_DRAWN_AND_RANDOM" */
                          'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_DRAWN_AND_RANDOM","MOST_DRAWN_AND_RANDOM","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                          'one_selection' => [20,25,30,35],
                          'two_selections' => ['first' => [5,10,15,20,25], 'second' => [5,10,15,20,25]],
                          'three_selections' => ['first' => [5,10,15,20], 'second' => [5,10,15,20], 'third' => [5,10]],
                        ]
        ];
