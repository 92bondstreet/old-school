<?php
require ('../../../../wp-blog-header.php');
require_once('send_tweet.php');

// get random ts post
$args = array( 'numberposts' => 12, 'orderby' => 'post_date' );
$rand_posts = get_posts( $args );

$rand_id = rand(0,11);

$post = $rand_posts[$rand_id];
if(isset($post)){
	
		$title = __($post->post_title);
		$punchline = __($post->post_content);
		$category = get_the_category($post->ID); 
		
		$image = get_image_url($post->ID); 
                		
		$author = "";
		foreach($category as $cat)
			$author .= " ".$cat->cat_name;
		
		$url = make_bitly_url('http://www.universetee.com/fr/'.$post->post_name);
		
		// 140				
		$tweet = 'Tshirt'.$author.' - '.$title.' : '.$url;
		
		//send_tweet_image($tweet,$image);                
                send_tweet($tweet);                
		echo $tweet;
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

function get_image_url($ID){

	//get ($fieldName, $groupIndex=1, $fieldIndex=1, $readyForEIP=true,$post_id=NULL)
	$server = 'http://image.spreadshirt.net';
	$product_id_man_us =  get('product_man_eu',1,1,true,$ID);
	$url = $server.'/image-server/image/product/'.$product_id_man_us.'/view/1/type/png/width/800/height/800';
	
	return $url;
}
	
?>