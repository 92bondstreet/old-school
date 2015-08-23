<?php $thumb = '';
	$width = 38;
	$height = 38;
	$classtext = 'smallthumb';
	$titletext = get_the_title();
	
	$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
	$thumb = $thumbnail["thumb"]; ?>

<li class="clearfix">
	<?php if ($thumb <> '') { ?>
		<a href="<?php the_permalink(); ?>">
			<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
		</a>
	<?php } ?>
	<span class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
	<span class="postinfo"><?php _e('Posted','TheStyle'); ?> <?php _e('by','TheStyle'); ?> <?php the_author_posts_link(); ?> <?php _e('on','TheStyle'); ?> <?php the_time(get_option('thestyle_date_format')) ?></span>
</li>