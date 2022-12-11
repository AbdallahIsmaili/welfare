<?php
require_once 'vendor/autoload.php';

// init configuration
$clientID = '1090843612689-19cv5jqr5rnuqiqjt2rn53rnb2ch08h3.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost:85/welfare/home.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

