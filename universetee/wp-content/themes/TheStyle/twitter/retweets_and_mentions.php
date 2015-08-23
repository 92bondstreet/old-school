<?php
// Insert your keys/tokens
$consumerKey = '';
$consumerSecret = '';
$OAuthToken = '';
$OAuthSecret = '';


// Full path to twitterOAuth.php (change OAuth to your own path)
require_once('twitteroauth.php');


// create new instance
$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $OAuthToken, $OAuthSecret);

$retweets = $tweet->get('statuses/retweets_of_me');
$retweets_id = array();
foreach ($retweets as $user) {
	  $retweets_id[] = array('tweet_id' => $user->id_str, 'created_at' => $user->created_at, 'text' => $user->text);
}

echo 'Retweets ID of UniverseTee: '.count($retweets_id)."\n";

// for each retweet, get the last user who retweeded.
foreach ($retweets_id as $current_retweet) {

	$method = 'statuses/'.$current_retweet['tweet_id'].'/retweeted_by';
	$retweet = $tweet->get($method,array('count' => '1'));

	if(!isset($retweet))
		continue;

	$screen_name = $retweet[0]->screen_name;
	$name = $retweet[0]->name;
	echo '@'.$screen_name.' : '.$name.' - '.$current_retweet['text'].' - '.$current_retweet['created_at']."\n";
}

echo '------'."\n";
echo 'Mentions : '."\n";

$mentions = $tweet->get('statuses/mentions');

foreach ($mentions as $mention) {

		if(!isset($mention))
			continue;

	 	$screen_name = $mention->user->screen_name;
	 	$name = $mention->user->name;
	 	$created_at = $mention->created_at;
	 	$text = $mention->text;

	 	echo '@'.$screen_name.' : '.$name.' - '.$text.' - '.$created_at."\n";
}
