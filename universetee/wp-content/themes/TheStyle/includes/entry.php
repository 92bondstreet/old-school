<?php if (get_option('thestyle_blog_style') == 'false') { ?>

	<?php $biglayout = ( (bool) get_post_meta($post->ID,'et_bigpost',true) ) ? true : false;

		$thumb = '';
		$width = $biglayout ? 466 : 222;
		$height = 180;
		$classtext = '';
		$titletext = get_the_title();
				
		$server = 'http://image.spreadshirt.net';
		$product_id_man_us =  get('product_man_eu');
		$url = $server.'/image-server/image/product/'.$product_id_man_us.'/view/1/type/png/width/800/height/800';
								
		$thumb = '<img width="222" height="222" style="position: absolute; top: 40px;" src="'.$url.'" class="attachment-222x222 wp-post-image" alt="'.$titletext.'" title="'.$titletext.'" />';
		
		$first_post++;
	?>
		
	<div class="entry <?php if ($biglayout) echo('big'); else echo('small');?>">
		<div class="thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php echo $thumb; ?>
			</a>
			<div class="category"><?php the_category(); ?></div>
			
		</div> <!-- end .thumbnail -->	
		<h2 class="title" style="position: relative; top: 30px;"><a href="<?php the_permalink(); ?>"><?php if ($biglayout) truncate_title(50); else truncate_title(20); ?></a></h2>
		<div class="entry-content">
			<div class="bottom-bg" style="position: relative; top: 30px;">
				<div class="excerpt">
					<p><?php if ($biglayout) truncate_post(650); else truncate_post(295); ?> </p>
				</div><!-- end .excerpt -->
			</div><!-- end .bottom-bg -->
		</div><!-- end .entry-content -->
	</div><!-- end .entry -->
	
<?php } else { ?>

	<div class="post">
		<div class="post-content clearfix">			
			<div class="post-text">
				<h2 class="blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				
				<?php if (get_option('thestyle_postinfo1') <> '') { ?>
					<p class="post-meta">
						<?php _e('Posted','TheStyle'); ?> <?php if (in_array('author', get_option('thestyle_postinfo1'))) { ?> <?php _e('by','TheStyle'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('thestyle_postinfo1'))) { ?> <?php _e('on','TheStyle'); ?> <?php the_time(get_option('thestyle_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('thestyle_postinfo1'))) { ?> <?php _e('in','TheStyle'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('thestyle_postinfo1'))) { ?> | <?php comments_popup_link(__('0 comments','TheStyle'), __('1 comment','TheStyle'), '% '.__('comments','TheStyle')); ?><?php }; ?>
					</p>
				<?php }; ?>
				
				<div class="hr"></div>
				
				<?php the_content(); ?>
				
				<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages','TheStyle').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php edit_post_link(__('Edit this page','TheStyle')); ?>
			</div> <!-- .post-text -->
			
			<div class="info-panel">
				<?php include(TEMPLATEPATH . '/includes/infopanel.php'); ?>
			</div> <!-- end .info-panel -->
		</div> <!-- .post-content -->
	</div><!-- end .post -->
	
<?php } ?>