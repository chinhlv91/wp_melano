<?php
	/*
	*
	*	Styleswitcher
	*	------------------------------------------------
	*	Cootheme
	* 	http://www.cootheme.com
	*
	*/
	
	$options = get_option('ct_coo_options');
	$enable_styleswitcher = $options['enable_styleswitcher'];
	
	if ($enable_styleswitcher) {
		add_action('wp_footer', 'ct_styleswitcher');
	}
	
	function ct_styleswitcher() {
		
		$styleswitcher_path = get_template_directory_uri() . '/includes/ct-stylecootheme/';
	
	?>
		
		<div class="style-switcher">
            <a class="switch-button"><i class="fa-cog"></i></a>
			<h4>Style Selector</h4>
			<div class="switch-cont">
				<h4>Primary Color</h4>
				<ul class="options color-select">
					<li><a href="#" data-color="aec71e" style="background-color: #aec71e;"></a></li>
					<li><a href="#" data-color="ec5923" style="background-color: #ec5923;"></a></li>
					<li><a href="#" data-color="2d5c88" style="background-color: #2d5c88;"></a></li>
					<li><a href="#" data-color="2997ab" style="background-color: #2997ab;"></a></li>
					<li><a href="#" data-color="719430" style="background-color: #719430;"></a></li>
					<li><a href="#" data-color="85742e" style="background-color: #85742e;"></a></li>
                    <li><a href="#" data-color="8bbbe0" style="background-color: #8bbbe0;"></a></li>
					<li><a href="#" data-color="8eccb3" style="background-color: #8eccb3;"></a></li>
					<li><a href="#" data-color="435960" style="background-color: #435960;"></a></li>
					<li><a href="#" data-color="e44884" style="background-color: #e44884;"></a></li>
					<li><a href="#" data-color="ff717e" style="background-color: #ff717e;"></a></li>
					<li><a href="#" data-color="46424f" style="background-color: #46424f;"></a></li>
                    <li><a href="#" data-color="a81010" style="background-color: #a81010;"></a></li>
					<li><a href="#" data-color="464646" style="background-color: #464646;"></a></li>
					<li><a href="#" data-color="d73300" style="background-color: #d73300;"></a></li>
					<li><a href="#" data-color="579b18" style="background-color: #579b18;"></a></li>
					<li><a href="#" data-color="20b1ea" style="background-color: #20b1ea;"></a></li>
					<li><a href="#" data-color="f8c741" style="background-color: #f8c741;"></a></li>
				</ul>
				
				<h4>Patterns (Boxed Version)</h4>
				<ul class="options bg-select" data-bgpath="<?php echo $styleswitcher_path; ?>images/">
					<li><a href="#" data-bgimage="pattern_1.png" class="pattern"><img src="<?php echo $styleswitcher_path; ?>images/pattern_1.png" alt="Pattern 1"/></a></li>
					<li><a href="#" data-bgimage="pattern_2.png" class="pattern"><img src="<?php echo $styleswitcher_path; ?>images/pattern_2.png" alt="Pattern 2"/></a></li>
					<li><a href="#" data-bgimage="pattern_3.png" class="pattern"><img src="<?php echo $styleswitcher_path; ?>images/pattern_3.png" alt="Pattern 3"/></a></li>
					<li><a href="#" data-bgimage="pattern_4.png" class="pattern"><img src="<?php echo $styleswitcher_path; ?>images/pattern_4.png" alt="Pattern 4"/></a></li>
					<li><a href="#" data-bgimage="pattern_5.png" class="pattern"><img src="<?php echo $styleswitcher_path; ?>images/pattern_5.png" alt="Pattern 5"/></a></li>
					<li><a href="#" data-bgimage="pattern_6.png" class="pattern"><img src="<?php echo $styleswitcher_path; ?>images/pattern_6.png" alt="Pattern 6"/></a></li>
					<li><a href="#" data-bgimage="pattern_7.png" class="pattern"><img src="<?php echo $styleswitcher_path; ?>images/pattern_7.png" alt="Pattern 7"/></a></li>
					<li><a href="#" data-bgimage="pattern_8.png" class="pattern"><img src="<?php echo $styleswitcher_path; ?>images/pattern_8.png" alt="Pattern 8"/></a></li>
					<li><a href="#" data-bgimage="pattern_9.png" class="pattern"><img src="<?php echo $styleswitcher_path; ?>images/pattern_9.png" alt="Pattern 9"/></a></li>
					<li><a href="#" data-bgimage="pattern_10.png" class="pattern"><img src="<?php echo $styleswitcher_path; ?>images/pattern_10.png" alt="Pattern 10"/></a></li>
					<li><a href="#" data-bgimage="pattern_11.png" class="pattern"><img src="<?php echo $styleswitcher_path; ?>images/pattern_11.png" alt="Pattern 11"/></a></li>
					<li><a href="#" data-bgimage="pattern_12.png" class="pattern"><img src="<?php echo $styleswitcher_path; ?>images/pattern_12.png" alt="Pattern 12"/></a></li>
					<li><a href="#" data-bgimage="pattern_13.png" class="pattern"><img src="<?php echo $styleswitcher_path; ?>images/pattern_13.png" alt="Pattern 13"/></a></li>
				</ul>

                <h4>Layout Style</h4>
                <ul class="options layout-select">
                    <li class="boxed-layout"><a class="boxed" href="#"><img src="<?php echo $styleswitcher_path; ?>images/page-bordered.png" alt="Boxed Layout" /></a></li>
                    <li class="fullwidth-layout"><a class="fullwidth" href="#"><img src="<?php echo $styleswitcher_path; ?>images/page-fullwidth.png" alt="Full Width Layout" /></a></li>
                </ul>
		
		<script>
			var onLoad = {
			    init: function(){
			    
				    "use strict";
				    
				    if (jQuery('#container').hasClass('boxed-layout')) {
				    	jQuery('.boxed-layout').addClass('selected');
				    } else {
				    	jQuery('.fullwidth-layout').addClass('selected');
				    }
				    
				    
				    var currentHeader = jQuery('#header-section').attr('class').split(' ')[0];
				    jQuery(".header-select option[value="+currentHeader+"]").prop("selected", "selected")
				    
							
					jQuery('.style-switcher').on('click', 'a.switch-button', function(e) {
						e.preventDefault();
						var $style_switcher = jQuery('.style-switcher');
						if ($style_switcher.css('left') === '0px') {
							$style_switcher.animate({
								left: '-180'
							});
						} else {
							$style_switcher.animate({
								left: '0'
							});
						}
					});
				
					jQuery('.layout-select li').on('click', 'a', function(e) {
						e.preventDefault();
						jQuery('.layout-select li').removeClass('selected');
						jQuery(this).parent().addClass('selected');
						var selectedLayout = jQuery(this).attr('class');
						
						if (selectedLayout === "boxed") {
							jQuery("#container").addClass('boxed-layout');
						} else {
							jQuery("#container").removeClass('boxed-layout');
						}
						
						jQuery('.flexslider').each(function() {
							var slider = jQuery(this).data('flexslider');
							if (slider) {
							slider.resize();
							}
						});
						jQuery(window).resize();
					});
					
					jQuery('.header-select').change(function() {
						var baseURL = onLoad.getPathFromUrl(location.href),
							newURLParam = "?header=" + jQuery('.header-select').val();
						
						location.href = baseURL + newURLParam;
					});
									
					jQuery('.bg-select li').on('click', 'a', function(e) {
						e.preventDefault();
						var newBackground = jQuery(this).attr('data-bgimage'),
							bgType = jQuery(this).attr('class'),
							bgPath = jQuery('.bg-select').attr('data-bgpath');
								
						if (bgType === "cover") {
							jQuery('body').css('background', 'url('+bgPath+newBackground+') no-repeat center top fixed');
							jQuery('body').css('background-size', 'cover');
						} else {
							jQuery('body').css('background', 'url('+bgPath+newBackground+') repeat center top fixed');
							jQuery('body').css('background-size', 'auto');
						}
					});
					
					jQuery('.color-select li').on('click', 'a', function(e) {
						e.preventDefault();
                        jQuery(this).parent().parent().find('a.select').removeClass('select');
                        jQuery(this).addClass('select');
						
						var selectedColor = '#' + jQuery(this).data('color');
						
						jQuery('.recent-post figure,span.highlighted,span.dropcap4,.flickr-widget li,.portfolio-grid li,.wpcf7 input.wpcf7-submit[type="submit"],.woocommerce-page nav.woocommerce-pagination ul li span.current,.woocommerce nav.woocommerce-pagination ul li span.current,figcaption .product-added,.woocommerce .wc-new-badge,.yith-wcwl-wishlistexistsbrowse a,.yith-wcwl-wishlistaddedbrowse a,.woocommerce .widget_layered_nav ul li.chosen > *,.woocommerce .widget_layered_nav_filters ul li a,.sticky-post-icon,figure.animated-overlay figcaption,.ct-button.accent,.ct-button.ct-icon-reveal.accent,.progress .bar,.ct-icon-box-animated .back,.labelled-pricing-table .column-highlight .lpt-button-wrap a.accent,.progress.standard .bar,.woocommerce .order-info,.woocommerce .order-info mark,.slideout-filter ul li.selected a,.blog-aux-options li.selected a,nav#main-navigation .menu > li > a span.nav-line').css('background-color', selectedColor);
						jQuery('#copyright a,.portfolio-item .portfolio-item-permalink,.read-more-link,.blog-item .read-more,.blog-item-details a,.author-link,.comment-meta .edit-link a,.comment-meta .comment-reply a,#reply-title small a,ul.member-contact,ul.member-contact li a,span.dropcap2,.spb_divider.go_to_top a,.love-it-wrapper .loved,.comments-likes .loved span.love-count,#header-translation p a,.caption-details-inner .details span > a,.caption-details-inner .chart span,.caption-details-inner .chart i,#coo-slider .flex-caption-large .chart i,.woocommerce .star-rating span,.ct-super-search .search-options .ss-dropdown > span,.ct-super-search .search-options input,.ct-super-search .search-options .ss-dropdown ul li .fa-check,#coo-slider .flex-caption-large .loveit-chart span,#coo-slider .flex-caption-large a,.progress-bar-wrap .progress-value,.ct-icon,nav .menu li.current-menu-ancestor > a,nav .menu li.current-menu-item > a,#mobile-menu .menu ul li.current-menu-item > a').css('color', selectedColor);
						jQuery('.bypostauthor .comment-wrap .comment-avatar,a[rel="tooltip"],.ct-icon-box-animated .back').css('border-color', selectedColor);
						jQuery('.spb_impact_text .spb_call_text').css('border-left-color', selectedColor);
						jQuery('.ct-super-search .search-options .ss-dropdown > span,.ct-super-search .search-options input').css('border-bottom-color', selectedColor);
						
					});
					
			    },
			    getURLVars: function() {
			    	var vars = [], hash;
			    	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
			    	for(var i = 0; i < hashes.length; i++)
			    	{
			    	    hash = hashes[i].split('=');
			    	    vars.push(hash[0]);
			    	    vars[hash[0]] = hash[1];
			    	}
			    	return vars;
			    },
			   	getPathFromUrl: function(url) {
			      return url.split("?")[0];
			    }
			};
			
			jQuery(document).ready(onLoad.init);
		</script>
	
	<?php }
	
?>