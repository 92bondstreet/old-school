<?php

insert_feeds();

function insert_feeds(){

	// step 0 : delete feeds from db
	//1. connect to BDD		
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=sql-2.e-clicking.in;dbname=universe_feeds92', 'universe_yaz92', '~O^2!DX!kPTh');
    $bdd->exec("SET CHARACTER SET utf8");
	
	$count = 0;
	
	// 2. clean
	$bdd->exec('DELETE FROM list_of_feeds');
	
	// step 1 : insert feed in db
	insert_feeds_in_db('http://www.chartsinfrance.net/actualite/rss.xml','#chartsinfrance','@purecharts',$bdd);	
	insert_feeds_in_db('http://www.musiqueradio.com/rss.xml','#musiqueradio','@musiqueradio',$bdd);	
	insert_feeds_in_db('http://xml.mediasactu.com/rss/musicactu/flash/','#mediasactu','@MusicActu',$bdd);	
	insert_feeds_in_db('http://musique.premiere.fr/var/premiere/storage/rss/musique_actu.xml','#MCM','@PremiereMusique',$bdd);	
	insert_feeds_in_db('http://fr.news.yahoo.com/rss/musique','#yahoo','@YahooMusicFR',$bdd);	
	insert_feeds_in_db('http://musique.jeuxactu.com/musiquemag.rss','#musique-jeuxactu','@MusiqueMag',$bdd);	
	insert_feeds_in_db('http://www.zike.eu/rss.php','#zike',null,$bdd);	
	insert_feeds_in_db('http://www.wizzmusic.com/blog/feed/','#wizzmusic','@wizzmusic',$bdd);	
	insert_feeds_in_db('http://www.blog-zik.com/feed','#blog-zik','@stephanenicolas',$bdd);	
	insert_feeds_in_db('http://feeds.feedburner.com/butwehavemusic','#butwehavemusic','@butwehavemusic',$bdd);	
	insert_feeds_in_db('http://teemix.aufeminin.com/world/edito/news/rss.xml.asp?rub=musique&pid=5890823813596685116','#teemix','@TeemixCom',$bdd);	
	insert_feeds_in_db('http://feeds.feedburner.com/urban-fusions','#urban-fusions','@urban_fusions',$bdd);	
	insert_feeds_in_db('http://www.billboard.com/rss/the-feed','#billboard','@billboard',$bdd);	
        insert_feeds_in_db('http://www.actumusic.com/rss-site','#actumusic','@Actumusic',$bdd);	
	insert_feeds_in_db('http://www.music-story.com/fil-rss-musique/actualites.xml','#musicstory','@music_story',$bdd);	
	insert_feeds_in_db('http://www.goomradio.fr/news?format=RSS','#goomradio','@goomradiofr',$bdd);
	insert_feeds_in_db('http://feeds.feedburner.com/culturebox','#cultureboxFTV','@cultureboxFTV',$bdd);
	
        // Artists
	// Jay z
	insert_feeds_in_db('http://rocnation.com/feed/','#rocnation','@rocnation',$bdd);		
	// Rihanna
	insert_feeds_in_db('http://www.rihanna-diva.com/feed/','#rihanna-diva.com','@RihannaDiva',$bdd);	
	insert_feeds_in_db('http://rihannadaily.com/feed/','#rihannadaily','@RihannaDaily',$bdd);	
	// carlyrae
	insert_feeds_in_db('http://carlyraemusic.com/feed/','#carlyraemusic','@carlyraejepsen',$bdd);	
        // Taylor Swift
	insert_feeds_in_db('http://taylorswift.com/api/rss/news','#taylorswift','@taylorswift13',$bdd);	
	insert_feeds_in_db('http://swift-france.net/?feed=rss','#SwiftFrance',null,$bdd);	
        // Ellie Goulding
       	insert_feeds_in_db('http://ellie-g.com/feed','#ellie','EllieGCom',$bdd);	

	
	//ebuzzing
	insert_feeds_in_db('http://www.blogotheque.net/feed/','#blogotheque','@blogotheque',$bdd);	
	insert_feeds_in_db('http://www.13or-du-hiphop.fr/le-blog/feed/','#13or','@13or_du_hiphop',$bdd);	

        //technorati
	insert_feeds_in_db('http://www.rap-up.com/feed/','#RapUp','@RapUp',$bdd);	
	insert_feeds_in_db('http://www.missinfo.tv/index.php/feed/','#missinfo','@Missinfo',$bdd);	
	insert_feeds_in_db('http://idolator.com/feed','#idolator','@idolator',$bdd);	
	insert_feeds_in_db('http://feeds.feedburner.com/TheBootCountryMusic','#TheBootCountryMusic','@thebootdotcom',$bdd);	
	insert_feeds_in_db('http://buzzworthy.mtv.com/feed/','#buzzworthy','@MTV',$bdd);	
	
  // and now we're done; close it
   $bdd = null;
}

function insert_feeds_in_db($feed_url,$blog,$twitter,$bdd){
	
try {
	// step 1 : get the flux
	$content = file_get_contents($feed_url);
	$x = new SimpleXmlElement($content);

	
    if(!isset($x->channel->item))
		return;

	foreach($x->channel->item as $entry) {
		$title = mb_convert_encoding($entry->title, 'HTML-ENTITIES', 'UTF-8');		
		$title = addslashes($title);
		$link = $entry->link;
		
		
		// create tweet
		$tweet = create_tweet($title, $link, $twitter);
		
		// step 2 : insert in db		
		$request = 'INSERT INTO list_of_feeds VALUES(\''.$tweet.'\', \''.$blog.'\')';
		$bdd->exec($request);		
	  
		// just the first one
		break;
	}
	
	echo "\n".'Feeds saved in DB of '.$blog."\n";
} catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}
}

function create_tweet($title, $link, $twitter){
	
	//#UniverseTee - Titre_raccourci_si_besoin : url_article Par @nom_du_compte
	
	// short url
	$short = make_bitly_url($link);
	
	if(isset($twitter))
		$message_without_title = '... : '.$short.' Par '.$twitter;
	else
		$message_without_title = '... : '.$short;

	// 140
	$short_title = split_to_chunks($message_without_title,$title);
	if(count($short_title)==1)
		$short_title =  $short_title[0];
	else
		$short_title =  $short_title[0].'...';
	
	if(isset($twitter))
		$tweet = $short_title.' : '.$short.' Par '.$twitter;
	else
		$tweet = $short_title.' : '.$short;
		
	return $tweet;
}


/* make a URL small */
function make_bitly_url($url)
{
	//create the URL	
	return file_get_contents("http://tinyurl.com/api-create.php?url=" . $url);  
}

/* split_to_chunks by John Hamelink 2010. This code is in the PUBLIC DOMAIN. */

function split_to_chunks($to,$text){
	$total_length = (140 - strlen($to));
	$text_arr = explode(" ",$text);
	$i=0;
	$message[0]="";
	foreach ($text_arr as $word){
		if ( strlen($message[$i] . $word . ' ') <= $total_length ){
			if ($text_arr[count($text_arr)-1] == $word){
				$message[$i] .= $word;
			} else {
				$message[$i] .= $word . ' ';
			}
		} else {
			$i++;
			if ($text_arr[count($text_arr)-1] == $word){
				$message[$i] = $word;
			} else {
				$message[$i] = $word . ' ';
			}
		}
	}
	return $message;
}
?>