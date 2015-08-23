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
	<h3 class="infotitle"><?php _e('Tags','TheStyle'); ?></h3>
	<div class="tags clearfix">
		<?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
	</div>

	<h3 class="infotitle"><?php _e('Related Posts','TheStyle'); ?></h3>
	<?php $orig_post = $post;
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if ($tags) {
		$tag_ids = array();
		
		foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
		$args=array(
			'tag__in' => $tag_ids,
			'post__not_in' => array($post->ID),
			'showposts'=>4,
			'caller_get_posts'=>1
		);
		$my_query = new wp_query( $args );
		
		if( $my_query->have_posts() ) { ?>
			<div class="related">
				<ul class="related-posts">
					<?php while( $my_query->have_posts() ) {
					$my_query->the_post(); ?>
						<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
					<?php } ?>
				</ul>
			</div>
		<?php }
	}
	
	if ( is_single() || is_page() ) wp_reset_query();
	$post = $orig_post; ?>
<?php } ?>

<h3 class="infotitle"><?php _e('Share This','TheStyle'); ?></h3>
<div class="share-panel">
	<?php $permalink = get_permalink(); ?>
	<a href="http://twitter.com/home?status=<?php the_title(); echo(' '); echo $permalink; ?>"><img src="<?php bloginfo('template_directory');?>/images/twitter.png" alt="" /></a>
	<a href="http://www.facebook.com/sharer.php?u=<?php echo esc_js($permalink); ?>&t=<?php the_title(); ?>" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/facebook.png" alt="" /></a>
	<a href="http://del.icio.us/post?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/delicious.png" alt="" /></a>
	<a href="http://www.digg.com/submit?phase=2&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/digg.png" alt="" /></a>
	<a href="http://www.reddit.com/submit?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/reddit.png" alt="" /></a>
</div> <!-- end .share-panel -->