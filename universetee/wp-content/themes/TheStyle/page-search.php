<?php 
/*
Template Name: Search Page
*/
?>
<?php the_post(); ?>

<?php 
	$et_ptemplate_settings = array();
	$et_ptemplate_settings = maybe_unserialize( get_post_meta($post->ID,'et_ptemplate_settings',true) );
	
	$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : (bool) $et_ptemplate_settings['et_fullwidthpage'];
?>

<?php get_header(); ?>

<?php include(TEMPLATEPATH . '/includes/breadcrumbs.php'); ?>

<div id="content" class="clearfix<?php if($fullwidth) echo(' fullwidth');?>">
	<?php if (get_option('thestyle_integration_single_top') <> '' && get_option('thestyle_integrate_singletop_enable') == 'on') echo(get_option('thestyle_integration_single_top')); ?>
	<div id="left-area">
		<div id="post" class="post">
			<div class="post-content clearfix">
				
				<?php if (!$fullwidth) { ?>
					<div class="info-panel">
						<?php include(TEMPLATEPATH . '/includes/infopanel.php'); ?>
					</div> <!-- end .info-panel -->
				<?php } ?>
					
				<div class="post-text">
					<h1 class="title"><?php the_title(); ?></h1>
										
					<div class="hr"></div>
					
					<?php the_content(); ?>
					
					<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages','TheStyle').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					
					<div id="et-search">
						<div id="et-search-inner" class="clearfix">
							<p id="et-search-title"><span><?php _e('search this website','TheStyle'); ?></span></p>
							<form action="<?php bloginfo('url'); ?>" method="get" id="et_search_form">
								<div id="et-search-left">
									<p id="et-search-word"><input type="text" id="et-searchinput" name="s" value="search this site..." /></p>
																	
									<p id="et_choose_posts"><label><input type="checkbox" id="et-inc-posts" name="et-inc-posts"> <?php _e('Posts','TheStyle'); ?></label></p>
									<p id="et_choose_pages"><label><input type="checkbox" id="et-inc-pages" name="et-inc-pages"> <?php _e('Pages','TheStyle'); ?></label></p>
									<p id="et_choose_date">
										<select id="et-month-choice" name="et-month-choice">
											<option value="no-choice"><?php _e('Select a month','TheStyle'); ?></option>
											<?php 
												global $wpdb, $wp_locale;
												
												$selected = '';
												$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC";
												
												$arcresults = $wpdb->get_results($query);
																													
												foreach ( (array) $arcresults as $arcresult ) {
													if ( isset($_POST['et-month-choice']) && ( $_POST['et-month-choice'] == ($arcresult->year . $arcresult->month) ) ) {
														$selected = ' selected="selected"';
													}
													echo "<option value='{$arcresult->year}{$arcresult->month}'{$selected}>{$wp_locale->get_month($arcresult->month)}" . ", {$arcresult->year}</option>";
													if ( $selected <> '' ) $selected = '';
												}
											?>
										</select>
									</p>
								
									<p id="et_choose_cat"><?php wp_dropdown_categories('show_option_all=Choose a Category&show_count=1&hierarchical=1&id=et-cat&name=et-cat'); ?></p>
								</div> <!-- #et-search-left -->
								
								<div id="et-search-right">
									<input type="hidden" name="et_searchform_submit" value="et_search_proccess" />
									<input class="et_search_submit" type="submit" value="<?php _e('Submit','TheStyle'); ?>" id="et_search_submit" />
								</div> <!-- #et-search-right -->
							</form>
						</div> <!-- end #et-search-inner -->
					</div> <!-- end #et-search -->
					
					<div class="clear"></div>
					
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
	</div> <!-- #left-area -->
	<?php get_sidebar(); ?>
</div> <!-- #content -->
			
<div id="content-bottom-bg"></div>
			
<?php get_footer(); ?>