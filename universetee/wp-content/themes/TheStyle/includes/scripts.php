<?php global $shortname; ?>

        

	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.masonry.min.js"></script>
	<script type="text/javascript">
		jQuery(window).load(function(){
			<?php if (get_option('thestyle_blog_style') == 'false') { ?>
				jQuery('#content #boxes').masonry({ columnWidth: 122, animate: true });
			<?php } ?>
			jQuery('#footer-content').masonry({ columnWidth: 305, animate: true });
			
			var $fixed_sidebar_content = jQuery('.sidebar-fixedwidth');
			
			if ( $fixed_sidebar_content.length ) {
				var sidebarHeight = $fixed_sidebar_content.find('#sidebar').height(),
					contentHeight = $fixed_sidebar_content.height();
				if ( contentHeight < sidebarHeight ) $fixed_sidebar_content.css('height',sidebarHeight);
			}
		});
	</script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/superfish.js"></script>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/cufon-yui.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/League_Gothic_400.font.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.hoverIntent.minified.js"></script>
	

	<!-- Tubeplayer -->
	<?php $youtube_id =  '"'.get('youtube_id').'"'; ?>
  <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/tubeplayer/swfobject.js"></script>
  <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/tubeplayer/tubeplayer.js"></script>

  <script type="text/javascript">
  	   jQuery.noConflict();	
  	   jQuery("#youtube-player").tubeplayer({
					width: 200, // the width of the player
					height: 75, // the height of the player
        	initialVideo: <?php echo $youtube_id ?>,
					allowFullScreen: "false", // true by default, allow user to go full screen					
					preferredQuality: "hd720",// preferred quality: default, small, medium, large, hd720
					onPlay: function(id){}, // after the play method is called
        	onPause: function(){}, // after the pause method is called
        	onStop: function(){}, // after the player is stopped
        	onSeek: function(time){}, // after the video has been seeked to a defined point
        	onMute: function(){}, // after the player is muted
        	onUnMute: function(){} // after the player is unmuted					
		});
		
		function stopPlayer(){
			jQuery('#youtube-player').tubeplayer('stop');
			alert('jQuery');
		};
		
		function playPlayer(){
			jQuery('#youtube-player').tubeplayer('play');
		};
          
  </script>
  
	

	<script type="text/javascript">
	//<![CDATA[
		jQuery.noConflict();		
		
		<?php if (get_option('thestyle_cufon') == 'on') { ?>
			<?php if (get_option('thestyle_color_scheme') == 'Gray') { ?>
				Cufon.replace('ul.nav a',{textShadow:'1px 1px 0px #fff', hover: { textShadow: '1px 1px 0px #fff' }})('h3.title',{textShadow:'1px 1px 0px #fff'})('.wp-pagenavi',{textShadow:'1px 1px 1px rgba(255,255,255,0.7)'});
			<?php } else { ?>
				Cufon.replace('ul.nav a',{textShadow:'1px 1px 1px #000', hover: { textShadow: '1px 1px 1px #000' }})('h3.title',{textShadow:'1px 1px 1px #000'})('.wp-pagenavi',{textShadow:'1px 1px 1px rgba(0,0,0,0.7)'});
			<?php } ?>
			Cufon.replace('#featured h2.title')('div.category a',{textShadow:'1px 1px 1px rgba(0,0,0,0.3)'})('span.month',{textShadow:'1px 2px 4px rgba(0,0,0,0.3)'})('h2.title a')('p.postinfo')('h3.widgettitle, #tabbed-area li a',{textShadow:'1px 1px 1px #fff'})('h3.infotitle, h1.title, .blog-title, .post-meta, h3#comments, span.fn, .sidebar-menu, .buy, .garantie, div.custompage h2, div.custompage h3, div.unique-price, h3.player-button');
		<?php } ?>
		
		jQuery('ul.nav').superfish({ 
			delay:       200,                            // one second delay on mouseout 
			animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
			speed:       'fast',                          // faster animation speed 
			autoArrows:  true,                           // disable generation of arrow mark-up 
			dropShadows: false                            // disable drop shadows 
		});
		
		jQuery('ul.nav > li > a.sf-with-ul').parent('li').addClass('sf-ul');
		
		//jQuery(".entry").hoverIntent({
		//	over: makeTall,
		//	timeout: 100,
		//	out: makeShort
		//}); 
		
		var $tabbed_area = jQuery('#tabbed'),
			$tab_content = jQuery('.tab-content'),
			$all_tabs = jQuery('#all_tabs');
		
		if ($tabbed_area.length) {
			$tabbed_area.tabs({ fx: { opacity: 'toggle' } });
		};
				
		et_search_bar();
	
		function makeTall(){ 
			jQuery(this).addClass('active').css('z-index','7').find('.bottom-bg .excerpt').animate({"height":200},200);
			jQuery('.entry').not(this).animate({opacity:0.3},200);
		}
		function makeShort(){ 
			jQuery(this).css('z-index','1').find('.bottom-bg .excerpt').animate({"height":75},200);
			jQuery('.entry').removeClass('active').animate({opacity:1},200);
		} 
		
		<!---- Search Bar Improvements ---->
		function et_search_bar(){
			var $searchform = jQuery('#header div#search-form'),
				$searchinput = $searchform.find("input#searchinput"),
				searchvalue = $searchinput.val();
				
			$searchinput.focus(function(){
				if (jQuery(this).val() === searchvalue) jQuery(this).val("");
			}).blur(function(){
				if (jQuery(this).val() === "") jQuery(this).val(searchvalue);
			});
		}
		
		jQuery(".js ul.nav a, .js ul.nav ul a, .js ul.nav ul li, .js ul.nav li.sfHover ul, .js ul.nav li li.sfHover ul, .js div.category a, .js span.month, .js span.date, .js h2.title, .js p.postinfo, .js #tabbed-area li a, .js #sidebar h3.widgettitle, .js .wp-pagenavi span.current, .js .wp-pagenavi span.extend, .js .wp-pagenavi a, .js .wp-pagenavi span, .js #footer h3.title, .js .info-panel h3.infotitle, .js .post-text h1.title, .js .cufon-disabled .blog-title a, .js p.post-meta, .js h3#comments, .js span.fn, .js span.fn a, .js .commentmetadata span.month, .js .commentmetadata span.date, .js div.sidebar-menu, .js div.buy, .js div.garantie, .js div.custompage h2,  .js div.custompage h3, .js div.unique-price, .js #youtube-content h3.player-button").css('text-indent','0px');	

		<?php if (get_option($shortname.'_disable_toptier') == 'on') echo('jQuery("ul.nav > li > ul").prev("a").attr("href","#");'); ?>
		
		jQuery('.entry').click(function(){
			window.location = jQuery(this).find('.title a').attr('href');
		});
		
		<?php if (get_option('thestyle_cufon') == 'on') { ?>
			Cufon.now();
		<?php } ?>
	//]]>	
	</script>