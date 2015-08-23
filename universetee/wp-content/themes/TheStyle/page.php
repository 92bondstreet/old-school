<?php get_header();
the_post(); ?>

<?php include(TEMPLATEPATH . '/includes/breadcrumbs.php'); ?>

<div id="content" class="clearfix">
	<?php if (get_option('thestyle_integration_single_top') <> '' && get_option('thestyle_integrate_singletop_enable') == 'on') echo(get_option('thestyle_integration_single_top')); ?>
	<div id="left-area">
		<div id="post" class="post">
			<div class="post-content clearfix">
				<div class="info-panel">
					<?php include(TEMPLATEPATH . '/includes/infopanel.php'); ?>
				</div> <!-- end .info-panel -->
				
				<div class="post-text">
					<h1 class="title"><?php the_title(); ?></h1>
										
					<div class="hr"></div>
					
					<?php the_content(); ?>
					
					<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages','TheStyle').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php edit_post_link(__('Edit this page','TheStyle')); ?>
					
					<?php if (get_option('thestyle_integration_single_bottom') <> '' && get_option('thestyle_integrate_singlebottom_enable') == 'on') echo(get_option('thestyle_integration_single_bottom')); ?>
					
					<?php if (get_option('thestyle_468_enable') == 'on') { ?>
						<?php if(get_option('thestyle_468_adsense') <> '') echo(get_option('thestyle_468_adsense'));
						else { ?>
							<a href="<?php echo(get_option('thestyle_468_url')); ?>"><img src="<?php echo(get_option('thestyle_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
						<?php } ?>	
					<?php } ?>
				</div> <!-- .post-text -->
			</div> <!-- .post-content -->			
		</div> <!-- #post -->
		
		<?php if (get_option('thestyle_show_pagescomments') == 'on') comments_template('', true); ?>
	</div> <!-- #left-area -->
	<?php get_sidebar(); ?>
</div> <!-- #content -->
		
<div id="content-bottom-bg"></div>
			
<?php get_footer(); ?>