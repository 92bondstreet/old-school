<?php
// Full path to twitterOAuth.php (change OAuth to your own path)
require_once('twitteroauth.php');

function send_tweet($message){

   // Insert your keys/tokens
   $consumerKey = 'FRqfYko2uRteru1obCQ'; 
   $consumerSecret = 'Sjt98BSRPIUg8tOPwS1iLNPMOxIiAsxFD2jcCNTY';
   $OAuthToken = '495718220-pSpX3TdZXg0lU3N9te3OX7egvszRLc3LdSpx3rfU';
   $OAuthSecret = 'N5OjADaC2iYVGXxIOWidUEYgnzEbFEl9HVQU3fVFOzI';

   // create new instance
   $tweet = new TwitterOAuth($consumerKey, $consumerSecret, $OAuthToken, $OAuthSecret);

   // Send tweet
   $tweet->post('statuses/update', array('status' => "$message"));
   echo $tweet->http_code."\n";
}

function send_tweet_image($message, $image){

   // Insert your keys/tokens
   $consumerKey = 'FRqfYko2uRteru1obCQ'; 
   $consumerSecret = 'Sjt98BSRPIUg8tOPwS1iLNPMOxIiAsxFD2jcCNTY';
   $OAuthToken = '495718220-pSpX3TdZXg0lU3N9te3OX7egvszRLc3LdSpx3rfU';
   $OAuthSecret = 'N5OjADaC2iYVGXxIOWidUEYgnzEbFEl9HVQU3fVFOzI';

    // create new instance
   $tweet = new TwitterOAuth($consumerKey, $consumerSecret, $OAuthToken, $OAuthSecret);
   $tweet->updateMedia($message, $image);
   
   // Send tweet
   echo $tweet->http_code."\n";
}