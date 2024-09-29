<?php
/**
 * Build a configuration array to pass to `Hybridauth\Hybridauth`
 *
 * Set the Authorization callback URL to 
 * Understandably, you need to replace 'path/to/hybridauth' with the real path to this script.
 */
$fconfig = [
    // here you put the final callback for the url and also need the same url every place like redirct url for google must be same
    'callback' => 'http://localhost/hybridauth/hybridauth-3.2.0/examples/example_07/fcallback.php',
    'providers' => [

        // 'Yahoo'     => ['enabled' => true, 'keys' => [ 'key'  => '...', 'secret' => '...']],
        'facebook'  => ['enabled' => true, 
            'keys' => [ 
                'id'   => '300995788513743',
                'secret' => '5f9c9593e9ffec5d552503aae9172ec0',
            ]
        ]
        //'Twitter'   => ['enabled' => true, 'keys' => [ 'key'  => '...', 'secret' => '...']],

        // 'Instagram' => ['enabled' => true, 'keys' => [ 'id'   => '...', 'secret' => '...']],

    ],
];
