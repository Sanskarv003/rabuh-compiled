<?php

/**
 * Build a configuration array to pass to `Hybridauth\Hybridauth`
 *
 * Set the Authorization callback URL to 
 * Understandably, you need to replace 'path/to/hybridauth' with the real path to this script.
 */
$config = [
    // here you put the final callback for the url and also need the same url every place like redirct url for google must be same
    'callback' => 'http://localhost/Mini%20Project/config/facebook/callback.php',//
    'providers' => [
        // 'Yahoo'     => ['enabled' => true, 'keys' => [ 'key'  => '...', 'secret' => '...']],
        'facebook'  => ['enabled' => true, 
            'keys' => [ 
                'id'   => '300995788513743', //
                'secret' => '5f9c9593e9ffec5d552503aae9172ec0',//
            ]
        ],
    ],
];
