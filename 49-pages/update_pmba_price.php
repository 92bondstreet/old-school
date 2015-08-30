<?php
include('simple_html_dom.php');
include ('Snoopy.class.php');
require_once('token.php');

set_time_limit(0);

$SELLERS_URL = array(	"seller=AV4I8X7UC7UR&isAmazonFulfilled=0&isCBA=&marketplaceID=A13V1IB3VIYZZH&asin=0670921602&useMYI=1",
						"seller=A2G0FRHY8GPWZ9&isAmazonFulfilled=0&isCBA=&marketplaceID=A13V1IB3VIYZZH&asin=0060731141&useMYI=1",
						"seller=A3S2N2ECAZFVK1&isAmazonFulfilled=0&isCBA=&marketplaceID=A13V1IB3VIYZZH&asin=0060731141&useMYI=1",
						"seller=A1H5ZLOPC91N9X&isAmazonFulfilled=0&isCBA=&marketplaceID=A13V1IB3VIYZZH&asin=0060731141&useMYI=1",
						"seller=AAD2QYB78YYT9&isAmazonFulfilled=0&isCBA=&marketplaceID=A13V1IB3VIYZZH&asin=0470182024&useMYI=1",
						"seller=A2VSCSN8IXFNBL&isAmazonFulfilled=0&isCBA=&marketplaceID=A13V1IB3VIYZZH&asin=0091929784&useMYI=1",
						"seller=AO8YGG4Q6OIZO&isAmazonFulfilled=0&isCBA=&marketplaceID=A13V1IB3VIYZZH&asin=0470405309&useMYI=0",
						"seller=A2DU01JIBJWAOO&isAmazonFulfilled=0&isCBA=&marketplaceID=A13V1IB3VIYZZH&asin=1605095257&useMYI=1");

//update_price_from_UE();

print_best_books();

function update_price_from_UE(){

	// parse pmba books
	//1. connect to BDD		
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO(DB_PMBA, DB_USER, DB_PWD);
	
	//Get the actual data you want using SELECT * FROM your_table LIMIT 200, 1, where 200 is the random number you calculated in step 2.
	$select = 'SELECT * FROM reading_list';
	$request = $bdd->query($select);
	$nb_books = $request->rowCount();
	
	//for($i=0;$i<$nb_books;$i++){
	for($i=0;$i<$nb_books;$i++){
		$response = $request->fetch();
		$id = $response['id'];
		$title = $response['title'];		
		$book = price_book($id);
		
		$amazon_price = $book[0];
		$cheapest_price = $book[1];
		$ship_price = $book[2];
		$ISBN = $book[3];
		$amazon_best_url = $book[4];
		
		// ... tweeted
		$update = 	'UPDATE reading_list SET amazon_price=\''.$amazon_price.
					'\', cheapest_price=\''.$cheapest_price.
					'\', ship_price=\''.$ship_price.
					'\', amazon_best_url=\''.$amazon_best_url.
					'\', ISBN=\''.$ISBN.'\' WHERE id=\''.$id.'\'';
		
		$update_request = $bdd->query($update);	
		$update_request->closeCursor(); // Termine le traitement de la requête
		
		echo "done for ".$title."\n";
	}
	
	// and now we're done; close it
	$bdd = null;

}

function price_book($book){

	global $SELLERS_URL;
	
	$best_book_price = 1000;
	$best_book_ship = 2.99;
	$best_book_ISBN = "";
	$best_book_url = NULL;
	$best_book_price_amazon = 0;
	
	// replace entites quote
	$book = str_replace("&#8217;","'",$book);
	$book = urlencode($book);
	
	// 0. parse all books from pmba reading list
	foreach($SELLERS_URL as $seller_url){
		
		// 1. Parse all sellers and save best price + url
		$seller_price = price_book_sellers($seller_url,$book);
		if(isset($seller_price)){
		
			$price = $seller_price[0];
			$url = $seller_price[1];				
			// test best price
			if($price < $best_book_price){
				$best_book_price = $price;
				$best_book_url = $url;
			}
		}	
	}
	
	// 2. from best book price url, get price, ship price, ISBN
	if(!isset($best_book_url))
		return;
		
	$ISBN = get_ISBN($best_book_url);
	$best_book_price_amazon = get_amazon_price($book);
	
	return array($best_book_price_amazon,$best_book_price,$best_book_ship,$best_book_ISBN,$best_book_url);
}



