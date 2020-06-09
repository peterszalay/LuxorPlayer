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
                            'weeks_analyzed' => 6,
                            'tickets_per_player' => 50,
                            'repeat' => 10,
                            'min_selection' => 25,
                            'max_selection' => 40,
                            'previous_draws' => [2,3,4,5,6,7,9,11,14],
                            'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_DRAWN_AND_RANDOM","MOST_DRAWN_AND_RANDOM","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                            'one_selection' => [25,30,35,40],
                            'two_selections' => ['first' => [5,10,15,20,25,30,35], 'second' => [5,10,15,20,25,30,35]],
                            'three_selections' => ['first' => [5,10,15,20,25,30], 'second' => [5,10,15,20,25,30], 'third' => [5,10]],
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
                                                    'name' => 'Joaquin Sorsolla',
                                                    'description' => '',
                                                    'max_selection' => 35,
                                                    'strategies_played' => 5,
                                                    'order_by' => 'orderByUniquePicturesAndFrames'
                                                 ],
                                            5 => [
                                                    'name' => 'Gustav Winnt',
                                                    'description' => '',
                                                    'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                                                    'max_selection' => 35,
                                                    'strategies_played' => 5,
                                                    'order_by' => 'orderByUniquePicturesAndFrames'
                                                ],
                                            6 => [
                                                    'name' => 'Edouard Maney',
                                                    'description' => '',
                                                    'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                                                    'max_selection' => 30,
                                                    'strategies_played' => 10,
                                                    'order_by' => 'orderByPicturesAndFrames'
                                                ],
                                            7 => [
                                                    'name' => 'Claude Money',
                                                    'description' => '',
                                                    'max_selection' => 30,
                                                    'strategies_played' => 10,
                                                    'order_by' => 'orderByPicturesAndFrames'
                                                ],
                                            8 =>[
                                                    'name' => 'Franz Least',
                                                    'description' => '',
                                                    'strategies' => ["LEAST_DRAWN","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                                                    'one_selection' => [25,30,35],
                                                    'two_selections' => ['first' => [25,30], 'second' => [5,10]],
                                                    'three_selections' => ['first' => [5,10], 'second' => [20,25], 'third' => [5,10]],
                                                    'max_selection' => 35,
                                                    'strategies_played' => 5,
                                                    'order_by' => 'orderByPicturesAndFrames'
                                                ],
                                            9 =>[
                                                    'name' => 'Elon Most',
                                                    'description' => '',
                                                    'strategies' => ["MOST_DRAWN","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                                                    'one_selection' => [25,30,35],
                                                    'two_selections' => ['first' => [5,10], 'second' => [25,30]],
                                                    'three_selections' => ['first' => [20,25], 'second' => [5,10], 'third' => [5,10]],
                                                    'max_selection' => 35,
                                                    'strategies_played' => 5,
                                                    'order_by' => 'orderByPicturesAndFrames'
                                                ],
                                            10 =>[
                                                    'name' => 'Lucy Winmore',
                                                    'description' => '',
                                                    'max_selection' => 35,
                                                    'previous_draws' => [2,3,4],
                                                    'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                                                    'one_selection' => [25,30,35],
                                                    'two_selections' => ['first' => [5,10,15,20,25,30], 'second' => [5,10,15,20,25,30]],
                                                    'three_selections' => ['first' => [5,10,15,20,25], 'second' => [5,10,15,20,25], 'third' => [5,10]],
                                                    'strategies_played' => 5,
                                                    'order_by' => 'orderByPicturesAndFrames'
                                                 ],
		                            		11 =>[
		                            				'name' => '10 second Tom',
		                            				'description' => '',
		                            				'max_selection' => 30,
		                            				'previous_draws' => [2,3,4],
		                            				'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
		                            				'one_selection' => [25,30],
		                            				'two_selections' => ['first' => [5,10,15,20,25], 'second' => [5,10,15,20,25]],
		                            				'three_selections' => ['first' => [10,15,20,25], 'second' => [5,10,15,20], 'third' => [5,10]],
		                            				'strategies_played' => 10,
		                            				'order_by' => 'orderByPicturesAndFrames'
		                            		],
                                
                                        ]   
                        ]
        ];
