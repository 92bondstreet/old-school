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

		// get a random one...
		// Find the number of rows in the table using SELECT COUNT(*) FROM your_table
		$rows_number = $bdd->query('SELECT count(*) from followers_of_user')->fetchColumn();
 		$rows_number = intval($rows_number) - 1;
 		//Use PHP's math functions to find a random number between 0 and the number of rows
 		$rand_number =  rand ( 0 , $rows_number );
                echo 'random : '.$rand_number."\n";

 		//Get the actual data you want using SELECT * FROM your_table LIMIT 200, 1, where 200 is the random number you calculated in step 2.
 		$select = 'SELECT * FROM followers_of_user LIMIT '.$rand_number.', 1';
		//$select = 'SELECT *	FROM followers_of_user LIMIT 1';
		$request = $bdd->query($select);

		// ... follow
  	       if($request->rowCount()==1){
		$response = $request->fetch();
		$user_id = $response['user_id'];
		$from_user = $response['from_user'];

		$tweet->post('friendships/create', array('user_id' => $user_id));
		echo $user_id.' from '.$from_user;

		// ... delete
		$delete = 'DELETE FROM followers_of_user WHERE user_id='.$user_id;
		$request = $bdd->query($delete);

		$request->closeCursor(); // Termine le traitement de la requ�te
               }

               // and now we're done; close it
	       $bdd = null;
	}
	catch (Exception $e)
	{
        die('Erreur : ' . $e->getMessage());
	}
