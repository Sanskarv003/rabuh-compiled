<?php

require_once 'vendor/autoload.php';

$google_client = new Google_Client();

$google_client->setClientId('857578478554-4ijaik0rd6on4s5cufvqanp6uthhhn4n.apps.googleusercontent.com');

$google_client->setClientSecret('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');

$google_client->setRedirectUri('http://localhost/Compiled/config/google/callbackLogin.php');

$google_client->addScope('email');

$google_client->addScope('profile');

$google_client->addScope('openid');

?>