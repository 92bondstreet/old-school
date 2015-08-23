<?php
/**
 * Universtee functions and definitions
 *
 */


function create_navigation_footer(){

	//1. Get collection Page

  $footer_nav .= '<div id="footer-navigation" style="position: relative; height: 28px;" >'."\n";
  $footer_nav .= '<p id="navigation">'."\n";
 
  $pages = get_pages('include=32,34,37,39,42&sort_column=menu_order'); 

  $footer_nav .= '<a href="'.get_bloginfo('url').'">'.__('Home','TheStyle').'</a> | ';

  foreach ($pages as $current_page) {
  	  	
  	$current_page_name = $current_page->post_title;
  	$current_page_url = get_permalink($current_page->ID);
  	
  	$footer_nav .= '<a href="'.$current_page_url.'">'.$current_page_name.'</a> | ';
  }

  
  $footer_nav .= '<a href="#language">'.__('Up','TheStyle').'</a>';  
            	
  //3. close div
  $footer_nav .= '</p>'."\n";
  
  $footer_nav .= '<!-- Contact -->'."\n";
  $footer_nav .='<p id="contact">'."\n";;
  $footer_nav .='<a href="mailto: universetee@gmail.com" title="E-mail contact">E-mail</a> | '."\n";;
	$footer_nav .='<a href="http://www.twitter.com/UniverseTee" title="Twitter">Twitter</a> | '."\n";;
	$footer_nav .='<a href="'.get_bloginfo('rss2_url').'" title="RSS">RSS</a>'."\n";;
	$footer_nav .='</p>'."\n";;
  
  
  $footer_nav .= '</div> <!-- end #footer-navigation -->'."\n";
		
   
  echo $footer_nav;
}
?>