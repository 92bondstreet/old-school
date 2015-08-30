<?
include('simple_html_dom.php');
require_once('token.php');

reading_list();

function reading_list(){

	// step 0 : delete feeds from db
	//1. connect to BDD		
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO(DB_PMBA, DB_USER, DB_PWD);
	$bdd->exec("SET CHARACTER SET utf8");

	$count = 0;
	
	// 2. clean
	$bdd->exec('DELETE FROM reading_list');
	
	
	$url = "http://personalmba.com/best-business-books/";
	$pmba_url = "http://personalmba.com";
	
	$html = connect_to($url,$book);
	$html = str_get_html($html);
	
	// 2. get category
	$h2 = $html->find('h2[id]');
	
	foreach($h2 as $category){
		
		$en_category = $category->innertext;		
		$list_books = $category->next_sibling()->find('li');
		foreach($list_books as $book){
		
			//3. info
			$title = $book->find('a',0)->plaintext;
			$amazon_com_url = $pmba_url.$book->find('a',0)->href;
			$author = $book->plaintext;
			$id =  get_id($author);
			$author = get_author($author);			
			$en_review = $pmba_url.$book->find('a',1)->href;

			$fr_category = "";
			$fr_review = "";						
			$amazon_best_url = "";
			$amazon_price = "";
			$cheapest_price = "";
			$ship_price = "";
			$ISBN = "";

			// step 4 : insert in db		
			$request = 'INSERT INTO reading_list VALUES(\''.$id.'\', \''.$title.'\', \''.$author.'\', \''.$en_category.'\', \''.$fr_category.
						'\', \''.$en_review.'\', \''.$fr_review.'\', \''.$amazon_com_url.'\', \''.$amazon_best_url.'\', \''.$amazon_price.'\', \''.$cheapest_price.'\', \''.$ship_price.'\', \''.$ISBN.'\')';
			$bdd->exec($request);	
			
			echo $id."\n";
		}
	}
		
	
	$html->clear(); 
	unset($html);
	
		
	// and now we're done; close it
	$bdd = null;
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

		// Vérifie si une erreur survient
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

function get_id($text){

	$text = preg_replace("/\([^\)]+\)/","",$text);
	$text = str_replace(" by "," ",$text);
	$text = str_replace(" and "," ",$text);
	$text = str_replace(" & "," ",$text);
	$text = str_replace(" &amp; "," ",$text);
	$text = str_replace(" et al "," ",$text);
	$text = trim($text);
	$text = str_replace(" ","+",$text);
	
	return $text;
}

function get_author($text){
	$text = extract_unit($text,"by "," (");
	$text = str_replace(" and "," ",$text);
	$text = str_replace(" & "," ",$text);
	$text = str_replace(" &amp; "," ",$text);
	$text = str_replace(" et al "," ",$text);
	$text = trim($text);
	
	return $text;
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
?>