function price_book_sellers($seller_url, $book){

	$best_price = 1000;
	$best_url = "";

	$html = connect_to_seller($seller_url,$book);
	
	$html = str_get_html($html);
	// no results
	$results = $html->find('.AAGProductMoRes',0);
	if(isset($results)){
		$html->clear(); 
		unset($html);
		return NULL;
	}
	
	// parse
	$list_books = $html->find('.AAG_itemDetails');
	// return price + url
	foreach($list_books as $book){
		$price = clean_price($book->find('.AAG_ProductPrice',0)->innertext);
		$url = $book->find('.AAG_ProductTitle',0)->find('a',0)->href;		
		if($price < $best_price){
			$best_price = $price;
			$best_url = $url;
		}
	}
	
	$html->clear(); 
	unset($html);
	
	return array($best_price,$best_url);
}

function connect_to_seller($sller_url,$book){
			
	$ch = curl_init();

	//Set options for curl session
	$options = array(CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6',
			 CURLOPT_HEADER => TRUE,
			 CURLOPT_RETURNTRANSFER => TRUE,
			 CURLOPT_COOKIEFILE => 'cookie.txt',
			 CURLOPT_COOKIEJAR => 'cookies.txt',
			 CURLOPT_SSL_VERIFYPEER => FALSE);

	$options[CURLOPT_URL] = "http://www.amazon.fr/gp/aag/ajax/productWidget.html";
	curl_setopt_array($ch, $options);
	$login_pre_content = curl_exec($ch);

		// Vérifie si une erreur survient
	if(curl_errno($ch))  
	{ 
	   echo 'Erreur Curl : ' . curl_error($ch);  
	} 
			
	$post = $sller_url."&searchString=".$book;
	$postfields = $post;


	//Login
	$options[CURLOPT_POST] = TRUE;
	$options[CURLOPT_POSTFIELDS] = $postfields;

	$options[CURLOPT_FOLLOWLOCATION] = TRUE;
	curl_setopt_array($ch, $options);
	$login_post_content = curl_exec($ch);

	//Close curl session
	curl_close($ch);
	
	return 	$login_post_content;
}

function clean_price($price){
	$price = str_replace("EUR ","",$price);
	$price = str_replace(",",".",$price);
	
	return trim($price);
}

function get_ISBN($url){
	return extract_unit($url,"dp/","/ref=");
}

/*
Credits: Bit Repository
URL: http://www.bitrepository.com/web-programming/php/extracting-content-between-two-delimiters.html
*/

function extract_unit($string, $start, $end)
{
	$pos = stripos($string, $start);
	$str = substr($string, $pos);
	$str_two = substr($str, strlen($start));
	$second_pos = stripos($str_two, $end);
	$str_three = substr($str_two, 0, $second_pos);

	$unit = trim($str_three); // remove whitespaces

	return $unit;
}

function get_amazon_price($book){
	
	$amazon_url = "http://www.amazon.fr/s/ref=sr_nr_p_76_0?rh=i%3Aaps%2Ck%3A1591843030%2Cp_76%3A1&ie=UTF8&qid=1343918498";	
	$amazon_url .= "&keywords=".$book;

	$snoopy = new Snoopy;
	$snoopy->fetch($amazon_url);
	$html = $snoopy->results;	
	$html = str_get_html($html);	

	$new_price = 0;
	$results = $html->find('#atfResults',0);
	if(isset($results)){
		$new_price = $results->find('.newPrice',0)->find('span',0)->innertext;
		$new_price = clean_price($new_price);
	}
		
	$html->clear(); 
	unset($html);
	
	return $new_price;	
}

function print_best_books(){
	
	// parse pmba books
	//1. connect to BDD		
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO(DB_PMBA, DB_USER, DB_PWD);
	
	//Get the actual data you want using SELECT * FROM your_table LIMIT 200, 1, where 200 is the random number you calculated in step 2.
	$select = 'SELECT * FROM reading_list';
	$request = $bdd->query($select);
	$nb_books = $request->rowCount();
	
	print "<html>";
	print "<body>";
	
	for($i=0;$i<$nb_books;$i++){
		$response = $request->fetch();
		
		$title = $response['title'];		
		$author = $response['author'];		
		$amazon_best_url = $response['amazon_best_url'];		
		$cheapest_price = $response['cheapest_price'];		
		$amazon_price = $response['amazon_price'];
		
		// html print
		$h2_tag = "<h2>";
		if($amazon_price < $cheapest_price)
			$h2_tag = "<h2 style=\"color:red\">";
					
		print $h2_tag.$title." | ".$author."</h2>";
		print "<ul>";
		print "<li><a href=\"".$amazon_best_url."\">".$amazon_best_url."</a></li>";
		print "<li><b>".$cheapest_price."</b></li>";
		print "<li>".$amazon_price."</li>";
		print "</ul>";
		print "<br/>";
		
	}
	
	// and now we're done; close it
	$bdd = null;
	
	print "</body>";
	print "</html>";
}

?>