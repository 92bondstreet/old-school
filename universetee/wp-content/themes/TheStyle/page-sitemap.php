<?php 
/*
Template Name: Sitemap Page
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
					
					<div id="sitemap">
						<div class="sitemap-col">
							<h2><?php _e('Pages','TheStyle'); ?></h2>
							<ul id="sitemap-pages"><?php wp_list_pages('title_li='); ?></ul>
						</div> <!-- end .sitemap-col -->
						
						<div class="sitemap-col">
							<h2><?php _e('Categories','TheStyle'); ?></h2>
							<ul id="sitemap-categories"><?php wp_list_categories('title_li='); ?></ul>
						</div> <!-- end .sitemap-col -->
						
						<div class="sitemap-col<?php if (!$fullwidth) echo ' last'; ?>">
							<h2><?php _e('Tags','TheStyle'); ?></h2>
							<ul id="sitemap-tags">
								<?php $tags = get_tags();
								if ($tags) {
									foreach ($tags as $tag) {
										echo '<li><a href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a></li> ';
									}
								} ?>
							</ul>
						</div> <!-- end .sitemap-col -->
						
						<?php if (!$fullwidth) { ?>
							<div class="clear"></div>
						<?php } ?>
						
						<div class="sitemap-col<?php if ($fullwidth) echo ' last'; ?>">
							<h2><?php _e('Authors','TheStyle'); ?></h2>
							<ul id="sitemap-authors" ><?php wp_list_authors('show_fullname=1&optioncount=1&exclude_admin=0'); ?></ul>
						</div> <!-- end .sitemap-col -->
					</div> <!-- end #sitemap -->
					
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