<?php if (is_archive()) $post_number = get_option('thestyle_archivenum_posts');
if (is_search()) $post_number = get_option('thestyle_searchnum_posts');
if (is_tag()) $post_number = get_option('thestyle_tagnum_posts');
if (is_category()) $post_number = get_option('thestyle_catnum_posts'); ?>
<?php get_header(); ?>
<?php $show_sidebar = (get_option('thestyle_sidebar') == 'on') ? true : false; ?>

<?php include(TEMPLATEPATH . '/includes/breadcrumbs.php'); ?>

<div id="content" class="clearfix<?php if ($show_sidebar && get_option('thestyle_blog_style') == 'false') echo(' sidebar-fixedwidth'); ?>">
	<div id="boxes" class="<?php if (!$show_sidebar) echo('fullwidth'); if (get_option('thestyle_blog_style') == 'on') echo(' blogstyle-entries'); ?>">
		
		<?php global $query_string; 
		if (is_category()) query_posts($query_string . "&showposts=$post_number&paged=$paged&cat=$cat");
		else query_posts($query_string . "&showposts=$post_number&paged=$paged"); ?>
		
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>					
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