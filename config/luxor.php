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
                          'draws' => 25,
                          'tickets' => 50,
                          'repeat' => 5,
                          'min_selection' => 25,
                          'max_selection' => 50,
                          'previous_draws' => [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                          'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_DRAWN_AND_RANDOM","MOST_DRAWN_AND_RANDOM","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                          'one_selection' => [25,30,35,40,45,50],
                          'two_selections' => ['first' => [5,10,15,20,25,30,35,40,45], 'second' => [5,10,15,20,25,30,35,40,45]],
                          'three_selections' => ['first' => [5,10,15,20,25,30,35,40], 'second' => [5,10,15,20,25,30,35,40], 'third' => [5,10,15,20,25]],
                        ],
        /**
         * auto players are individual players playing their own strategy
         */
        'auto_player' =>
                        [
                            'draws_played' => 52,
                            'weeks_analyzed' => 3,
                            'tickets_per_player' => 50,
                            'repeat' => 10,
                            'min_selection' => 25,
                            'max_selection' => 50,
                            'previous_draws' => [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                          	'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_DRAWN_AND_RANDOM","MOST_DRAWN_AND_RANDOM","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                          	'one_selection' => [25,30,35,40,45,50],
                          	'two_selections' => ['first' => [5,10,15,20,25,30,35,40,45], 'second' => [5,10,15,20,25,30,35,40,45]],
                          	'three_selections' => ['first' => [5,10,15,20,25,30,35,40], 'second' => [5,10,15,20,25,30,35,40], 'third' => [5,10,15,20,25]],
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
                                                    'name' => 'Ba',
                                                    'description' => 'A god of fertility',  
                                                    'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_AND_MOST_DRAWN"],
                                                    'strategies_played' => 1,
                                                    'order_by' => 'orderByUniqueTotal' 
                                                 ],
                                            3 => [
                                                    'name' => 'Anubis',
                                                    'description' => 'The god/goddess of embalming and protector of the dead',
                                                    'strategies_played' => 1,
                                                    'order_by' => 'orderByUniquePicturesAndFrames'
                                                 ],
                                            4 => [
                                                    'name' => 'Geb',
                                                    'description' => 'An earth god and member of the Ennead[',
                                                    'max_selection' => 40,
                                                    'strategies_played' => 5,
                                                    'order_by' => 'orderByUniquePicturesAndFrames'
                                                 ],
                                            5 => [
                                                    'name' => 'Anhur',
                                                    'description' => 'A god of war and hunting',
                                                    'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                                                    'max_selection' => 40,
                                                    'strategies_played' => 5,
                                                    'order_by' => 'orderByUniquePicturesAndFrames'
                                                ],
                                            6 => [
                                                    'name' => 'Hesat',
                                                    'description' => 'A maternal cow goddess',
                                                    'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                                                    'max_selection' => 35,
                                                    'strategies_played' => 10,
                                                    'order_by' => 'orderByPicturesAndFrames'
                                                ],
                                            7 => [
                                                    'name' => 'Heqet',
                                                    'description' => 'Frog goddess said to protect women in childbirth',
                                                    'max_selection' => 35,
                                                    'strategies_played' => 10,
                                                    'order_by' => 'orderByPicturesAndFrames'
                                                ],
                                            8 =>[
                                                    'name' => 'Bat',
                                                    'description' => 'Cow goddess from early in Egyptian history, eventually absorbed by Hathor',
													'max_selection' => 40,
                                                    'strategies' => ["LEAST_DRAWN","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                                                    'one_selection' => [25,30,35],
                                                    'two_selections' => ['first' => [25,30], 'second' => [5,10]],
                                                    'three_selections' => ['first' => [5,10], 'second' => [20,25], 'third' => [5,10]],
                                                    'strategies_played' => 5,
                                                    'order_by' => 'orderByPicturesAndFrames'
                                                ],
                                            9 =>[
                                                    'name' => 'Ra',
                                                    'description' => 'The foremost Egyptian sun god, involved in creation and the afterlife. Mythological ruler of the gods, father of every Egyptian king, and the patron god of Heliopolis',
													'max_selection' => 40,
                                                    'strategies' => ["MOST_DRAWN","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                                                    'one_selection' => [25,30,35],
                                                    'two_selections' => ['first' => [5,10], 'second' => [25,30]],
                                                    'three_selections' => ['first' => [20,25], 'second' => [5,10], 'third' => [5,10]],
                                                    'strategies_played' => 5,
                                                    'order_by' => 'orderByPicturesAndFrames'
                                                ],
                                            10 =>[
                                                    'name' => 'Nu',
                                                    'description' => 'Personification of the formless, watery disorder from which the world emerged at creation and a member of the Ogdoad',
                                                    'max_selection' => 40,
                                                    'previous_draws' => [2,3,4],
                                                    'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
                                                    'one_selection' => [25,30,35],
                                                    'two_selections' => ['first' => [5,10,15,20,25,30], 'second' => [5,10,15,20,25,30]],
                                                    'three_selections' => ['first' => [5,10,15,20,25], 'second' => [5,10,15,20,25], 'third' => [5,10]],
                                                    'strategies_played' => 5,
                                                    'order_by' => 'orderByPicturesAndFrames'
                                                 ],
		                            		11 =>[
		                            				'name' => 'Thoth',
		                            				'description' => 'A moon god, and a god of writing and scribes, and patron deity of Hermopolis',
		                            				'max_selection' => 35,
		                            				'previous_draws' => [2,3,4],
		                            				'strategies' => ["LEAST_DRAWN","MOST_DRAWN","LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"],
		                            				'one_selection' => [25,30,35],
		                            				'two_selections' => ['first' => [5,10,15,20,25], 'second' => [5,10,15,20,25]],
		                            				'three_selections' => ['first' => [10,15,20,25], 'second' => [5,10,15,20], 'third' => [5,10]],
		                            				'strategies_played' => 10,
		                            				'order_by' => 'orderByPicturesAndFrames'
												],
											12 =>[
		                            				'name' => 'Shu',
		                            				'description' => ' Embodiment of wind or air, a member of the Ennead',
		                            				'max_selection' => 30,
		                            				'one_selection' => [25,30],
		                            				'two_selections' => ['first' => [5,10,15,20,25], 'second' => [5,10,15,20,25]],
		                            				'three_selections' => ['first' => [10,15,20,25], 'second' => [5,10,15,20], 'third' => [5,10]],
		                            				'strategies_played' => 25,
		                            				'order_by' => 'orderByPicturesAndFrames'
												],
											13 =>[
		                            				'name' => 'Nut',
		                            				'description' => 'A sky goddess, a member of the Ennead',
		                            				'strategies_played' => 2,
		                            				'order_by' => 'orderByPicturesAndFrames'
												],
                                            14 =>[
                                                    'name' => 'Heh',
                                                    'description' => 'Personification of infinity and a member of the Ogdoad',
                                                    'max_selection' => 25,
                                                    'one_selection' => [25],
                                                    'two_selections' => ['first' => [5,10,15], 'second' => [5,10,15]],
                                                    'three_selections' => ['first' => [5,10,15], 'second' => [5,10,15], 'third' => [5,10]],
                                                    'strategies_played' => 50,
                                                    'order_by' => 'orderByPicturesAndFrames'
                                                ],
                                            15 =>[
                                                    'name' => 'Maat',
                                                    'description' => 'Goddess who personified truth, justice, and order',
                                                    'max_selection' => 25,
                                                    'one_selection' => [25],
                                                    'two_selections' => ['first' => [5,10,15], 'second' => [5,10,15]],
                                                    'three_selections' => ['first' => [5,10,15], 'second' => [5,10,15], 'third' => [5,10]],
                                                    'strategies_played' => 50,
                                                    'order_by' => 'orderByUniquePicturesAndFrames'
                                                ],
		                            		16 =>[
		                            				'name' => 'Isis',
		                            				'description' => 'Wife of Osiris and mother of Horus, linked with funerary rites, motherhood, protection, and magic',
		                            				'strategies_played' => 1,
		                            				'order_by' => 'orderByTotal'
		                            			],
		                            		17 =>[
		                            				'name' => 'Amun',
		                            				'description' => 'A creator god, patron deity of the city of Thebes, and the preeminent deity in Egypt during the New Kingdom',
		                            				'max_selection' => 45,
		                            				'strategies_played' => 2,
		                            				'order_by' => 'orderByTotal'
		                            		    ],
		                            		18 =>[
		                            				'name' => 'Osiris',
		                            				'description' => 'god of death and resurrection who rules the underworld and enlivens vegetation, the sun god, and deceased souls',
		                            				'max_selection' => 40,
		                            				'strategies_played' => 5,
		                            				'order_by' => 'orderByTotal'
		                            		    ],
		                            		19 =>[
		                            				'name' => 'Kek',
		                            				'description' => 'The god of Chaos and Darkness, as well as being the concept of primordial darkness',
		                            				'max_selection' => 35,
		                            				'strategies_played' => 10,
		                            				'order_by' => 'orderByTotal'
		                            		    ],
		                            		20 =>[
		                            				'name' => 'Horus',
		                            				'description' => 'A major god, usually shown as a falcon or as a human child, linked with the sky, the sun, kingship, protection, and healing',
		                            				'max_selection' => 30,
		                            				'strategies_played' => 25,
		                            				'order_by' => 'orderByTotal'
		                            		    ],
		                            		21 =>[
		                            				'name' => 'Hathor',
		                            				'description' => 'One of the most important goddesses, linked with the sky, the sun, sexuality and motherhood, music and dance, foreign lands and goods, and the afterlife',
		                            				'max_selection' => 25,
		                            				'strategies_played' => 50,
		                            				'order_by' => 'orderByTotal'
		                            		    ],
                            				
                                        ]   
                            ]
        ];
