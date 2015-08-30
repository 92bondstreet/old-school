<?php
include('simple_html_dom.php');
include ('Snoopy.class.php');
require_once('token.php');

set_time_limit(0);

update_books_price();

function update_books_price(){

	// parse pmba books
	//1. connect to BDD		
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO(DB_49PAGES, DB_USER, DB_PWD);
	
	//Get the actual data you want using SELECT * FROM your_table LIMIT 200, 1, where 200 is the random number you calculated in step 2.
	$select = 'SELECT * FROM literary_award';
	$request = $bdd->query($select);
	$nb_books = $request->rowCount();
	
	for($i=0;$i<$nb_books;$i++){
		$response = $request->fetch();
		$id = addslashes($response['id']);
		$title = $response['title'];		
		
		$book = price_book($id);
		
		$amazon_price = $book[0];
		$cheapest_price = $book[1];
		$ship_price = $book[2];
		$ISBN = $book[3];
		$amazon_best_url = $book[4];
		
		// ... update prices in DB
		$update = 	'UPDATE literary_award SET amazon_price=\''.$amazon_price.
					'\', cheapest_price=\''.$cheapest_price.
					'\', ship_price=\''.$ship_price.
					'\', amazon_best_url=\''.$amazon_best_url.
					'\', ISBN=\''.$ISBN.'\' WHERE id=\''.$id.'\'';
		
		$update_request = $bdd->query($update);	
		$update_request->closeCursor(); // Termine le traitement de la requÍte
		
		echo "done for ".$title."\n";
	}
	
	echo "END";
	
	// and now we're done; close it
	$bdd = null;

}


function price_book($book){
	
	$amazon_url = "http://www.amazon.fr/gp/search/ref=sr_adv_b/?search-alias=stripbooks&__mk_fr_FR=%C5M%C5Z%D5%D1&unfiltered=1&field-author=&field-title=&field-isbn=&field-publisher=&field-collection=&node=&field-binding_browse-bin=492481011&field-dateop=&field-datemod=&field-dateyear=&sort=relevancerank&Adv-Srch-Books-Submit.x=0&Adv-Srch-Books-Submit.y=0";	
	$amazon_url .= "&field-keywords=".$book;

	$snoopy = new Snoopy;
	$snoopy->fetch($amazon_url);
	$html = $snoopy->results;	
	$html = str_get_html($html);	

	$prices = null;

	$results = $html->find('#atfResults',0);
	if(isset($results)){
	
		// book url
		$book_url = $results->find('.productTitle',0);
		$book_url = $book_url->find('a',0)->href;
	
		$ISBN = get_ISBN($book_url);
		$prices = get_best_price($ISBN);
	}
	else{
		$prices[0] = 0;
		$prices[1] = 0;
		$ISBN = -1;
		$book_url = 'http://www.amazon.fr';
		
	}
		
	$html->clear(); 
	unset($html);
	
	return array($prices[0],$prices[1],'2.99',$ISBN,$book_url);	
}

function get_best_price($ISBN){

	$amazon_url = "http://www.amazon.fr/gp/offer-listing/".$ISBN."/sr=/qid=/ref=olp_tab_all?ie=UTF8&shipPromoFilter=0&coliid=&sort=sip&me=&qid=&sr=&seller=&colid=&condition=all";

	$html = connect_to($amazon_url);	
	$html = str_get_html($html);	
	
	// 0. First price is the cheapest one.
	$result = $html->find('.result',0);
	$cheapest_price = $result->find('.price',0)->plaintext;
	
	//1. Get the premium premium price
	$amazon_price = 0;
	$supersaver = $html->find('.supersaver',0);
	if(isset($supersaver)){
		$supersaver = $supersaver->parent();
		$amazon_price = $supersaver->find('.price',0)->plaintext;
	}
	else
		$amazon_price = get_amazon_price($ISBN);
		
	$html->clear(); 
	unset($html);
	
	return array($amazon_price, $cheapest_price);
	
}

function get_amazon_price($ISBN){

	$amazon_url = "http://www.amazon.fr/dp/".$ISBN;
	
	$html = connect_to($amazon_url);	
	$html = str_get_html($html);	
	
	// 0. get the price
	$amazon_price = $html->find('.priceLarge',0);
	if(isset($amazon_price)){
		$amazon_price = $amazon_price->plaintext;
		$amazon_price = trim(str_replace('EUR ','',$amazon_price));
	}
	else
		$amazon_price = 0;
		
	$html->clear(); 
	unset($html);
	
	return $amazon_price;
}

function get_ISBN($url){
	preg_match("/[^\/]+$/", $url, $matches);
	$ISBN = $matches[0]; 
	
	return $ISBN;
}

function connect_to($url){
			
	$ch = curl_init();

	//Set options for curl session
	$options = array(CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6',
			 CURLOPT_HEADER => TRUE,
			 CURLOPT_RETURNTRANSFER => TRUE,
			 CURLOPT_COOKIEFILE => 'cookie.txt',
			 CURLOPT_COOKIEJAR => 'cookies.txt',
			 CURLOPT_SSL_VERIFYPEER => FALSE);

	$options[CURLOPT_URL] = $url;
	curl_setopt_array($ch, $options);
	$login_pre_content = curl_exec($ch);

		// VÈrifie si une erreur survient
	if(curl_errno($ch))  
	{ 
	   echo 'Erreur Curl : ' . curl_error($ch);  
	} 
			
	$options[CURLOPT_FOLLOWLOCATION] = TRUE;
	curl_setopt_array($ch, $options);
	$login_post_content = curl_exec($ch);

	//Close curl session
	curl_close($ch);
	
	return 	$login_post_content;
}

?>