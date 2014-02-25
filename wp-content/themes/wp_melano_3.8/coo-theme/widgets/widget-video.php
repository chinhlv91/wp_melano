<?php
	
	/*
	*
	*	Custom Video Widget
	*	------------------------------------------------
	*	Cootheme
	* 	http://www.cootheme.com
	*
	*/

	class ct_video_widget extends WP_Widget {
		
		function ct_video_widget() {
			$widget_ops = array( 'classname' => 'widget-video', 'description' => 'Embedded video from YouTube, Vimeo, etc' );
			$control_ops = array( 'width' => 250, 'height' => 200, 'id_base' => 'video-widget' ); //default width = 250
			$this->WP_Widget( 'video-widget', 'Cootheme Video Widget', $widget_ops, $control_ops );
		}
	
		function form($instance) {
		$defaults = array( 'title' => 'Video', 'url' => '');
		$instance = wp_parse_args( (array) $instance, $defaults );
	
	?>
			
		<p>
			<label><?php _e('Title', 'coo-theme-admin');?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label><?php _e('Video URL', 'coo-theme-admin');?>:</label>
			<input id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo $instance['url']; ?>" class="widefat" type="text"/>
		</p>
		<p>
			<label><?php _e('Width', 'coo-theme-admin');?>:</label>
			<input id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo $instance['width']; ?>" class="widefat" type="text"/>
		</p>
		<p>
			<label><?php _e('Height', 'coo-theme-admin');?>:</label>
			<input id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>" class="widefat" type="text"/>
		</p>
			
	<?php	
		}
	
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['url'] = strip_tags( $new_instance['url'] );
			$instance['width'] = strip_tags( $new_instance['width'] );
			$instance['height'] = strip_tags( $new_instance['height'] );
			
			return $instance;
		}
		
		function widget($args, $instance) {
			
			extract( $args );
	
			$title = apply_filters('widget_title', $instance['title'] );
			$url = $instance['url'];
			$width = $instance['width'];
			$height = $instance['height'];
			
			echo $before_widget;
			if ( $title ) echo $before_title . $title . $after_title; 
			
			if ($url)
			global $wp_embed;
			$post_embed = $wp_embed->run_shortcode('[embed width="'.$width.'" height="'.$height.'"]'.$url.'[/embed]');
			echo $post_embed;
					
			echo $after_widget;
	
		}
			
	}
	
	add_action( 'widgets_init', 'ct_load_video_widget' );
	
	function ct_load_video_widget() {
		register_widget('ct_video_widget');
	}

?>
