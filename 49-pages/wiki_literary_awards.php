<?php
require_once('simple_html_dom.php');
require_once('token.php');

define("TITLE_FIRST", 		'0');
define("AUTHOR_FIRST", 		'1');

literary_award();

function literary_award(){
	
	// step 0 : delete feeds from db
	//1. connect to BDD		
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO(DB_49PAGES, DB_USER, DB_PWD);
	$bdd->exec("SET CHARACTER SET utf8");
	
	// 2. clean
	$bdd->exec('DELETE FROM literary_award');

	wiki_to_db("http://fr.wikipedia.org/wiki/Prix_Goncourt", "Liste des lauréats", "Prix Goncourt", $bdd, AUTHOR_FIRST);
	wiki_to_db("http://fr.wikipedia.org/wiki/Prix_Renaudot", "Les lauréats des prix", "Prix Renaudot", $bdd, TITLE_FIRST);
	wiki_to_db("http://fr.wikipedia.org/wiki/Prix_Femina", "Lauréats du prix Femina", "Prix Femina", $bdd, AUTHOR_FIRST);
	wiki_to_db("http://fr.wikipedia.org/wiki/Prix_Goncourt_des_lyc%C3%A9ens", "Lauréats du Prix Goncourt des lycéens", "Prix Goncourt des lycéens", $bdd, AUTHOR_FIRST);
	wiki_to_db("http://fr.wikipedia.org/wiki/Grand_Prix_des_lectrices_de_Elle", "Lauréats, catégorie roman (depuis 1970)", "Grand prix des lectrices de Elle - Roman", $bdd, AUTHOR_FIRST);
	wiki_to_db("http://fr.wikipedia.org/wiki/Grand_Prix_des_lectrices_de_Elle", "Lauréats, catégorie policier (depuis 2002)", "Grand prix des lectrices de Elle - Policier", $bdd, AUTHOR_FIRST);
	wiki_to_db("http://fr.wikipedia.org/wiki/Prix_des_maisons_de_la_presse", "Lauréats dans la catégorie roman", "Prix Maison de la Presse", $bdd, AUTHOR_FIRST);


	wiki_to_db("http://fr.wikipedia.org/wiki/Prix_des_libraires", "Lauréats", "Prix des libraires", $bdd, AUTHOR_FIRST);
	wiki_to_db("http://fr.wikipedia.org/wiki/Prix_du_roman_Fnac", "Palmarès", "Prix du roman Fnac", $bdd, AUTHOR_FIRST);
	wiki_to_db("http://fr.wikipedia.org/wiki/Prix_M%C3%A9dicis", "Liste des lauréats du prix Médicis", "Prix Médicis", $bdd, TITLE_FIRST);
		
	// and now we're done; close it
	$bdd = null;
}

function wiki_to_db($url, $label, $award, $bdd, $first){

	$url = $url;
	$html = connect_to($url);
	$html = str_get_html($html);
	
	// 2. get category
	$h2 = $html->find('h2');
	
	foreach($h2 as $h2_node){
		
		$title = $h2_node->find('span',1);
		if(isset($title)){
		
			$title = $title->plaintext;
			if(strcmp($title,$label)==0){
				// 3. find ul list of books
				$list = find_ul_tag($h2_node);
				if(isset($list))
					$award_books = parse_list_books($list, $first);
				else
					return;
			
				// 4. insert books in db
				foreach($award_books as $book){
				
					$id = $book[0];
					$title = $book[1];
					$author = $book[2];
					$date = $book[3];
					$award = $award;
  					$amazon_best_url = "";
   					$amazon_price = "";
  					$cheapest_price = "";
  					$ship_price = "";
  					$ISBN = "";
  					
  					// step 5 : insert in db		
					$request = 'INSERT INTO literary_award VALUES(\''.$id.'\', \''.$title.'\', \''.$author.'\', \''.$date.'\', \''.$award.
						'\', \''.$amazon_best_url.'\', \''.$amazon_price.'\', \''.$cheapest_price.'\', \''.$ship_price.'\', \''.$ISBN.'\')';
					$bdd->exec($request);	
			
					echo $id."\n";
				}
			
				break;
			}
		}
	}

		
	$html->clear(); 
	unset($html);
	
}


function find_ul_tag($node){
	

	$node = $node->next_sibling();
	$tag = $node->tag;
	
	while(strcmp($tag,'ul')){
		
		if(isset($node)){
			$node = $node->next_sibling();
			$tag = $node->tag;
		}
		else
			return null;
	}

	return $node;
}

function parse_list_books($list,$first){

	$books_award = array();

	$list = $list->find('li');
	
	foreach($list as $book){
	
		$date = trim( $book->find('a',0)->plaintext );
		
		if(strcmp($first,AUTHOR_FIRST)==0){
			$author = trim( $book->find('a',1)->plaintext );
			//$title = $book->find('a',2)->plaintext;
			$title = $book->find('i',0)->plaintext;
		}
		else{
			$author = trim( $book->find('a',2)->plaintext );
			$title = $book->find('a',1)->plaintext;
		}
		
		$title = addslashes($title);
		//$title = mb_convert_encoding($title, 'HTML-ENTITIES', 'UTF-8');	
		
		$id = get_id($title, $author);

			
		
		$current_book = array($id, $title, $author, $date);
		$books_award[] = $current_book;
	}
	
	return $books_award;
}


function get_id($title, $author){

	$title = preg_replace("/\([^\)]+\)/","",$title);
	$title = trim($title);
	$title = str_replace(" ","+",$title);
	
	$author = preg_replace("/\([^\)]+\)/","",$author);
	$author = trim($author);
	$author = str_replace(" ","+",$author);
	
	return $title .'+' . $author;
}


// THE PERFECT PHP CLEAN URL GENERATOR
// http://cubiq.org/the-perfect-php-clean-url-generator
function toAscii($str, $replace=array(), $delimiter='-') {
	if( !empty($replace) ) {
		$str = str_replace((array)$replace, ' ', $str);
	}

	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	$clean = strtolower(trim($clean, '-'));
	
	return $clean;
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