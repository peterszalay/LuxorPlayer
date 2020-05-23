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
                          'draws' => 52,
                          'tickets' => 10,
                          'repeat' => 10,
                          'min_selection' => 25,
                          'max_selection' => 35,
                          'previous_draws' => [11,12,13,14],
                          'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_DRAWN_AND_RANDOM","MOST_DRAWN_AND_RANDOM","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                          'one_selection' => [25,30,35],
                          'two_selections' => ['first' => [5,10,15,20,25], 'second' => [5,10,15,20,25]],
                          'three_selections' => ['first' => [5,10,15,20], 'second' => [5,10,15,20], 'third' => [5,10]],
                        ],
        /**
         * auto players are individual players playing their own strategy
         */
        'auto_player' =>
                        [
                            'draws' => 522,
                            'max_previous_draws' => 104,
                            'repeat' => 1,
                            'tickets_per_player' => 50,
                            'players' => [
                                            0 => [
                                                    'name' => 'Sam Random',
                                                    'random' => true,
                                                    'regenerated' => false
                                                 ],
                                            1 => [
                                                    'name' => 'Reginald Random',
                                                    'random' => true,
                                                    'regenerated' => true
                                                 ],
                                            /*2 => [
                                                    'name' => 'Bess Van Jahr',
                                                    'description' => '', 
                                                    'previous_draws' => [1,2,3,4,5], 
                                                    'random' => true,
                                                    'least' => true,
                                                    'most' => true,
                                                    'mixed' => false,
                                                    'strategies_played' => 1,
                                                    'weeks_analyzed' => 52,
                                                    'repeat_analysis' => 1,
                                                    'min_selection' => 25,
                                                    'max_selection' => 40,
                                                    'one_selection' => [25,30,35],
                                                    'two_selections' => ['first' => [5,10,15,20,25], 'second' => [5,10,15,20,25]],
                                                    'three_selections' => ['first' => [5,10,15,20], 'second' => [5,10,15,20], 'third' => [5,10]]
                                                 ]*/
                                         ]   
                        ]
        ];
