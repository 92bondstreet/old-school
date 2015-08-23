<?php
// Insert your keys/tokens
$consumerKey = '';
$consumerSecret = '';
$OAuthToken = '';
$OAuthSecret = '';

// Full path to twitterOAuth.php (change OAuth to your own path)
require_once('twitteroauth.php');
require_once('send_tweet.php');

function thanks_for_RT($message,$where){

	global $consumerKey, $consumerSecret, $OAuthToken, $OAuthSecret;

	// create new instance
	$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $OAuthToken, $OAuthSecret);
	$thanks_tweet = $message;

	// get
	$retweets = $tweet->get('statuses/retweets_of_me');
	$retweets_id = array();
	foreach ($retweets as $user)
		  $retweets_id[] = array('tweet_id' => $user->id_str, 'created_at' => $user->created_at, 'text' => $user->text);

	$screen_names = array();

	// for each retweet, get the last user who retweeded.
	foreach ($retweets_id as $current_retweet) {

		$method = 'statuses/'.$current_retweet['tweet_id'].'/retweeted_by';
		$retweet = $tweet->get($method,array('count' => '1'));

		if(!isset($retweet))
			continue;

		$screen_name = $retweet[0]->screen_name;
		$screen_names[] = $screen_name;
	}

	// delete doublon
	$screen_names = array_unique($screen_names);
	if(sizeof($screen_names)==0)
		return;
	foreach ($screen_names as $screen_name) {
		$more_140 = create_tweet($thanks_tweet,$screen_name,$where);
			if($more_140==false)
				break;
	}

	echo $thanks_tweet."\n";
	send_tweet($thanks_tweet);

}

function create_tweet(&$tweet, $screen_name,$where){

	if(isset($screen_name)){

		if($where==0)
			$current_tweet = $tweet.' @'.$screen_name;
		else
			$current_tweet = '@'.$screen_name.' '.$tweet;
		if(strlen($current_tweet)<140){
			$tweet = $current_tweet;
			return true;
		}
		else
			return false;
	}

	return true;
}
