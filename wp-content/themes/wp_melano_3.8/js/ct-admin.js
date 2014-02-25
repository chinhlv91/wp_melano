/*
*
*	Admin jQuery Functions
*	------------------------------------------------
*	Cootheme
* 	http://www.cootheme.com
*
*/

jQuery(function(jQuery) {
	
	// FIELD VARIABLES

	var $sidebar_config = jQuery('#ct_sidebar_config'),
		$left_sidebar = jQuery('#ct_left_sidebar').parent().parent(),
		$right_sidebar = jQuery('#ct_right_sidebar').parent().parent();
	var $show_coo_slider = jQuery('#ct_posts_slider'),
		$posts_slider_type = jQuery('#ct_posts_slider_type'),
		$slider_posts_category = jQuery('#ct_posts_slider_category').parent().parent(),
		$slider_portfolio_category = jQuery('#ct_posts_slider_portfolio_category').parent().parent(),
		$slider_count = jQuery('#ct_posts_slider_count').parent().parent(),
		$revslider_alias = jQuery('#ct_rev_slider_alias').parent().parent(),
		$layerslider_id = jQuery('#ct_layerslider_id').parent().parent();
	var $thumb_type = jQuery('#ct_thumbnail_type'),
		$thumb_image = jQuery('#ct_thumbnail_image_description').parent().parent(),
		$thumb_video = jQuery('#ct_thumbnail_video_url').parent().parent(),
		$thumb_gallery = jQuery('#ct_thumbnail_gallery_description').parent().parent();
	var $link_type = jQuery('#ct_thumbnail_link_type'),
		$link_url = jQuery('#ct_thumbnail_link_url').parent().parent(),
		$link_image = jQuery('a[data-field_id="ct_thumbnail_link_image"]').parent().parent(),
		$link_video = jQuery('#ct_thumbnail_link_video_url').parent().parent();
	var $use_thumb_content = jQuery('#ct_thumbnail_content_main_detail'),
		$detail_type = jQuery('#ct_detail_type'),
		$detail_image = jQuery('#ct_detail_image_description').parent().parent(),
		$detail_video = jQuery('#ct_detail_video_url').parent().parent(),
		$detail_gallery = jQuery('#ct_detail_gallery_description').parent().parent(),
		$detail_slider = jQuery('#ct_detail_rev_slider_alias').parent().parent(),
		$detail_custom = jQuery('#ct_custom_media').parent().parent();
	var $page_title_style = jQuery('#ct_page_title_style'),
		$page_title_text_two = jQuery('#ct_page_title_two').parent().parent(),
		$page_title_fancy_image = jQuery('#ct_page_title_image_description').parent().parent(),
		$page_title_fancy_text_style = jQuery('#ct_page_title_text_style').parent().parent();
	
	
	// INITAL SHOW/HIDE CONFIG
	if (!$show_coo_slider.is(':checked')) {
		$posts_slider_type.parent().parent().css('display', 'none');
		$slider_posts_category.css('display', 'none');
		$slider_portfolio_category.css('display', 'none');
		$slider_count.css('display', 'none');
		$revslider_alias.css('display', 'block');
		$layerslider_id.css('display', 'block');
	} else {	
		if ($posts_slider_type.val() == "post") {
			$slider_posts_category.css('display', 'block');
			$slider_portfolio_category.css('display', 'none');
		} else if ($posts_slider_type.val() == "portfolio") {
			$slider_posts_category.css('display', 'none');
			$slider_portfolio_category.css('display', 'block');
		} else if ($posts_slider_type.val() == "hybrid") {
			$slider_posts_category.css('display', 'block');
			$slider_portfolio_category.css('display', 'block');
		}
		$revslider_alias.css('display', 'none');
		$layerslider_id.css('display', 'none');
	}
	
	if ($sidebar_config.val() == "no-sidebars") {
		$left_sidebar.css('display', 'none');
		$right_sidebar.css('display', 'none');
	} else if ($sidebar_config.val() == "left-sidebar") {
		$left_sidebar.css('display', 'block');
		$right_sidebar.css('display', 'none');
	} else if ($sidebar_config.val() == "right-sidebar") {
		$right_sidebar.css('display', 'block');
		$left_sidebar.css('display', 'none');
	} else if ($sidebar_config.val() == "both-sidebars") {
		$left_sidebar.css('display', 'block');
		$right_sidebar.css('display', 'block');
	}
	
	if ($thumb_type.val() == "none") {
		$thumb_image.css('display', 'none');
		$thumb_video.css('display', 'none');
		$thumb_gallery.css('display', 'none');
	} else if ($thumb_type.val() == "image") {
		$thumb_image.css('display', 'block');
		$thumb_video.css('display', 'none');
		$thumb_gallery.css('display', 'none');
	} else if ($thumb_type.val() == "video") {
		$thumb_image.css('display', 'none');
		$thumb_video.css('display', 'block');
		$thumb_gallery.css('display', 'none');
	} else if ($thumb_type.val() == "slider") {
		$thumb_image.css('display', 'none');
		$thumb_video.css('display', 'none');
		$thumb_gallery.css('display', 'block');
	}
	
	if ($link_type.val() == "link_to_post") {
		$link_url.css('display', 'none');
		$link_image.css('display', 'none');
		$link_video.css('display', 'none');
	} else if ($link_type.val() == "link_to_url" || $link_type.val() == "link_to_url_nw" ) {
		$link_url.css('display', 'block');
		$link_image.css('display', 'none');
		$link_video.css('display', 'none');
	} else if ($link_type.val() == "lightbox_thumb") {
		$link_url.css('display', 'none');
		$link_image.css('display', 'none');
		$link_video.css('display', 'none');
	} else if ($link_type.val() == "lightbox_image") {
		$link_url.css('display', 'none');
		$link_image.css('display', 'block');
		$link_video.css('display', 'none');
	} else if ($link_type.val() == "lightbox_video") {
		$link_url.css('display', 'none');
		$link_image.css('display', 'none');
		$link_video.css('display', 'block');
	}
	
	if ($use_thumb_content.is(':checked')) {
		$detail_type.parent().parent().css('display', 'none');
		$detail_image.css('display', 'none');
		$detail_video.css('display', 'none');
		$detail_gallery.css('display', 'none');
		$detail_slider.css('display', 'none');
		$detail_custom.css('display', 'none');
	} else {
		$detail_type.parent().parent().css('display', 'block');
		if ($detail_type.val() == "none") {
			$detail_image.css('display', 'none');
			$detail_video.css('display', 'none');
			$detail_gallery.css('display', 'none');
			$detail_slider.css('display', 'none');
			$detail_custom.css('display', 'none');
		} else if ($detail_type.val() == "image") {
			$detail_image.css('display', 'block');
			$detail_video.css('display', 'none');
			$detail_gallery.css('display', 'none');
			$detail_slider.css('display', 'none');
			$detail_custom.css('display', 'none');
		} else if ($detail_type.val() == "video") {
			$detail_image.css('display', 'none');
			$detail_video.css('display', 'block');
			$detail_gallery.css('display', 'none');
			$detail_slider.css('display', 'none');
			$detail_custom.css('display', 'none');
		} else if ($detail_type.val() == "slider") {
			$detail_image.css('display', 'none');
			$detail_video.css('display', 'none');
			$detail_gallery.css('display', 'block');
			$detail_slider.css('display', 'none');
			$detail_custom.css('display', 'none');
		} else if ($detail_type.val() == "layer-slider") {
			$detail_image.css('display', 'none');
			$detail_video.css('display', 'none');
			$detail_gallery.css('display', 'none');
			$detail_slider.css('display', 'block');
			$detail_custom.css('display', 'none');
		} else if ($detail_type.val() == "custom") {
			$detail_image.css('display', 'none');
			$detail_video.css('display', 'none');
			$detail_gallery.css('display', 'none');
			$detail_slider.css('display', 'none');
			$detail_custom.css('display', 'block');
		}
	}

	if ($page_title_style.val() == "standard") {
		$page_title_text_two.css('display', 'none');
		$page_title_fancy_image.css('display', 'none');
		$page_title_fancy_text_style.css('display', 'none');
	}
	
	
	// ON CHANGE SHOW/HIDE CONFIG

	$page_title_style.change(function() {
		if (jQuery(this).val() == "standard") {
			$page_title_text_two.css('display', 'none');
			$page_title_fancy_image.css('display', 'none');
			$page_title_fancy_text_style.css('display', 'none');
		} else {
			$page_title_text_two.css('display', 'block');
			$page_title_fancy_image.css('display', 'block');
			$page_title_fancy_text_style.css('display', 'block');
		}
	});
		
	$sidebar_config.change(function() {
	  if (jQuery(this).val() == "no-sidebars") {
	  	$left_sidebar.css('display', 'none');
	  	$right_sidebar.css('display', 'none');
	  } else if (jQuery(this).val() == "left-sidebar") {
	  	$left_sidebar.css('display', 'block');
	  	$right_sidebar.css('display', 'none');
	  } else if (jQuery(this).val() == "right-sidebar") {
	  	$right_sidebar.css('display', 'block');
	  	$left_sidebar.css('display', 'none');
	  } else if (jQuery(this).val() == "both-sidebars") {
	  	$left_sidebar.css('display', 'block');
	  	$right_sidebar.css('display', 'block');
	  }
	});
	
	$show_coo_slider.change(function() {
		if ($show_coo_slider.is(':checked')) {
			$posts_slider_type.parent().parent().css('display', 'block');
			$slider_count.css('display', 'block');
			if ($posts_slider_type.val() == "post") {
				$slider_posts_category.css('display', 'block');
				$slider_portfolio_category.css('display', 'none');
			} else if ($posts_slider_type.val() == "portfolio") {
				$slider_posts_category.css('display', 'none');
				$slider_portfolio_category.css('display', 'block');
			} else if ($posts_slider_type.val() == "hybrid") {
				$slider_posts_category.css('display', 'block');
				$slider_portfolio_category.css('display', 'block');
			}
			$revslider_alias.css('display', 'none');
			$layerslider_id.css('display', 'none');
		} else {
			$posts_slider_type.parent().parent().css('display', 'none');
			$slider_posts_category.css('display', 'none');
			$slider_portfolio_category.css('display', 'none');
			$slider_count.css('display', 'none');
			$revslider_alias.css('display', 'block');
			$layerslider_id.css('display', 'block');
		}
	});
	
	$posts_slider_type.change(function() {
	  if (jQuery(this).val() == "post") {
	  	$slider_posts_category.css('display', 'block');
	  	$slider_portfolio_category.css('display', 'none');
	  } else if (jQuery(this).val() == "portfolio") {
	  	$slider_posts_category.css('display', 'none');
	  	$slider_portfolio_category.css('display', 'block');
	  } else if (jQuery(this).val() == "hybrid") {
	  	$slider_posts_category.css('display', 'none');
	  	$slider_portfolio_category.css('display', 'none');
	  }
	});
	
	$thumb_type.change(function() {
		if (jQuery(this).val() == "none") {
			$thumb_image.css('display', 'none');
			$thumb_video.css('display', 'none');
			$thumb_gallery.css('display', 'none');
		} else if (jQuery(this).val() == "image") {
			$thumb_image.css('display', 'block');
			$thumb_video.css('display', 'none');
			$thumb_gallery.css('display', 'none');
		} else if (jQuery(this).val() == "video") {
			$thumb_image.css('display', 'none');
			$thumb_video.css('display', 'block');
			$thumb_gallery.css('display', 'none');
		} else if (jQuery(this).val() == "slider") {
			$thumb_image.css('display', 'none');
			$thumb_video.css('display', 'none');
			$thumb_gallery.css('display', 'block');
		}
	});

	$link_type.change(function() {	
		if (jQuery(this).val() == "link_to_post") {
			$link_url.css('display', 'none');
			$link_image.css('display', 'none');
			$link_video.css('display', 'none');
		} else if (jQuery(this).val() == "link_to_url" || $link_type.val() == "link_to_url_nw") {
			$link_url.css('display', 'block');
			$link_image.css('display', 'none');
			$link_video.css('display', 'none');
		} else if (jQuery(this).val() == "lightbox_thumb") {
			$link_url.css('display', 'none');
			$link_image.css('display', 'none');
			$link_video.css('display', 'none');
		} else if (jQuery(this).val() == "lightbox_image") {
			$link_url.css('display', 'none');
			$link_image.css('display', 'block');
			$link_video.css('display', 'none');
		} else if (jQuery(this).val() == "lightbox_video") {
			$link_url.css('display', 'none');
			$link_image.css('display', 'none');
			$link_video.css('display', 'block');
		}
	});
	
	$use_thumb_content.change(function() {
		if ($use_thumb_content.is(':checked')) {
			$detail_type.parent().parent().css('display', 'none');
			$detail_image.css('display', 'none');
			$detail_video.css('display', 'none');
			$detail_gallery.css('display', 'none');
			$detail_slider.css('display', 'none');
			$detail_custom.css('display', 'none');
		} else {
			$detail_type.parent().parent().css('display', 'block');
			if ($detail_type.val() == "none") {
				$detail_image.css('display', 'none');
				$detail_video.css('display', 'none');
				$detail_gallery.css('display', 'none');
				$detail_slider.css('display', 'none');
				$detail_custom.css('display', 'none');
			} else if ($detail_type.val() == "image") {
				$detail_image.css('display', 'block');
				$detail_video.css('display', 'none');
				$detail_gallery.css('display', 'none');
				$detail_slider.css('display', 'none');
				$detail_custom.css('display', 'none');
			} else if ($detail_type.val() == "video") {
				$detail_image.css('display', 'none');
				$detail_video.css('display', 'block');
				$detail_gallery.css('display', 'none');
				$detail_slider.css('display', 'none');
				$detail_custom.css('display', 'none');
			} else if ($detail_type.val() == "slider") {
				$detail_image.css('display', 'none');
				$detail_video.css('display', 'none');
				$detail_gallery.css('display', 'block');
				$detail_slider.css('display', 'none');
				$detail_custom.css('display', 'none');
			} else if ($detail_type.val() == "layer-slider") {
				$detail_image.css('display', 'none');
				$detail_video.css('display', 'none');
				$detail_gallery.css('display', 'none');
				$detail_slider.css('display', 'block');
				$detail_custom.css('display', 'none');
			} else if ($detail_type.val() == "custom") {
				$detail_image.css('display', 'none');
				$detail_video.css('display', 'none');
				$detail_gallery.css('display', 'none');
				$detail_slider.css('display', 'none');
				$detail_custom.css('display', 'block');
			}
		}
	});
	
	$detail_type.change(function() {
		if ($use_thumb_content.is(':checked')) {
			$detail_type.parent().parent().css('display', 'none');
			$detail_image.css('display', 'none');
			$detail_video.css('display', 'none');
			$detail_gallery.css('display', 'none');
			$detail_slider.css('display', 'none');
		} else {
			$detail_type.parent().parent().css('display', 'block');
			if (jQuery(this).val() == "none") {
				$detail_image.css('display', 'none');
				$detail_video.css('display', 'none');
				$detail_gallery.css('display', 'none');
				$detail_slider.css('display', 'none');
			} else if (jQuery(this).val() == "image") {
				$detail_image.css('display', 'block');
				$detail_video.css('display', 'none');
				$detail_gallery.css('display', 'none');
				$detail_slider.css('display', 'none');
			} else if (jQuery(this).val() == "video") {
				$detail_image.css('display', 'none');
				$detail_video.css('display', 'block');
				$detail_gallery.css('display', 'none');
				$detail_slider.css('display', 'none');
			} else if (jQuery(this).val() == "slider") {
				$detail_image.css('display', 'none');
				$detail_video.css('display', 'none');
				$detail_gallery.css('display', 'block');
				$detail_slider.css('display', 'none');
			} else if (jQuery(this).val() == "layer-slider") {
				$detail_image.css('display', 'none');
				$detail_video.css('display', 'none');
				$detail_gallery.css('display', 'none');
				$detail_slider.css('display', 'block');
			} else if ($detail_type.val() == "custom") {
				$detail_image.css('display', 'none');
				$detail_video.css('display', 'none');
				$detail_gallery.css('display', 'none');
				$detail_slider.css('display', 'none');
				$detail_custom.css('display', 'block');
			}
		}
	});
	
	
	
	jQuery('#media-items').bind('DOMNodeInserted',function(){
		jQuery('input[value="Insert into Post"]').each(function(){
				jQuery(this).attr('value','Use This Image');
		});
	});
	
	jQuery('.custom_upload_image_button').click(function() {
		formfield = jQuery(this).siblings('.custom_upload_image');
		preview = jQuery(this).siblings('.custom_preview_image');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			classes = jQuery('img', html).attr('class');
			id = classes.replace(/(.*?)wp-image-/, '');
			formfield.val(id);
			preview.attr('src', imgurl);
			tb_remove();
		}
		return false;
	});
	
	jQuery('.custom_clear_image_button').click(function() {
		var defaultImage = jQuery(this).parent().siblings('.custom_default_image').text();
		jQuery(this).parent().siblings('.custom_upload_image').val('');
		jQuery(this).parent().siblings('.custom_preview_image').attr('src', defaultImage);
		return false;
	});
	
	jQuery('.repeatable-add').click(function() {
		field = jQuery(this).closest('td').find('.custom_repeatable li:last').clone(true);
		fieldLocation = jQuery(this).closest('td').find('.custom_repeatable li:last');
		jQuery('input', field).val('').attr('name', function(index, name) {
			return name.replace(/(\d+)/, function(fullMatch, n) {
				return Number(n) + 1;
			});
		})
		field.insertAfter(fieldLocation, jQuery(this).closest('td'))
		return false;
	});
	
	jQuery('.repeatable-remove').click(function(){
		jQuery(this).parent().remove();
		return false;
	});
	
	
	// ALT BACKGROUND
	
	var altBackgroundValue = jQuery('.rwmb-meta-box').find('#ct_page_title_bg').val();
	if (altBackgroundValue != "") {
		jQuery('.rwmb-meta-box').find('.meta-altbg-preview').addClass(altBackgroundValue);
	}
	
	jQuery('#ct_page_title_bg').live('change',function(){
	    jQuery('.meta-altbg-preview').attr('class', 'meta-altbg-preview');
	    jQuery('.meta-altbg-preview').addClass(jQuery(this).val());
	});
	
	
	// COLOUR SCHEME FUNCTION
	
	jQuery("#ct-export-scheme-dl").click(function(e) {
	
		e.preventDefault(); // prevent link
		
		var the_link = jQuery(this).attr("href");
		
		var file_name = jQuery("#ct-export-scheme-name").val();
		
		if ( file_name ) {
					
			file_name = file_name.replace(/\W/g, ''); // let's attempt to filter this a bit
			
			jQuery("#ct-export-scheme-name").val(file_name);
			
			the_link = the_link + "&file_name=" + file_name;
			
			window.open(the_link);
			
						
		} else {
			
			alert ("You must enter a scheme name.");
			
		}
		
		//console.log ( file_name );
	
	});
	

});