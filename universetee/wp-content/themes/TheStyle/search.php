<?php $post_number = get_option('thestyle_searchnum_posts'); ?>
<?php get_header(); ?>
<?php $show_sidebar = (get_option('thestyle_sidebar') == 'on') ? true : false; ?>

<?php include(TEMPLATEPATH . '/includes/breadcrumbs.php'); ?>

<div id="content" class="clearfix<?php if ($show_sidebar && get_option('thestyle_blog_style') == 'false') echo(' sidebar-fixedwidth'); ?>">
	<div id="boxes" class="<?php if (!$show_sidebar) echo('fullwidth'); if (get_option('thestyle_blog_style') == 'on') echo(' blogstyle-entries'); ?>">
		
		<?php 
			global $query_string; 

			parse_str($query_string, $qstring_array);
						
			$args = array('showposts' => $post_number,'paged'=>$paged);
			
			if ( isset($_GET['et_searchform_submit']) ) {			
				$postTypes = array();
				if ( !isset($_GET['et-inc-posts']) && !isset($_GET['et-inc-pages']) ) $postTypes = array('post');
				if ( isset($_GET['et-inc-pages']) ) $postTypes = array('page');
				if ( isset($_GET['et-inc-posts']) ) $postTypes[] = 'post';
				$args['post_type'] = $postTypes;
				
				if ( $_GET['et-month-choice'] != 'no-choice' ) {
					$et_year = substr($_GET['et-month-choice'],0,4);
					$et_month = substr($_GET['et-month-choice'], 4, strlen($_GET['et-month-choice'])-4);
					$args['year'] = $et_year;
					$args['monthnum'] = $et_month;
				}
				
				if ( $_GET['et-cat'] != 0 )
					$args['cat'] = $_GET['et-cat'];
			}	
			
			$args = array_merge($args,$qstring_array);
						
			query_posts($args);
		?>
		
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