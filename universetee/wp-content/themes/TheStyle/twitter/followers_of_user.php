<?php
// Insert your keys/tokens
$consumerKey = '';
$consumerSecret = '';
$OAuthToken = '';
$OAuthSecret = '';

// Full path to twitterOAuth.php (change OAuth to your own path)
require_once('twitteroauth.php');


if (isset($_GET['screen_name'])) {
	$screen_name = $_GET['screen_name'];

	// create new instance
	$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $OAuthToken, $OAuthSecret);

	// get followers of user
	$followers = $tweet->get('followers/ids', array('screen_name' => $screen_name));

	// get the cursor
	$next_cursor = $followers->next_cursor;
	//if next_cursor == 0 stop else continue
	$followerIds = array();
	foreach ($followers->ids as $i => $id) {
  	  $followerIds[] = $id;
	}

	while($next_cursor>0){

		$followers = $tweet->get('followers/ids', array('screen_name' => $screen_name, 'cursor' => $next_cursor));

		// get the cursor
		$next_cursor = $followers->next_cursor;
		//if next_cursor == 0 stop else continue
		foreach ($followers->ids as $i => $id) {
  		$followerIds[] = $id;
		}
	}

	$followerIds = array_unique($followerIds);
	echo 'Followers of '.$screen_name.' : '.count($followerIds);


	// add ids to database

	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=sql-2.e-clicking.in;dbname=universe_tweet92', 'universe_yaz92', '~O^2!DX!kPTh');

		$count = 0;

			//1. connect to BDD
		foreach ($followerIds as $user_id) {

			// befor to insert, we check if id is already saved
			// get the first one...
			$select = 'SELECT *	FROM followers_of_user WHERE user_id='.$user_id.' LIMIT 1';

			$request = $bdd->query($select);
			if($request->rowCount()==1){
				$request->closeCursor(); // Termine le traitement de la requ�te
				continue;
			}

			$bdd->exec('INSERT INTO followers_of_user VALUES('.$user_id.', \''.$screen_name.'\')');

			$count++;

		}

                // and now we're done; close it
	        $bdd = null;

		echo "\n".'Followers saved in DB of '.$screen_name.' : '.$count;
	}
	catch (Exception $e)
	{
        die('Erreur : ' . $e->getMessage());
	}


}
else
	echo 'no screen_name defined';




// autofollow $ret = $toa->post('friendships/create', array('user_id' => $id));
