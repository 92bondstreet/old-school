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


	// add ids to database

	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=sql-2.e-clicking.in;dbname=universe_tweet92', 'universe_yaz92', '~O^2!DX!kPTh');

		// get the first one...
		$select = 'SELECT *	FROM to_unfollow LIMIT 1';
		$request = $bdd->query($select);

		// ... unfollow
		if($request->rowCount()==1){
			$response = $request->fetch();
			$user_id = $response['user_id'];

			$response = $tweet->post('friendships/destroy', array('user_id' => $user_id));
			echo 'Unfollow : '.$user_id.' --> UniverseTee';
			if (!is_string($response)) {
    		$response = print_r($response, TRUE);
  		}

			// ... delete
			$delete = 'DELETE FROM to_unfollow WHERE user_id='.$user_id;
			$request = $bdd->query($delete);

			$request->closeCursor(); // Termine le traitement de la requête
		}

               // and now we're done; close it
	       $bdd = null;
	}
	catch (Exception $e)
	{
        die('Erreur : ' . $e->getMessage());
	}
