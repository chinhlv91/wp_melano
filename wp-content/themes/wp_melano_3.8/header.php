<!DOCTYPE html>

<!--// OPEN HTML //-->
<html <?php language_attributes(); ?>>

	<!--// OPEN HEAD //-->
	<head>
		<?php
			$options = get_option('ct_coo_options');
			$enable_responsive = $options['enable_responsive'];
			$is_responsive = "responsive-fluid";
			if (!$enable_responsive) {
				$is_responsive = "responsive-fixed";
			}
			$header_layout = $options['header_layout'];
			$page_layout = $options['page_layout'];
			$enable_logo_fade = $options['enable_logo_fade'];
			$enable_page_shadow = $options['enable_page_shadow'];
			$enable_top_bar = $options['enable_tb'];
			$enable_mini_header = $options['enable_mini_header'];
			$enable_header_shadow = $options['enable_header_shadow'];

			$page_class = $header_wrap_class = $logo_class = $ss_enable = "";

			if (isset($_GET['header'])) {
				$header_layout = $_GET['header'];
			}

			if ($header_layout == "header-3" || $header_layout == "header-4" || $header_layout == "header-5") {
				$header_wrap_class = " container";
				$page_class .= "header-overlay ";
			}

            $header_big = "";
            if($header_layout == "header-3" || $header_layout == "header-4" || $header_layout == "header-5" || $header_layout == "header-6" || $header_layout == "header-7"){
                $header_big = "header-big";
            }

			global $ct_catalog_mode;
			if (isset($options['enable_catalog_mode'])) {
				$enable_catalog_mode = $options['enable_catalog_mode'];
				if ($enable_catalog_mode) {
					$ct_catalog_mode = true;
					$page_class = "catalog-mode ";
				}
			}

			if ($enable_mini_header) {
			$page_class .= "mini-header-enabled ";
			}

			if ($enable_page_shadow) {
			$page_class .= "page-shadow ";
			}

			if ($enable_header_shadow) {
			$page_class .= "header-shadow ";
			}

			if ($enable_logo_fade) {
			$logo_class = "logo-fade";
			}

			if (isset($_GET['layout'])) {
				$page_layout = $_GET['layout'];
			}

			$page_class .= "layout-".$page_layout." ";

			if (isset($options['ss_enable'])) {
				$ss_enable = $options['ss_enable'];
			} else {
				$ss_enable = true;
			}

			global $post;
			$extra_page_class = $description = "";
			if ($post) {
			$extra_page_class = get_post_meta($post->ID, 'ct_extra_page_class', true);
			}
		?>

		<!--// SITE TITLE //-->
		<title><?php wp_title( '|', true, 'right' ); ?></title>

		<!--// SITE META //-->
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<?php if ($enable_responsive) { ?><meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
		<?php } ?>
		<?php if (isset($options['custom_ios_title']) && $options['custom_ios_title'] != "") { ?><meta name="apple-mobile-web-app-title" content="<?php echo $options['custom_ios_title']; ?>">
		<?php } ?>

		<!--// PINGBACK & FAVICON //-->
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php if (isset($options['custom_favicon']) && $options['custom_favicon'] != "") { ?><link rel="shortcut icon" href="<?php echo $options['custom_favicon']; ?>" /><?php } ?>

		<?php if (isset($options['custom_ios_icon144']) && $options['custom_ios_icon144'] != "") { ?>
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $options['custom_ios_icon144']; ?>" />
		<?php } ?>
		<?php if (isset($options['custom_ios_icon114']) && $options['custom_ios_icon114'] != "") { ?>
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $options['custom_ios_icon114']; ?>" />
		<?php } ?>
		<?php if (isset($options['custom_ios_icon72']) && $options['custom_ios_icon72'] != "") { ?>
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $options['custom_ios_icon72']; ?>" />
		<?php } ?>
		<?php if (isset($options['custom_ios_icon57']) && $options['custom_ios_icon57'] != "") { ?>
		<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo $options['custom_ios_icon57']; ?>" />
		<?php } ?>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700' rel='stylesheet' type='text/css'>

		<?php
			$custom_fonts = $google_font_one = $google_font_two = $google_font_three = "";

			$body_font_option = $options['body_font_option'];
			if (isset($options['google_standard_font'])) {
			$google_font_one = $options['google_standard_font'];
			}
			$headings_font_option = $options['headings_font_option'];
			if (isset($options['google_heading_font'])) {
			$google_font_two = $options['headings_font_option'];
			}
			$menu_font_option = $options['menu_font_option'];
			if (isset($options['google_menu_font'])) {
			$google_font_three = $options['google_menu_font'];
			}

			if ($body_font_option == "google" && $google_font_one != "") {
				$custom_fonts .= "'".$google_font_one."', ";
			}
			if ($headings_font_option == "google" && $google_font_two != "") {
				$custom_fonts .= "'".$google_font_two."', ";
			}
			if ($menu_font_option == "google" && $google_font_three != "") {
				$custom_fonts .= "'".$google_font_three."', ";
			}

			$fontdeck_js = $options['fontdeck_js'];
		?>
		<?php if (($body_font_option == "google") || ($headings_font_option == "google") || ($menu_font_option == "google")) { ?>
		<!--// GOOGLE FONT LOADER //-->
		<script>
			var html = document.getElementsByTagName('html')[0];
			html.className += '  wf-loading';
			setTimeout(function() {
			  html.className = html.className.replace(' wf-loading', '');
			}, 3000);

			WebFontConfig = {
			    google: { families: [<?php echo $custom_fonts; ?> 'Astloch'] }
			};

			(function() {
				document.getElementsByTagName("html")[0].setAttribute("class","wf-loading")
				//  NEEDED to push the wf-loading class to your head
				document.getElementsByTagName("html")[0].setAttribute("className","wf-loading")
				// for IE

			var wf = document.createElement('script');
				wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
				 '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
				wf.type = 'text/javascript';
				wf.async = 'false';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(wf, s);
			})();
		</script>
		<?php } ?>
		<?php if (($body_font_option == "fontdeck") || ($headings_font_option == "fontdeck") || ($menu_font_option == "fontdeck")) { ?>
		<!--// FONTDECK LOADER //-->
		<?php echo $fontdeck_js; ?>
		<?php } ?>

		<!--// WORDPRESS HEAD HOOK //-->
		<?php wp_head(); ?>

	<!--// CLOSE HEAD //-->
	</head>

	<!--// OPEN BODY //-->
	<body <?php body_class($page_class.' '.$is_responsive.' '.$extra_page_class); ?> ontouchstart="">

		<!--// NO JS ALERT //-->
		<noscript>
			<div class="no-js-alert"><?php _e("Please enable JavaScript to view this website.", "cootheme"); ?></div>
		</noscript>

        <div id="header-search">
			<div class="container clearfix">
				<form method="get" class="search-form" action="<?php echo home_url(); ?>/"><input type="text" placeholder="<?php _e("Search for something...", "cootheme"); ?>" name="s" autocomplete="off" /></form>
				<a id="header-search-close" href="#"><i class="ss-delete"></i></a>
			</div>
		</div>

		<?php
			// SUPER SEARCH
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				if ($ss_enable) {
					echo ct_super_search();
				}
			}
		?>

		<?php
			// MOBILE MENU
			echo ct_mobile_menu();
		?>

		<!--// OPEN #container //-->
		<?php if ($page_layout == "fullwidth") { ?>
		<div id="container">
		<?php } else { ?>
		<div id="container" class="boxed-layout">
		<?php } ?>

			<!--// HEADER //-->
			<div class="header-wrap<?php echo $header_wrap_class; ?>">

				<?php if ($enable_top_bar) { ?>
					<!--// TOP BAR //-->
					<?php echo ct_top_bar(); ?>
				<?php } ?>

				<div id="header-section" class="<?php echo $header_layout; ?> <?php echo $logo_class; ?> <?php echo $header_big; ?>">
					<?php echo ct_header($header_layout); ?>
				</div>

			</div>

			<!--// OPEN #main-container //-->
			<div id="main-container" class="clearfix">
                <?php if (is_page()) {
                global $post;
                $show_posts_slider = get_post_meta($post->ID, 'sf_posts_slider', true);
                $rev_slider_alias = get_post_meta($post->ID, 'sf_rev_slider_alias', true);
                $layerSlider_ID = get_post_meta($post->ID, 'sf_layerslider_id', true);

                if ($show_posts_slider) {
                    sf_swift_slider();
                } else if ($rev_slider_alias != "") { ?>
                    <div class="home-slider-wrap">
                        <?php putRevSlider($rev_slider_alias); ?>
                    </div>
                    <?php }
                }
                ?>

				<!--// OPEN .container //-->
				<div class="container">

					<!--// OPEN #page-wrap //-->
					<div id="page-wrap">

