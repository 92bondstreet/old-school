<?php get_header(); ?>
<?php $show_sidebar = (get_option('thestyle_sidebar_home') == 'on') ? true : false; ?>

<div id="content" class="clearfix<?php if ($show_sidebar && get_option('thestyle_blog_style') == 'false') echo(' sidebar-fixedwidth'); ?>">
	<div id="boxes" class="<?php if (!$show_sidebar) echo('fullwidth'); if (get_option('thestyle_blog_style') == 'on') echo(' blogstyle-entries'); ?>">
		<?php $args=array(
			'showposts' => get_option('thestyle_homepage_posts'),
			'paged' => $paged,
			'category__not_in' => get_option('thestyle_exlcats_recent')
		);
		query_posts($args); ?>
                <?php $first_post = 0; ?>
		<?php if (have_posts()) : while (have_posts()) : the_post();?>					
			<?php include(TEMPLATEPATH . '/includes/entry.php'); ?>
			<?php $i++; ?>
		<?php endwhile; ?>
				</div> <!-- #boxes -->
				<?php if ($show_sidebar) get_sidebar(); ?>
			</div> <!-- #content -->
			<div id="controllers" class="clearfix">
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
				include(TEMPLATEPATH . '/includes/navigation.php'); ?>
			</div> <!-- #controllers -->
		<?php else : ?>
					<?php include(TEMPLATEPATH . '/includes/no-results.php'); ?>
				</div> <!-- #boxes -->
			</div> <!-- #content -->
		<?php endif; wp_reset_query(); ?>
	
	<div id="content-bottom-bg"></div>
			
<?php get_footer(); ?>			