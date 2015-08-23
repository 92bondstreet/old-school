<?php
// Insert your keys/tokens
$consumerKey = '';
$consumerSecret = '';
$OAuthToken = '';
$OAuthSecret = '';

// Full path to twitterOAuth.php (change OAuth to your own path)
require_once('twitteroauth.php');


$screen_name = 'UniverseTee';

// create new instance
$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $OAuthToken, $OAuthSecret);

// get followers of user
$followers = $tweet->get('followers/ids', array('screen_name' => $screen_name));
// get friends of user
$friends = $tweet->get('friends/ids', array('screen_name' => $screen_name));

$followersIds = array();
foreach ($followers->ids as $i => $id) {
	  $followersIds[] = $id;
}

$friendsIds = array();
foreach ($friends->ids as $i => $id) {
	  $friendsIds[] = $id;
}

$followersIds = array_unique($followersIds);
echo 'Followers of '.$screen_name.' : '.count($followersIds)."\n";

$friendsIds = array_unique($friendsIds);
echo 'Friends of '.$screen_name.' : '.count($friendsIds)."\n";

$no_followers = array_diff($friendsIds, $followersIds);
$no_followers = array_reverse($no_followers);
echo 'No Followers of '.$screen_name.' : '.count($no_followers)."\n";


// add ids to database
try
{
	//1. connect to BDD
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=sql-2.e-clicking.in;dbname=universe_tweet92', 'universe_yaz92', '~O^2!DX!kPTh');

	$count = 0;

	// 2. clean
	$bdd->exec('DELETE FROM to_unfollow');

	foreach ($no_followers as $user_id) {

		// befor to insert, we check if id is already saved
		// get the first one...
		$select = 'SELECT *	FROM to_unfollow WHERE user_id='.$user_id.' LIMIT 1';

		$request = $bdd->query($select);
		if($request->rowCount()==1){
			$request->closeCursor(); // Termine le traitement de la requête
			continue;
		}

		$bdd->exec('INSERT INTO to_unfollow VALUES('.$user_id.')');

		$count++;

	}

               // and now we're done; close it
	       $bdd = null;
	echo "\n".'No Followers saved in DB of '.$screen_name.' : '.$count;
}
catch (Exception $e)
{
      die('Erreur : ' . $e->getMessage());
}
