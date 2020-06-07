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
          * manual player settings are used by computer when generating strategies
          */
        'manual_player' => 
                        [
                          'draws' => 522,
                          'tickets' => 10,
                          'repeat' => 1,
                          'min_selection' => 25,
                          'max_selection' => 50,
                          'previous_draws' => [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                          'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_DRAWN_AND_RANDOM","MOST_DRAWN_AND_RANDOM","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                          'one_selection' => [25,30,35,40,45],
                          'two_selections' => ['first' => [5,10,15,20,25,30,35,40], 'second' => [5,10,15,20,25,30,35,40]],
                          'three_selections' => ['first' => [5,10,15,20,25,30,35], 'second' => [5,10,15,20,25,30], 'third' => [5,10,15,20]],
                        ],
        /**
         * auto players are individual players playing their own strategy
         */
        'auto_player' =>
                        [
                            'draws_played' => 52,
                            'weeks_analyzed' => 52,
                            'tickets_per_player' => 100,
                            'repeat' => 1,
                            'min_selection' => 25,
                            'max_selection' => 40,
                            'previous_draws' => [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                            'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_DRAWN_AND_RANDOM","MOST_DRAWN_AND_RANDOM","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                            'one_selection' => [25,30,35],
                            'two_selections' => ['first' => [5,10,15,20,25], 'second' => [5,10,15,20,25]],
                            'three_selections' => ['first' => [5,10,15,20], 'second' => [5,10,15,20], 'third' => [5,10]],
                            'players' => [
                                            0 => [
                                                    'name' => 'Sam Random',
                                                    'strategies' => 'RANDOM'
                                                 ],
                                            1 => [
                                                    'name' => 'Reginald Random',
                                                    'strategies' => 'REGENERATED_RANDOM'
                                                 ],
                                            2 => [
                                                    'name' => 'Mostradamus',
                                                    'description' => '',  
                                                    'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_AND_MOST_DRAWN"],
                                                    'strategies_played' => 1,
                                                    'order_by' => 'orderByUniqueTotal' 
                                                 ],
                                            3 => [
                                                    'name' => 'Oscar Okoschka',
                                                    'description' => '',
                                                    'strategies_played' => 1,
                                                    'order_by' => 'orderByUniquePicturesAndFrames'
                                                 ],
                                            4 => [
                                                    'name' => 'Pablo PickAceO',
                                                    'description' => '',
                                                    'max_selection' => 35,
                                                    'strategies_played' => 5,
                                                    'order_by' => 'orderByUniquePicturesAndFrames'
                                                 ]
                                         ]   
                        ]
        ];
