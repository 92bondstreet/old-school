<?php get_header();
the_post(); ?>

<?php include(TEMPLATEPATH . '/includes/breadcrumbs.php'); ?>

<div id="content" class="clearfix">
	<?php if (get_option('thestyle_integration_single_top') <> '' && get_option('thestyle_integrate_singletop_enable') == 'on') echo(get_option('thestyle_integration_single_top')); ?>
	<div id="left-area" style="margin-left:0;position:relative;">               
		<div id="post" class="post">
			<div class="post-content clearfix">

				<div class="info-panel">
					<?php include(TEMPLATEPATH . '/includes/infopanel-product.php'); ?>
				</div> <!-- end .info-panel -->
				
				<div id="TeeShop" class="post-text">
					<h1 class="title"><?php the_title(); ?></h1>
					
					<?php if (get_option('thestyle_postinfo2') <> '') { ?>
						<p class="post-meta"> 
                                         <?php the_tags('',' | ',''); ?>	
						</p>
					<?php }; ?>
					
					<div class="hr"></div>
					
					<?php the_content(); ?>
 
                                        <!-- Man/Woman T-shirt -->
                                        <?php create_tshirt(); ?>  
					
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
        <div id="youtube-content">
             <h3 class="player-button"><?php _e('Listen','TheStyle'); ?></h3>		  					  														
        </div> 
        <div id="youtube-player" style="position:absolute;top:15px;right:15px"> </div>
        <!-- youtube-content -->
            
				
			</div> <!-- .post-content -->			
		</div> <!-- #post -->
                
                <!-- Product Description-->
				<?php $default_desc = TEMPLATEPATH . '/includes/description-product.php'; ?> 
				<?php $lang_desc = TEMPLATEPATH . '/includes/description-product-'.qtrans_getLanguage().'.php'; ?>
				<?php 	if(is_file($lang_desc)){ include($lang_desc);}
						else{ include($default_desc);}
				?>		

		<?php if (get_option('thestyle_show_postcomments') == 'on') comments_template('', true); ?>
	</div> <!-- #left-area -->
	<?php get_sidebar(); ?>
        <!-- Fixed menu -->
        <div id="sidebar" class="position">
		<div class="widget">		
			<div class="sidebar-menu"><a href="#TeeShop"><?php _e('Menu_ts','TheStyle'); ?></a></div>
			<div class="sidebar-menu"><a href="#TeeSize-man"><?php _e('Menu_size','TheStyle'); ?></a></div>
			<div class="sidebar-menu"><a href="#TeeDelivery"><?php _e('Menu_delivery','TheStyle'); ?></a></div>
			<div class="sidebar-menu"><a href="<?php echo get_permalink('252'); ?>"><?php _e('Menu_price','TheStyle'); ?></a></div>
			<div class="sidebar-menu"><a href="#TeeGuarantee"><?php _e('Menu_guarantee','TheStyle'); ?></a></div>
		</div>			
       </div> <!-- end #sidebar -->
</div> <!-- #content -->		
<div id="content-bottom-bg"></div>
			
<?php get_footer(); ?>			