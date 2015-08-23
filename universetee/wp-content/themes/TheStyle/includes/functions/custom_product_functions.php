<?php
/**
 * Universtee functions and definitions
 *
 */


function create_add_cart_man(){

	$product_id_man_us =  get('product_man_us');	
  $article_id_man_us =  get('article_man_us');
  
  $product_id_man_eu =  get('product_man_eu');	
  $article_id_man_eu =  get('article_man_eu');
  
  //$add_cart = '<h3 class="infotitle">'.__('US Cart','TheStyle').'</h3>'."\n";
  //$add_cart .= '<input name="US" type="submit" class="add_basket_button" value="'.__('Add US Cart','TheStyle').'" onClick="US_OR_EU_Button=this;PRODUCT_Button=\''.$product_id_man_us.'\';ARTICLE_Button=\''.$article_id_man_us.'\'"/>'."\n";
  //$add_cart .= '<div class="add_basket_button_soon">'.__('Soon','TheStyle').'</div>'."\n";
  $add_cart .= '<h3 class="infotitle">'.__('EU Cart','TheStyle').'</h3>'."\n";
  $add_cart .= '<h3 class="infotitle unique-price">'.__('Price','TheStyle').'</h3>'."\n";
  $add_cart .= '<input name="EU" type="submit" class="add_basket_button" value="'.__('Add EU Cart','TheStyle').'" onClick="US_OR_EU_Button=this;PRODUCT_Button=\''.$product_id_man_eu.'\';ARTICLE_Button=\''.$article_id_man_eu.'\'"/>'."\n";
  
  echo $add_cart;
}

function create_add_cart_woman(){

	$product_id_woman_us =  get('product_woman_us');	
  $article_id_woman_us =  get('article_woman_us');
  
  $product_id_woman_eu =  get('product_woman_eu');	
  $article_id_woman_eu =  get('article_woman_eu');
  
  //$add_cart = '<h3 class="infotitle">'.__('US Cart','TheStyle').'</h3>'."\n";
  //$add_cart .= '<input name="US" type="submit" class="add_basket_button" value="'.__('Add US Cart','TheStyle').'" onClick="US_OR_EU_Button=this;PRODUCT_Button=\''.$product_id_woman_us.'\';ARTICLE_Button=\''.$article_id_woman_us.'\'"/>'."\n";
  //$add_cart .= '<div class="add_basket_button_soon">'.__('Soon','TheStyle').'</div>'."\n";
  $add_cart .= '<h3 class="infotitle">'.__('EU Cart','TheStyle').'</h3>'."\n";
  $add_cart .= '<h3 class="infotitle unique-price">'.__('Price','TheStyle').'</h3>'."\n";
  $add_cart .= '<input name="EU" type="submit" class="add_basket_button" value="'.__('Add EU Cart','TheStyle').'" onClick="US_OR_EU_Button=this;PRODUCT_Button=\''.$product_id_woman_eu.'\';ARTICLE_Button=\''.$article_id_woman_eu.'\'"/>'."\n";
  
  echo $add_cart;
}

function create_tshirt(){

	$server = 'http://image.spreadshirt.net';

	$product_id_man_us =  get('product_man_eu');	
	$product_id_woman_us =  get('product_woman_eu');	
	
	$ts = '<div id="tshirt-man" class="tshirt" style="display:block;" onclick="ShowTeeWoman()">'."\n";
	$ts .= '<img src="'.$server.'/image-server/image/product/'.$product_id_man_us.'/view/1/type/png/width/800/height/800" width="400" height="400" alt="Man T-shirt">'."\n";
	$ts .= '</div>'."\n";
	$ts .= '<div id="tshirt-woman" class="tshirt" style="display:none;" onclick="ShowTeeMan()">'."\n";
	$ts .= '<img src="'.$server.'/image-server/image/product/'.$product_id_woman_us.'/view/1/type/png/width/800/height/800" width="400" height="400" alt="test">'."\n";
	$ts .= '</div>'."\n";
	
	echo $ts;
}

?>