<?php $thumb = '';
	$width = 186;
	$height = 186;
	$classtext = 'smallthumb';
	$titletext = get_the_title();	
	$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
	$thumb = $thumbnail['thumb']; ?>
<?php if ( ( !is_page() && $thumb <> '' && get_option('thestyle_blog_thumbnails') == 'on' ) || ( is_page() && $thumb <> '' && get_option('thestyle_page_thumbnails') == 'on' ) ) { ?>
	<div class="single-thumb">
		<?php if ( !is_single() && !is_page() ) { ?>
			<a href="<?php the_permalink(); ?>">
		<?php } ?>
			<?php print_thumbnail($thumb, $thumbnail['use_timthumb'], $titletext, $width, $height); ?>
			<span class="overlay"></span>
			<?php if (!is_page()) { ?>
				<div class="category"><?php the_category(); ?></div>
				<span class="month"><?php the_time('M'); ?><span class="date"><?php the_time('d'); ?></span></span>
			<?php } ?>
		<?php if ( !is_single() && !is_page() ) { ?>
			</a>
		<?php } ?>
	</div> <!-- end .single-thumb -->
<?php } ?>

<div class="clear"></div>

<?php if ( !is_page() ) { ?>
  
	<!-- MAN or WOMAN -->
	<h3 class="infotitle"><?php _e('Model','TheStyle'); ?></h3>
	<div class="model clearfix">
		<ul>
			<li id="model-man" class="selected"><a href="javascript:void(0)" onclick="ShowTeeMan()" rel="tag"><?php _e('Man','TheStyle'); ?></a></li>
			<li id="model-woman" class="noselected"><a href="javascript:void(0)" onclick="ShowTeeWoman()" rel="tag"><?php _e('Woman','TheStyle'); ?></a></li>
		</ul>
	</div>
	<div class="info-hr"></div>
	<!-- Cart MAN Action -->
	<form id="formArticle-man"  onsubmit="return AddToCart('formArticle-man','<?php _e('Adding','TheStyle'); ?>');" method="post">
	<h3 class="infotitle"><?php _e('Size','TheStyle'); ?></h3>
		<fieldset>        		
		<input type="hidden" name="product" value="" />
		<input type="hidden" name="article" value="" />
		<div class="selector-wrapper">
			<select class="single-option-selector" name="size" id="product-select-option-0">
			<option value="2">S    </option>
			<option value="3">M    </option>
			<option value="4">L    </option>
			<option value="5">XL   </option>
			<option value="6">XXL  </option>
			</select>
		</div>
                <div class="info-hr"></div>
		<?php create_add_cart_man(); ?>
		</fieldset>
	</form>

        <!-- Cart WOMAN Action -->
	<form id="formArticle-woman"  style="display:none;" onsubmit="return AddToCart('formArticle-woman','<?php _e('Adding','TheStyle'); ?>');" method="post">
	<h3 class="infotitle"><?php _e('Size','TheStyle'); ?></h3>
		<fieldset>        		
		<input type="hidden" name="product" value="" />
		<input type="hidden" name="article" value="" />
		<div class="selector-wrapper">
			<select class="single-option-selector" name="size" id="product-select-option-0">
			<option value="2">S    </option>
			<option value="3">M    </option>
			<option value="4">L    </option>
			<option value="5">XL   </option>
			<option value="6">XXL  </option>
			</select>
		</div>
                <div class="info-hr"></div>
		<?php create_add_cart_woman(); ?>
		</fieldset>
	</form>


<?php } ?>

<div class="info-hr"></div>
<h3 class="infotitle"><?php _e('Like it','TheStyle'); ?></h3>
<div class="share-panel">
	<?php $permalink = get_permalink(); ?>
	<a href="http://twitter.com/home?status=<?php the_title(); echo(' '); echo $permalink; ?>"><img src="<?php bloginfo('template_directory');?>/images/twitter.png" alt="" /></a>
	<a href="http://www.facebook.com/sharer.php?u=<?php echo esc_js($permalink); ?>&t=<?php the_title(); ?>" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/facebook.png" alt="" /></a>
	<a href="http://del.icio.us/post?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/delicious.png" alt="" /></a>
	<a href="http://www.digg.com/submit?phase=2&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/digg.png" alt="" /></a>
	<a href="http://www.reddit.com/submit?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/reddit.png" alt="" /></a>
</div> <!-- end .share-panel -->