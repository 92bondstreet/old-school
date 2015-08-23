<?php
require_once('send_tweet.php');
require_once('get_feeds.php');


try
{
	//1. connect to BDD		
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=sql-2.e-clicking.in;dbname=universe_feeds92', 'universe_yaz92', '~O^2!DX!kPTh');
        header("Content-Type: text/html; charset=UTF-8");
	
	//2. select random
        // Find the number of rows in the table using SELECT COUNT(*) FROM your_table
	$rows_number = $bdd->query('SELECT count(*) from list_of_feeds')->fetchColumn(); 
 	$rows_number = intval($rows_number) - 1;

        // DB empty : get feeds !
        if($rows_number<=0){
		insert_feeds();
		// calcul row number again 
		// Find the number of rows in the table using SELECT COUNT(*) FROM your_table
		$rows_number = $bdd->query('SELECT count(*) from list_of_feeds')->fetchColumn(); 
		$rows_number = intval($rows_number) - 1;
 	} 

 	//Use PHP's math functions to find a random number between 0 and the number of rows
 	$rand_number =  rand ( 0 , $rows_number );
        echo 'random number : '.$rand_number."\n";
 	
 	//Get the actual data you want using SELECT * FROM your_table LIMIT 200, 1, where 200 is the random number you calculated in step 2.
 	$select = 'SELECT * FROM list_of_feeds LIMIT '.$rand_number.', 1';

	$request = $bdd->query($select);
		
	if($request->rowCount()==1){
		$response = $request->fetch();
		$tweet = $response['tweet'];
	
		$tweet_to_send = mb_convert_encoding ( $tweet, 'UTF-8', 'HTML-ENTITIES' );
                send_tweet($tweet_to_send);
                echo $tweet_to_send; 
					
		// ... delete
		$tweet = addslashes($tweet);
		$delete = 'DELETE FROM list_of_feeds WHERE tweet=\''.$tweet.'\'';
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
	
?>